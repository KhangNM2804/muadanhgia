<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BuyRequest;
use App\Http\Requests\Api\DetailOrderRequest;
use App\Http\Requests\Api\OrdersRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\DetailOrderResource;
use App\Http\Resources\OrdersCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Category;
use App\Models\HistoryBuy;
use App\Models\ListSell;
use App\Models\ListSelled;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function categories(){
        $list =  Type::with('allCategory')->where('display',1)->orderBy('sort_num')->whereHas('allCategory')->orderBy('id')->get();
        return new CategoryCollection($list);
    }

    public function types($id){
        $list =  Category::getListByType($id);
        return new ProductCollection($list);
    }

    public function buy(BuyRequest $request){
        $dataInput = $request->all();
        $id_product = $dataInput['id_product'];
        $api_key = $dataInput['api_key'];
        $getType = Category::find($id_product);
        $user = User::where("api_key",$api_key)->first();
        if(!empty($user)){
            if($getType){
                if($dataInput['quantity'] <= 0){
                    return response()->json(['status' => false, "msg" => 'Số lượng tối thiểu lớn hơn 0']);
                }
                if($dataInput['quantity'] > $getType->sell->count()){
                    return response()->json(['status' => false, "msg" => 'Vượt quá số lượng còn lại']);
                }
                $price_origin = $getType->price;
                if($user->chietkhau != 0){
                    $price_origin = $getType->price*(100-$user->chietkhau)/100;
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
                            'type' => $id_product,
                        ];
                        $history_buy = HistoryBuy::create($dataBuy);
                        $getListSell = ListSell::where('type',$id_product)->orderBy('id','asc')->orderBy('updated_at','asc')->take($dataInput['quantity'])->get();
                        $dataBuy = [];
                        if($getListSell){
                            foreach($getListSell as $acc_sell){
                                $dataSelled = [
                                    'buy_id' => $history_buy->id,
                                    'uid' => $acc_sell->uid,
                                    'full_info' => $acc_sell->full_info,
                                    'type' => $acc_sell->type,
                                ];
                                $dataBuy[] = [
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
                        return response()->json(['status' => true, "order_id" => $history_buy->id, 'data' => $dataBuy]);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['status' => false, "msg" => 'Lỗi hệ thống!']);
                    }
                    
                }
            }else{
                return response()->json(['status' => false, "msg" => 'ID Product không tồn tại']);
            }
        }else{
            return response()->json(['status' => false, "msg" => 'api_key không chính xác']);
        }
        
    }
    
    public function orders(OrdersRequest $request){
        $api_key = $request->api_key;
        $user = User::where("api_key",$api_key)->first();
        if(!empty($user)){
            $getHistoryBuy = HistoryBuy::where('user_id', $user->id)->orderBy('created_at','desc')->paginate(10);
            return new OrdersCollection($getHistoryBuy);
        }else{
            return response()->json(['status' => false, "msg" => 'api_key không chính xác']);
        }
    }

    public function detail_order(DetailOrderRequest $request){
        $api_key = $request->api_key;
        $user = User::where("api_key",$api_key)->first();
        if(!empty($user)){
            $getHistoryBuy = HistoryBuy::where('user_id', $user->id)->where('id', $request->order_id)->first();
            if($getHistoryBuy){
                return new DetailOrderResource($getHistoryBuy);
            }else{
                return response()->json(['status' => false, "msg" => 'Đơn hàng không tồn tại']);
            }
        }else{
            return response()->json(['status' => false, "msg" => 'api_key không chính xác']);
        }
    }
    
    public function balance(Request $request){
        $api_key = $request->api_key;
        $user = User::where("api_key",$api_key)->first();
        if(!empty($user)){
            return response()->json(['status' => true, "balance" => $user->coin]);
        }else{
            return response()->json(['status' => false, "msg" => 'api_key không chính xác']);
        }
    }

    public function import(Request $request){
        $api_key = $request->api_key;
        $user = User::where("api_key",$api_key)->first();
        if(!empty($user) && $user->role == 1){
            if (empty($request->text)) {
                return response()->json(['status' => false, "msg" => 'Vui lòng truyền text']);
            }
            if (empty($request->id_product)) {
                return response()->json(['status' => false, "msg" => 'Vui lòng truyền id_product']);
            }
            $cate = Category::find($request->id_product);
            if (empty($cate)) {
                return response()->json(['status' => false, "msg" => 'id_product không tồn tại']);
            }

            $array_uid = ListSell::where('type',$request->id_product)->get()->pluck('uid')->toArray();
            
            $uid = explode("|",$request->text)[0];
            if(in_array($uid, $array_uid)){
                $checkExit = ListSell::where('uid',$uid)->where('type',$request->id_product)->first();
                $checkExit->full_info = $request->text;
                $checkExit->save();
                return response()->json(['status' => true, "msg" => 'Update thành công']);
            }else{
                $dataInsert = [
                    'uid' => $uid,
                    'full_info' =>  $request->text,
                    'type' =>  $request->id_product,
                ];
                ListSell::create($dataInsert);
                return response()->json(['status' => true, "msg" => 'Thêm mới thành công']);
            }
        }else{
            return response()->json(['status' => false, "msg" => 'api_key không chính xác hoặc không có quyền admin']);
        }
    }
}