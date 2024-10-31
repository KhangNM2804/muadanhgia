<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\ConnectAPI;
use App\Models\Type;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SyncProductAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync-product-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command sync product api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $website_apis = ConnectAPI::where('active', 1)->get();
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
    }
}