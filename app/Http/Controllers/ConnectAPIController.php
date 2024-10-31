<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiAddSiteRequest;
use App\Http\Requests\ApiEditSiteRequest;
use App\Models\Category;
use App\Models\ConnectAPI;
use App\Models\HistoryBuy;
use App\Models\Type;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ConnectAPIController extends Controller
{
    protected $system_api = [
        1 => "Trong cùng hệ thống",
        // 2 => "Ngoài hệ thống: muabm365.com, bmtrau,...",
        // 3 => "Hệ thống CMSNT",
    ];
    
    public function index(){
        $apis = ConnectAPI::all();
        $total_subday = HistoryBuy::whereDate('created_at', Carbon::yesterday())->get()->sum('profit');
        $total_date = HistoryBuy::whereDate('created_at', Carbon::today())->get()->sum('profit');
        $total_week = HistoryBuy::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->sum('profit');
        $total_month = HistoryBuy::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get()->sum('profit');
        return view('api_manager.list', compact('apis', 'total_subday', 'total_date', 'total_week', 'total_month'));
    }

    public function add_site(){
        return view('api_manager.add', ['system_api' => $this->system_api]);
    }
    public function edit_site($id){
        $api = ConnectAPI::find($id);
        return view('api_manager.edit', ['system_api' => $this->system_api, 'api' => $api]);
    }

    public function post_add_site(ApiAddSiteRequest $request){
        $data = $request->validated();
        $client = new Client();
        if ($data['system'] == 1) {
            $rq = $client->request('POST', $data['domain']. '/api/v1/balance', [
                'json' => [
                    'api_key' => $data['api_key'],
                ]
            ]);
            $result = json_decode($rq->getBody()->getContents(), true);
            if ($result && $result['status']) {
                $data['balance'] = $result['balance'];
                ConnectAPI::create($data);
                return redirect()->route('list_api_connect')->with('success','Thêm website đấu api thành công!');
            } else {
                return redirect()->route('api_add_site')->with('add_fail' , 'Thông tin không chính xác');
            }
        }
        if ($data['system'] == 2) {
            $rq = $client->request('GET', $data['domain']. '/api.php?apikey='.$data['api_key'].'&action=get-balance');
            $result = json_decode($rq->getBody()->getContents(), true);
            if ($result && isset($result['message']) && $result['message'] == 'success') {
                $data['balance'] = $result['balance'];
                ConnectAPI::create($data);
                return redirect()->route('list_api_connect')->with('success','Thêm website đấu api thành công!');
            } else {
                return redirect()->route('api_add_site')->with('add_fail' , 'Thông tin không chính xác');
            }
        }
        if ($data['system'] == 3) {
            $rq = $client->request('GET', $data['domain']. '/api/GetBalance.php?username='.$data['username'].'&password='.$data['password']);
            $result = $rq->getBody()->getContents();
            $result = str_replace("đ", "", $result);
            $result = str_replace(".", "", $result);
            $result = intval($result);
            if ($result == 0) {
                return redirect()->route('api_add_site')->with('add_fail' , 'Thông tin không chính xác hoặc số dư bằng 0');
            } elseif ($result > 0) {
                $data['balance'] = $result;
                ConnectAPI::create($data);
                return redirect()->route('list_api_connect')->with('success','Thêm website đấu api thành công!');
            }
        }
        
    }

    public function post_edit_site(ApiEditSiteRequest $request, $id){
        $data = $request->validated();
        $client = new Client();
        $connect_api = ConnectAPI::find($id);
        if ($connect_api->system == 1) {
            $rq = $client->request('POST', $data['domain']. '/api/v1/balance', [
                'json' => [
                    'api_key' => $data['api_key'],
                ]
            ]);
        }
        if ($connect_api->system == 2) {
            $rq = $client->request('GET', $data['domain']. '/api.php?apikey='.$data['api_key'].'&action=get-balance');
        }
        if ($connect_api->system == 3) {
            $rq = $client->request('GET', $data['domain']. '/api/GetBalance.php?username='.$data['username'].'&password='.$data['password']);
        }
        
        if ($connect_api->system == 1 || $connect_api->system == 2) {
            $result = json_decode($rq->getBody()->getContents(), true);
            if ($result) {
                $dataUpdate = $request->all();
                unset($dataUpdate['_token']);
                if(!isset($dataUpdate['auto_change_name'])){
                    $dataUpdate['auto_change_name'] = 0;
                }
                Type::where('connect_api_id', $id)->update(['display'=> 1]);
                Category::where('connect_api_id', $id)->update(['display'=> 1]);
                if(!isset($dataUpdate['active'])){
                    $dataUpdate['active'] = 0;
                    Type::where('connect_api_id', $id)->update(['display'=> 0]);
                    Category::where('connect_api_id', $id)->update(['display'=> 0]);
                }
                ConnectAPI::where("id",$id)
                            ->update($dataUpdate);
                if ((isset($result['status']) && !$result['status']) || (isset($result['code']) && $result['code'] == -1)) {
                    ConnectAPI::where("id",$id)
                            ->update(['active' => 0]);
                    Type::where('connect_api_id', $id)->update(['display'=> 0]);
                    Category::where('connect_api_id', $id)->update(['display'=> 0]);
                    return redirect()->route('api_edit_site', ['id' => $id])->with('fail' , 'Thông tin API_KEY không chính xác');
                }
                return redirect()->route('list_api_connect')->with('success','Chỉnh sửa website thành công!');
            } else {
                return redirect()->route('api_edit_site', ['id' => $id])->with('fail' , 'Thông tin không chính xác');
            }
        } elseif ($connect_api->system == 3) {
            $result = $rq->getBody()->getContents();
            $result = str_replace("đ", "", $result);
            $result = str_replace(".", "", $result);
            $result = intval($result);

            $dataUpdate = $request->all();
            unset($dataUpdate['_token']);
            if(!isset($dataUpdate['auto_change_name'])){
                $dataUpdate['auto_change_name'] = 0;
            }
            Type::where('connect_api_id', $id)->update(['display'=> 1]);
            Category::where('connect_api_id', $id)->update(['display'=> 1]);
            if(!isset($dataUpdate['active'])){
                $dataUpdate['active'] = 0;
                Type::where('connect_api_id', $id)->update(['display'=> 0]);
                Category::where('connect_api_id', $id)->update(['display'=> 0]);
            }
            ConnectAPI::where("id",$id)
                        ->update($dataUpdate);
            if ($result == 0) {
                ConnectAPI::where("id",$id)
                        ->update(['active' => 0]);
                Type::where('connect_api_id', $id)->update(['display'=> 0]);
                Category::where('connect_api_id', $id)->update(['display'=> 0]);
                return redirect()->route('api_edit_site', ['id' => $id])->with('fail' , 'Thông tin không chính xác hoặc số dư bằng 0');
            }
            return redirect()->route('list_api_connect')->with('success','Chỉnh sửa website thành công!');
        }
    }

    public function get_category($id){
        $api = ConnectAPI::find($id);
        $categories = Type::where('is_api', 1)->where('connect_api_id', $id)->get();
        return view('api_manager.category.list', compact('api', 'categories'));
    }

    public function get_product($id){
        $api = ConnectAPI::find($id);
        $products = Category::where('is_api', 1)->where('connect_api_id', $id)->get();
        return view('api_manager.product.list', compact('api', 'products'));
    }

    public function re_sync($id) {
        $client = new Client();
        $website_apis = ConnectAPI::where('id', $id)->get();
        if ($website_apis) {
            foreach ($website_apis as $api) {
                if ($api->system == 1) {
                    $rq = $client->request('POST', $api->domain. '/api/v1/balance', [
                        'json' => [
                            'api_key' => $api->api_key,
                        ]
                    ]);
                    $result = json_decode($rq->getBody()->getContents(), true);
                    if ($result && $result['status']) {
                        $api->balance = $result['balance'];
                        $api->save();
                        $rq_category = $client->request('GET', $api->domain. '/api/v1/categories');
                        $result_category = json_decode($rq_category->getBody()->getContents(), true);
                        if ($result_category && $result_category['data']) {
                            foreach($result_category['data'] as $category){
                                $exits_cate = Type::where('connect_api_id', $api->id)->where('origin_api_id', $category['id'])->first();
                                if (!$exits_cate) {
                                    $exits_cate = Type::create([
                                        'name' => $category['name'],
                                        'icon' => $category['icon'] ? explode('/', $category['icon'])[5] : null,
                                        'is_api' => 1,
                                        'connect_api_id' => $api->id,
                                        'origin_api_id' => $category['id'],
                                    ]);
                                } else {
                                    if ($api->auto_change_name) {
                                        $exits_cate->name = $category['name'];
                                        $exits_cate->icon = $category['icon'] ? explode('/', $category['icon'])[5] : null;
                                        $exits_cate->save();
                                    }
                                }
                                if (isset($category['list_product']) && !empty($category['list_product'])) {
                                    foreach ($category['list_product'] as $key => $product) {
                                        $exits_product = Category::where('connect_api_id', $api->id)->where('origin_api_id', $product['id_product'])->first();

                                        if (!$exits_product) {
                                            $exits_product = Category::create([
                                                'name' => $product['name'],
                                                'desc' => $product['desc'],
                                                'long_desc' => $product['long_desc'] ?? null,
                                                'is_api' => 1,
                                                'type' => $exits_cate->id,
                                                'connect_api_id' => $api->id,
                                                'origin_api_id' => $product['id_product'],
                                                'origin_price' => $product['price'],
                                                'quantity_remain' => $product['quantity'],
                                                'price' => $product['price'] + $product['price'] * $api->auto_price/100,
                                            ]);
                                        } else {
                                            if ($api->auto_change_name) {
                                                $exits_product->name = $product['name'];
                                                $exits_product->desc = $product['desc'];
                                                $exits_product->long_desc = $product['long_desc'] ?? null;
                                            }
                                            if ($api->auto_price != 0) {
                                                $exits_product->price = $product['price'] + $product['price'] * $api->auto_price/100;
                                            }
                                            $exits_product->origin_price = $product['price'];
                                            $exits_product->quantity_remain = $product['quantity'];
                                            $exits_product->save();
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $api->active = 0;
                        $api->save();
                        return response()->json(['status' => false, 'msg' => 'API KEY không đúng']);
                    }
                }
                if ($api->system == 2) {
                    $rq = $client->request('GET', $api->domain. '/api.php?apikey='.$api->api_key.'&action=get-balance');
                    $result = json_decode($rq->getBody()->getContents(), true);
                    if ($result && $result['balance'] && $result['message'] && $result['message'] == 'success') {
                        $api->balance = $result['balance'];
                        $api->save();
                        $rq_category = $client->request('GET', $api->domain. '/api.php?apikey='.$api->api_key.'&action=get-services');
                        $result_category = json_decode($rq_category->getBody()->getContents(), true);
                        if ($result_category && $result_category['message'] && $result_category['message'] == 'success' && $result_category['data']) {
                            $exits_cate = Type::where('connect_api_id', $api->id)->first();
                            if (!$exits_cate) {
                                $exits_cate = Type::create([
                                    'name' => 'Danh mục tạm từ '.$api->domain,
                                    'icon' => null,
                                    'is_api' => 1,
                                    'connect_api_id' => $api->id,
                                    'display' => 0,
                                ]);
                            }
                            foreach($result_category['data'] as $product){
                                $exits_product = Category::where('connect_api_id', $api->id)->where('origin_api_id', $product['service_id'])->first();
                                if (!$exits_product) {
                                    $exits_product = Category::create([
                                        'name' => $product['service_name'],
                                        'desc' => $product['description'],
                                        'long_desc' => null,
                                        'is_api' => 1,
                                        'type' => $exits_cate->id,
                                        'connect_api_id' => $api->id,
                                        'origin_api_id' => $product['service_id'],
                                        'origin_price' => $product['price'],
                                        'quantity_remain' => $product['quantity'],
                                        'price' => $product['price'] + $product['price'] * $api->auto_price/100,
                                    ]);
                                } else {
                                    if ($api->auto_change_name) {
                                        $exits_product->name = $product['service_name'];
                                        $exits_product->desc = $product['description'];
                                    }
                                    if ($api->auto_price != 0) {
                                        $exits_product->price = $product['price'] + $product['price'] * $api->auto_price/100;
                                    }
                                    $exits_product->origin_price = $product['price'];
                                    $exits_product->quantity_remain = $product['quantity'];
                                    $exits_product->save();
                                }
                            }
                        }
                    } else {
                        $api->active = 0;
                        $api->save();
                    }
                }
                if ($api->system == 3) {
                    $rq = $client->request('GET', $api->domain. '/api/GetBalance.php?username='.$api->username.'&password='.$api->password);
                    $result = $rq->getBody()->getContents();
                    $result = str_replace("đ", "", $result);
                    $result = str_replace(".", "", $result);
                    $result = intval($result);
                    if ($result > 0) {
                        $api->balance = $result;
                        $api->save();
                        $rq_category = $client->request('GET', $api->domain. '/api/ListResource.php?username='.$api->username.'&password='.$api->password);
                        $result_category = json_decode($rq_category->getBody()->getContents(), true);
                        if ($result_category && $result_category['status'] && $result_category['status'] == 'success') {
                            foreach($result_category['categories'] as $category){
                                $exits_cate = Type::where('connect_api_id', $api->id)->where('origin_api_id', $category['id'])->first();
                                if (!$exits_cate) {
                                    $exits_cate = Type::create([
                                        'name' => $category['name'],
                                        'icon' => null,
                                        'is_api' => 1,
                                        'connect_api_id' => $api->id,
                                        'origin_api_id' => $category['id'],
                                    ]);
                                } else {
                                    if ($api->auto_change_name) {
                                        $exits_cate->name = $category['name'];
                                        $exits_cate->icon = null;
                                        $exits_cate->save();
                                    }
                                }
                                if (isset($category['accounts']) && !empty($category['accounts'])) {
                                    foreach ($category['accounts'] as $key => $product) {
                                        $exits_product = Category::where('connect_api_id', $api->id)->where('origin_api_id', $product['id'])->first();
                                        if (!$exits_product) {
                                            $exits_product = Category::create([
                                                'name' => $product['name'],
                                                'desc' => $product['description'],
                                                'long_desc' => null,
                                                'is_api' => 1,
                                                'type' => $exits_cate->id,
                                                'connect_api_id' => $api->id,
                                                'origin_api_id' => $product['id'],
                                                'origin_price' => $product['price'],
                                                'quantity_remain' => $product['amount'],
                                                'price' => $product['price'] + $product['price'] * $api->auto_price/100,
                                            ]);
                                        } else {
                                            if ($api->auto_change_name) {
                                                $exits_product->name = $product['name'];
                                                $exits_product->desc = $product['description'];
                                            }
                                            if ($api->auto_price != 0) {
                                                $exits_product->price = $product['price'] + $product['price'] * $api->auto_price/100;
                                            }
                                            $exits_product->origin_price = $product['price'];
                                            $exits_product->quantity_remain = $product['amount'];
                                            $exits_product->save();
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $api->active = 0;
                        $api->save();
                    }
                }
            }
        }
        return response()->json(['status' => true]);
    }

    public function ajax_product_update_price(Request $request) {
        $dataRequest = $request->all();
        $type = Category::where('connect_api_id', $dataRequest['api_id'])->where('id', $dataRequest['product_id'])->first();
        if ($type) {
            $type->price = $dataRequest['price'];
            $type->save();
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function get_orders(Request $request, $id) {
        $api = ConnectAPI::find($id);
        abort_if(!$api, 404);
        $getHistoryBuy = HistoryBuy::where('is_api', 1)->where('connect_api_id', $id)->orderBy('created_at','desc')->paginate(10);
        return view('api_manager.order.list', compact('api', 'getHistoryBuy'));
    }
}