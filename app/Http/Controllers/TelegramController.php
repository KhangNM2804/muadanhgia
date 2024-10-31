<?php

namespace App\Http\Controllers;

use App\Models\HistoryBuy;
use App\Models\User;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function webhook()
    {
        $update = json_decode(file_get_contents("php://input"), TRUE);

        $chatId = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];

        if (strpos($message, "/start") === 0) {
            $msg = "/ketnoi {username} để tạo mã kết nối telegram\n";
            $msg .= "/huyketnoi để huỷ kết nối với telegram\n";
            $msg .= "/xacthuc {mã kết nối telegram} để hoàn tất việc kết nối tài khoản\n";
            $msg .= "/taikhoan để xem thông tin tài khoản\n";
            $msg .= "/donhang để xem danh sách đơn hàng\n ";
            $msg .= "/xemdonhang {id} để xem chi tiết đơn hàng\n ";
            
            $this->sendMsg($chatId, $msg);
        }
        //xác thực
        if (strpos($message, "/ketnoi") === 0) {
            $user = User::where('tele_chat_id', $chatId)->first();
            if ($user) {
                $msg = "Tài khoản này đã kết nối với hệ thống";
            } else {
                preg_match('/\/ketnoi (\w*)/', $message, $transarr);
                if (count($transarr)) {
                    $user = User::where('username', $transarr[1])->first();
                    if ($user) {
                        $user->verifycodetele = uniqid() . time();
                        $user->save();
                        $msg = "Vui lòng truy cập vào " . route('account') . " để lấy mã kết nối\n";
                        $msg .= "Sau đó quay lại đây gõ /xacthuc {mã kết nối telegram}";
                    } else {
                        $msg = "User: " . $transarr[1] . " không được tìm thấy";
                    }
                } else {
                    $msg = "Username chưa được nhập hoặc không được tìm thấy";
                }
            }

            $this->sendMsg($chatId, $msg);
        }
        if (strpos($message, "/huyketnoi") === 0) {
            $user = User::where('tele_chat_id', $chatId)->first();
            if ($user) {
                $user->tele_chat_id = null;
                $user->save();
                $msg = "Đã huỷ kết nối thành công!";
            } else {
                $msg = "Tài khoản chưa kết nối với hệ thống";
            }

            $this->sendMsg($chatId, $msg);
        }
        if (strpos($message, "/xacthuc") === 0) {
            preg_match('/\/xacthuc (\w*)/', $message, $transarr);
            if (count($transarr)) {
                $user = User::where('verifycodetele', $transarr[1])->first();
                if ($user) {
                    $user->tele_chat_id = $chatId;
                    $user->verifycodetele = null;
                    $user->save();
                    $msg = "Chào bạn " . $user->username . "\nChúc mừng bạn đã kết nối thành công.\nTừ bây giờ bạn có thể xem thông tin, đơn hàng ngay tại đây";
                } else {
                    $msg = "Mã kết nối không được tìm thấy";
                }
            } else {
                $msg = "Mã kết nối không được tìm thấy\n";
            }
            $this->sendMsg($chatId, $msg);
        }
        if (strpos($message, "/taikhoan") === 0) {

            $user = User::where('tele_chat_id', $chatId)->first();
            if ($user) {
                $msg = "Tài khoản: " . $user->username . "\n";
                $msg .= "Email: " . $user->email . "\n";
                $msg .= "Số dư: " . number_format($user->coin) . "\n";
            } else {
                $msg = "Bạn chưa kết nối với hệ thống";
            }
            
            
            $this->sendMsg($chatId, $msg);
        }
        if (strpos($message, "/donhang") === 0) {

            $user = User::where('tele_chat_id', $chatId)->first();


            if ($user) {
                $dataTable = [];
                $getHistoryBuy = HistoryBuy::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
                if (!empty($getHistoryBuy)) {
                    $msg = "Danh sách đơn hàng\n";
                    foreach ($getHistoryBuy as $value) {
                        $msg .= "------***-------\n";
                        $msg .= "ID: " . $value->id. "\n";
                        $msg .= "Ngày mua: " . format_time($value->created_at, "d/m/Y H:i:s"). "\n";
                        $msg .= "Loại : " . $value->gettype->name. "\n";
                        $msg .= "Số Lượng : " . $value->quantity. "\n";
                        $msg .= "Tổng tiền : " . number_format($value->total_price). "\n";
                        $msg .= "------***-------\n";
                        // $dataTable[] = [
                        //     $value->id,
                        //     format_time($value->created_at, "d/m/Y H:i:s"),
                        //     vn_to_str($value->gettype->name),
                        //     $value->quantity,
                        //     number_format($value->total_price)
                        // ];
                    }
                }else{
                    $msg = "Bạn chưa có đơn hàng!";
                }
                // // create instance of the table builder
                // $tableBuilder = new \MaddHatter\MarkdownTable\Builder();

                // // add some data
                // $tableBuilder
                //     ->headers(['ID', 'Time', 'Product', 'Quantity', 'Total Price']) //headers
                //     ->align(['L', 'C', 'C', 'C', 'C']) // set column alignment
                //     ->rows($dataTable);

                // // display the result
            } else {
                $msg = "Bạn chưa kết nối với hệ thống";
            }
            $this->sendMsg($chatId, $msg);
        }

        if (strpos($message, "/xemdonhang") === 0) {

            $user = User::where('tele_chat_id', $chatId)->first();

            preg_match('/\/xemdonhang ([0-9]{0,})/', $message, $transarr);
            if ($user && $transarr) {
                $dataTable = [];
                $getHistoryBuy = HistoryBuy::where('user_id', $user->id)->where('id', $transarr[1])->orderBy('created_at', 'desc')->first();
                if (!empty($getHistoryBuy)) {
                    $msg = "Data đơn hàng $transarr[1]\n";
                    $getHistoryBuy->setRelation('getSelled', $getHistoryBuy->getSelled()->get());
                    foreach ($getHistoryBuy->getSelled as $value) {
                        $msg .= "------***-------\n";
                        $msg .= "UID: " . $value->uid. "\n";
                        $msg .= "Full INFO: " . $value->full_info. "\n";
                        $msg .= "------***-------\n";
                        // $dataTable[] = [
                        //     $value->uid,
                        //     $value->full_info
                        // ];
                    }
                }else{
                    $msg = "Đơn hàng không tồn tại!";
                }
                // // create instance of the table builder
                // $tableBuilder = new \MaddHatter\MarkdownTable\Builder();

                // // add some data
                // $tableBuilder
                //     ->headers(['UID', 'INFO']) //headers
                //     ->align(['C', 'L']) // set column alignment
                //     ->rows($dataTable);

                // // display the result
                // $msg .= "<pre>" . $tableBuilder->render() . "</pre>";
            } else {
                $msg = "Bạn chưa kết nối với hệ thống";
            }

            $this->sendMsg($chatId, $msg);
        }
    }

    private function sendMsg($chatId, $msg){
        $path = "https://api.telegram.org/bot".getSetting('token_bot_telegram');

        $msg .= "\nGõ /start để xem thêm hướng dẫn.";
        $txt = urlencode($msg);
        file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=" . $txt."&parse_mode=html");
        exit;
    }
}
