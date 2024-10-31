<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateSellRequest;
use App\Models\Category;
use App\Models\HistoryBuy;
use App\Models\HistoryImport;
use App\Models\LimitBuy;
use App\Models\ListSell;
use App\Models\ListSelled;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use ZipArchive;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index(){
        $categorys = Category::all();
        return view('category.index', compact('categorys'));
    }

    public function create(){
        $types = Type::where('display',1)->get();
        return view('category.create', compact('types'));
    }

    public function post_create(CreateCategoryRequest $request){
        Category::create($request->all());
        return redirect()->route('category_index')->with('success','Tạo thể loại thành công!');
    }

    public function edit($id){
        $getCate = Category::find($id);
        $types = Type::where('display',1)->get();
        if(empty($getCate)){
            abort(404);
        }
        return view('category.edit', compact('getCate','types'));
    }


    public function post_edit(CreateCategoryRequest $request, $id){
        $dataUpdate = $request->all();
        unset($dataUpdate['_token']);
        if(!isset($dataUpdate['display'])){
            $dataUpdate['display'] = 0;
        }
        Category::where("id",$id)
                    ->update($dataUpdate);
        return redirect()->route('category_index')->with('success','Chỉnh sửa thể loại thành công!');
    }

    public function import(){
        $max_execution_time = ini_get('max_execution_time');
        $post_max_size = ini_get('post_max_size');
        $categorys = Category::where('display',1)->where('is_api', 0)->get();
        $histories = HistoryImport::orderBy('id', 'DESC')->paginate(10);
        return view('category.import', compact('categorys', 'max_execution_time', 'post_max_size', 'histories'));
    }

    public function history_buy(){
        $user = Auth::user();
        $getHistoryBuy = HistoryBuy::where('user_id', $user->id)->orderBy('created_at','desc')->paginate(10);
        return view('category.history_buy', compact('getHistoryBuy'));
    }

    public function don_hang($id){
        $user = Auth::user();
        $getHistoryBuy = HistoryBuy::where('user_id', $user->id)
                                    ->where('id',$id)->first();
        if($user->role == 1 || $user->role == 2){
            $getHistoryBuy = HistoryBuy::withTrashed()->where('id',$id)->first();
        }
        if(!$getHistoryBuy){
            abort(404);
        }
        $getHistoryBuy->setRelation('getSelled', $getHistoryBuy->getSelled()->paginate(10));
        return view('category.donhang', compact('getHistoryBuy'));
    }

    public function export_txt($id){
        $user = Auth::user();
        $getHistoryBuy = HistoryBuy::where('user_id', $user->id)
                                    ->where('id',$id)->first();
        if($user->role == 1 || $user->role == 2){
            $getHistoryBuy = HistoryBuy::withTrashed()->where('id',$id)->first();
        }
        if(!$getHistoryBuy){
            abort(404);
        }
        $content = "";
        if($getHistoryBuy->getSelled){
            foreach($getHistoryBuy->getSelled as $item){
                $content .= $item->full_info."\n";
            }
        }
        $fileName = "logs_order_id_".$getHistoryBuy->id.".txt";
        return response($content)
                ->withHeaders([
                    'Content-Type' => 'text/plain',
                    'Cache-Control' => 'no-store, no-cache',
                    'Content-Disposition' => 'attachment; filename='.$fileName,
                ]);
    }

    public function export_data_sell($id){
        $listSell = ListSell::where('type',$id)->get();
        
        $content = "";
        if(!empty($listSell)){
            foreach($listSell as $item){
                $content .= $item->full_info."\n";
            }
        }
        $fileName = "log_data_sell_id".$id.".txt";
        return response($content)
                ->withHeaders([
                    'Content-Type' => 'text/plain',
                    'Cache-Control' => 'no-store, no-cache',
                    'Content-Disposition' => 'attachment; filename='.$fileName,
                ]);
    }

    public function download_zip_backup($id){
        $user = Auth::user();
        $getHistoryBuy = HistoryBuy::where('user_id', $user->id)
                                    ->where('id',$id)->first();
        if(!$getHistoryBuy){
            abort(404);
        }

        $zip_file = 'backup_order_'.$id.'.zip';
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        if($getHistoryBuy->getSelled){
            foreach($getHistoryBuy->getSelled as $item){
                $filename_temp1 = storage_path().'/'.'app'.'/backup_file/'.$item->uid.'.html';
                if (file_exists($filename_temp1)) {
                    $zip->addFile($filename_temp1, 'backup_order_'.$id.'/'.$item->uid.'.html');
                }
            }
        }

        $zip->close();
        return response()->download($zip_file)->deleteFileAfterSend(true);
        
    }

    public function download_backup($buy_id,$uid){
        $getSelled = ListSelled::where('uid',$uid)->where('buy_id',$buy_id)->orderBy('created_at','desc')->first();
        $user = Auth::user();
        $getHistoryBuy = HistoryBuy::where('user_id', $user->id)
                                    ->where('id',$buy_id)->first();
        if(empty($getSelled)){
            abort(404);
        }
        if(empty($getHistoryBuy)){
            abort(404);
        }

        
        $filename_temp1 = storage_path().'/'.'app'.'/backup_file/'.$uid.'.html';
        $filename_temp2 = storage_path().'/'.'app'.'/backup_file/mhcp_backup_'.$uid.'.html';
        $filename_temp3 = storage_path().'/'.'app'.'/backup_file/'.$uid.'-backup.html';
        $filename_temp4 = storage_path().'/'.'app'.'/backup_file/K49Backup_'.$uid.'.html';
        if (file_exists($filename_temp1)) {
            return response()->download($filename_temp1);
        }else if (file_exists($filename_temp2)) {
            return response()->download($filename_temp2);
        }else if (file_exists($filename_temp3)) {
            return response()->download($filename_temp3);
        }else if (file_exists($filename_temp4)) {
            return response()->download($filename_temp4);
        }else{
            abort(404);
        }
    }

    public function download_phoi($buy_id,$uid){
        $getSelled = ListSelled::where('uid',$uid)->where('buy_id',$buy_id)->orderBy('created_at','desc')->first();
        $user = Auth::user();
        $getHistoryBuy = HistoryBuy::where('user_id', $user->id)
                                    ->where('id',$buy_id)->first();
        if(empty($getSelled)){
            abort(404);
        }
        if(empty($getHistoryBuy)){
            abort(404);
        }

        
        $filename_temp1 = storage_path().'/'.'app'.'/phoivia/'.$uid.'.jpg';
        if (file_exists($filename_temp1)) {
            return response()->download($filename_temp1);
        }else{
            abort(404);
        }
    }

    public function ajax_import(Request $request){
        $dataInput = $request->all();
        $list_ids = explode("\n",$dataInput['list_id']);
        $insert = 0;
        $update = 0;
        $list_insert = '';
        $list_update = '';
        $list_ids = array_filter($list_ids);
        $total = count($list_ids);
        if($list_ids){
            $array_uid = ListSell::where('type',$dataInput['loai'])->get()->pluck('uid')->toArray();
            foreach ($list_ids as $item) {
                if(!empty($item)){
                    $uid = explode("|",$item)[0];
                    // $checkExit = ListSell::where('uid',$uid)->where('type',$dataInput['loai'])->first();
                    if(in_array($uid, $array_uid)){
                        $checkExit = ListSell::where('uid',$uid)->where('type',$dataInput['loai'])->first();
                        $checkExit->full_info = $item;
                        $checkExit->save();
                        $update++;
                        $list_update .= $item."\n";
                    }else{
                        $dataInsert = [
                            'uid' => $uid,
                            'full_info' => $item,
                            'type' => $dataInput['loai'],
                        ];
                        ListSell::create($dataInsert);
                        $insert++;
                        $list_insert .= $item."\n";
                        $array_uid[] = $uid;
                    }
                }
            }

            $category = Category::find($dataInput['loai']);
            HistoryImport::create([
                'category_id' => $category->id,
                'name' => $category->name,
                'amount' => $insert + $update,
            ]);
        }
        return response()->json(['status' => true, "total" => $total, 'insert' => $insert, 'update' => $update, 'list_update' => $list_update, 'list_insert' => $list_insert]);
    }
    
    public function ajax_buy(Request $request){
        $dataInput = $request->all();
        if(isset($dataInput['type_id']) && !empty($dataInput['type_id'])){
            $type_id = $dataInput['type_id'];
            $getType = Category::find($type_id);
            
            if($getType){
                if ($getType->is_api) {
                    $client = new Client();
                    if($dataInput['quantity'] <= 0){
                        return response()->json(['status' => false, "msg" => 'Số lượng tối thiểu lớn hơn 0']);
                    }
                    if ($getType->min_can_buy && $dataInput['quantity'] < $getType->min_can_buy) {
                        return response()->json(['status' => false, "msg" => 'Số lượng tối thiểu là '.$getType->min_can_buy]);
                    }
                    if($dataInput['quantity'] > $getType->quantity_remain){
                        return response()->json(['status' => false, "msg" => 'Bạn mua vượt qua số lượng còn lại']);
                    }
                    $user = Auth::user();
                    $price_origin = $getType->price;
                    if($user->chietkhau != 0){
                        $price_origin = $getType->price*(100-Auth::user()->chietkhau)/100;
                    }
                    $total_money = $dataInput['quantity'] * $price_origin;
                    if($user->coin < $total_money){
                        return response()->json(['status' => false, "msg" => 'Số dư không đủ!']);
                    }else{
                        try {
                            DB::beginTransaction();
                            $connect_api = $getType->connect_api;
                            if ($connect_api->system == 1) {
                                $rq = $client->request('POST', $connect_api->domain. '/api/v1/buy', [
                                    'json' => [
                                        'api_key' => $connect_api->api_key,
                                        'id_product' => $getType->origin_api_id,
                                        'quantity' => $dataInput['quantity'],
                                    ]
                                ]);
                                $result = json_decode($rq->getBody()->getContents(), true);
                                if ($result && $result['status'] && $result['data']) {
                                    $updateUser = User::find($user->id);
                                    $updateUser->coin -= $total_money;
                                    $updateUser->save();
                                    
                                    $dataBuy = [
                                        'user_id' => $user->id,
                                        'quantity' => $dataInput['quantity'],
                                        'price' => $price_origin,
                                        'total_price' => $price_origin * $dataInput['quantity'],
                                        'type' => $type_id,
                                        'is_api' => 1,
                                        'connect_api_id' => $connect_api->id,
                                        'price_api' => $getType->origin_price,
                                        'price_actual' => $getType->origin_price * $dataInput['quantity'],
                                        'profit' => $price_origin * $dataInput['quantity'] - $getType->origin_price * $dataInput['quantity'],
                                    ];
                                    $history_buy = HistoryBuy::create($dataBuy);
    
                                    foreach($result['data'] as $acc_sell){
                                        $dataSelled = [
                                            'buy_id' => $history_buy->id,
                                            'uid' => $acc_sell['uid'],
                                            'full_info' => $acc_sell['full_info'],
                                            'type' => $type_id,
                                        ];
                                        ListSelled::create($dataSelled);
                                    }
                                    DB::commit();
                                    return response()->json(['status' => true, "order_id" => $history_buy->id]);
                                } else {
                                    return response()->json(['status' => false, "msg" => $result['msg'] ?? 'Lỗi hệ thống!']);
                                }
                            }
                            if ($connect_api->system == 2) {
                                $rq = $client->request('GET', $connect_api->domain. '/api.php?apikey='.$connect_api->api_key.'&action=create-order&service_id='.$getType->origin_api_id.'&amount='.$dataInput['quantity']);
                                $result = json_decode($rq->getBody()->getContents(), true);
                                if ($result && isset($result['code']) && $result['code'] == 200 && isset($result['order_id'])) {
                                    $rq_detail_order = $client->request('GET', $connect_api->domain. '/api.php?apikey='.$connect_api->api_key.'&action=get-order-detail&order_id='.$result['order_id']);
                                    $result_detail_order = json_decode($rq_detail_order->getBody()->getContents(), true);
                                    if ($result_detail_order && isset($result_detail_order['message']) && $result_detail_order['message'] == 'success') {
                                        $updateUser = User::find($user->id);
                                        $updateUser->coin -= $total_money;
                                        $updateUser->save();
                                        
                                        $dataBuy = [
                                            'user_id' => $user->id,
                                            'quantity' => $dataInput['quantity'],
                                            'price' => $price_origin,
                                            'total_price' => $price_origin * $dataInput['quantity'],
                                            'type' => $type_id,
                                            'is_api' => 1,
                                            'connect_api_id' => $connect_api->id,
                                            'price_api' => $getType->origin_price,
                                            'price_actual' => $getType->origin_price * $dataInput['quantity'],
                                            'profit' => $price_origin * $dataInput['quantity'] - $getType->origin_price * $dataInput['quantity'],
                                        ];
                                        $history_buy = HistoryBuy::create($dataBuy);

                                        $data_order = explode("\n", $result_detail_order['order']['data']);
                                        array_shift($data_order);
        
                                        foreach($data_order as $acc_sell){
                                            if ($acc_sell) {
                                                $dataSelled = [
                                                    'buy_id' => $history_buy->id,
                                                    'uid' => explode('|', $acc_sell)[0] ?? $acc_sell,
                                                    'full_info' => $acc_sell,
                                                    'type' => $type_id,
                                                ];
                                                ListSelled::create($dataSelled);
                                            }
                                        }
                                        DB::commit();
                                        return response()->json(['status' => true, "order_id" => $history_buy->id]);
                                    }
                                } else {
                                    return response()->json(['status' => false, "msg" => $result['msg'] ?? 'Lỗi hệ thống!']);
                                }
                            }
                            if ($connect_api->system == 3) {
                                $rq = $client->request('GET', $connect_api->domain. '/api/BResource.php?username='.$connect_api->username.'&password='.$connect_api->password.'&id='.$getType->origin_api_id.'&amount='.$dataInput['quantity']);
                                $result = json_decode($rq->getBody()->getContents(), true);
                                if ($result && isset($result['status']) && $result['status'] == 'success') {
                                    $updateUser = User::find($user->id);
                                    $updateUser->coin -= $total_money;
                                    $updateUser->save();
                                    
                                    $dataBuy = [
                                        'user_id' => $user->id,
                                        'quantity' => $dataInput['quantity'],
                                        'price' => $price_origin,
                                        'total_price' => $price_origin * $dataInput['quantity'],
                                        'type' => $type_id,
                                        'is_api' => 1,
                                        'connect_api_id' => $connect_api->id,
                                        'price_api' => $getType->origin_price,
                                        'price_actual' => $getType->origin_price * $dataInput['quantity'],
                                        'profit' => $price_origin * $dataInput['quantity'] - $getType->origin_price * $dataInput['quantity'],
                                    ];
                                    $history_buy = HistoryBuy::create($dataBuy);
    
                                    foreach($result['data']['lists'] as $acc_sell){
                                        $dataSelled = [
                                            'buy_id' => $history_buy->id,
                                            'uid' => explode('|', $acc_sell['account'])[0],
                                            'full_info' => $acc_sell['account'],
                                            'type' => $type_id,
                                        ];
                                        ListSelled::create($dataSelled);
                                    }
                                    DB::commit();
                                    return response()->json(['status' => true, "order_id" => $history_buy->id]);
                                } else {
                                    return response()->json(['status' => false, "msg" => $result['msg'] ?? 'Lỗi hệ thống!']);
                                }
                            }
                        } catch (\Exception $e) {
                            DB::rollback();
                            return response()->json(['status' => false, "msg" => 'Lỗi hệ thống!']);
                        }
                        
                    }
                } else {
                    if($dataInput['quantity'] <= 0){
                        return response()->json(['status' => false, "msg" => 'Số lượng tối thiểu lớn hơn 0']);
                    }
                    if ($getType->min_can_buy && $dataInput['quantity'] < $getType->min_can_buy) {
                        return response()->json(['status' => false, "msg" => 'Số lượng tối thiểu là '.$getType->min_can_buy]);
                    }
                    if($dataInput['quantity'] > $getType->sell->count()){
                        return response()->json(['status' => false, "msg" => 'Bạn mua vượt qua số lượng còn lại']);
                    }
                    $user = Auth::user();
                    $price_origin = $getType->price;
                    if($user->chietkhau != 0){
                        $price_origin = $getType->price*(100-Auth::user()->chietkhau)/100;
                    }
                    $total_money = $dataInput['quantity'] * $price_origin;
                    if($user->coin < $total_money){
                        return response()->json(['status' => false, "msg" => 'Số dư không đủ!']);
                    }else{
                        try {
                            DB::beginTransaction();
                            //xử lý
                            $updateUser = User::find($user->id);
                            $updateUser->coin -= $total_money;
                            $updateUser->save();
    
                            $dataBuy = [
                                'user_id' => $user->id,
                                'quantity' => $dataInput['quantity'],
                                'price' => $price_origin,
                                'total_price' => $price_origin * $dataInput['quantity'],
                                'type' => $type_id,
                            ];
                            $history_buy = HistoryBuy::create($dataBuy);
                            $getListSell = ListSell::where('type',$type_id)->orderBy('id','asc')->orderBy('updated_at','asc')->take($dataInput['quantity'])->get();
                            if($getListSell){
                                foreach($getListSell as $acc_sell){
                                    $dataSelled = [
                                        'buy_id' => $history_buy->id,
                                        'uid' => $acc_sell->uid,
                                        'full_info' => $acc_sell->full_info,
                                        'type' => $acc_sell->type,
                                    ];
                                    ListSelled::create($dataSelled);
                                    $acc_sell->delete();
                                }
                            }
                            DB::commit();
                            return response()->json(['status' => true, "order_id" => $history_buy->id]);
                        } catch (\Exception $e) {
                            DB::rollback();
                            return response()->json(['status' => false, "msg" => 'Lỗi hệ thống!']);
                        }
                        
                    }
                }
            }else{
                return response()->json(['status' => false, "msg" => 'Vui lòng chọn type!']);
            }
        }else{
            return response()->json(['status' => false, "msg" => 'Vui lòng chọn type!']);
        }
    }

    public function listviasell(Request $request){
        $listsell = ListSell::orderby('id','DESC')
                    ->when($request->uid, function ($query) use ($request) {
                        $query->where('uid',$request->uid);
                    })->paginate(30);
        return view('listsell.index', compact('listsell'));
    }

    public function listviasell_update($id){
        $categorys = Category::where('display',1)->get();
        $sell = ListSell::find($id);
        return view('listsell.update', compact('sell', 'categorys'));
    }

    public function listviasell_postupdate(UpdateSellRequest $request, $id){
        $sell = ListSell::find($id);
        if($sell){
            $sell->type = $request->select_type;
            $sell->full_info = $request->full_info;
            $sell->uid = explode("|",$request->full_info)[0] ?? "";
            $sell->save();
        }
        return redirect()->route('get_listviasell')->with('success','Chỉnh sửa thành công!');
    }
    public function listviasell_delete($id){
        $sell = ListSell::find($id);
        if($sell){
            $sell->delete();
        }
        return response()->json(['status' => true]);
    }

    public function getDetail($id){
        $category = Category::find($id);
        $result = view('category.description', ['item' => $category])->render();
        return response()->json(['result' => $result]);
    }
}