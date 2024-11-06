<?php

use App\Models\LogAction;
use App\Models\LogPayment;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('generateOrderCode')) {
    function generateOrderCode($type)
    {
        // Lấy ngày hiện tại
        $date = Carbon::now()->format('dmY');

        // Đếm số lượng đơn hàng trong ngày hôm nay
        $orderCount = Order::whereDate('created_at', Carbon::today())->count() + 1;

        // Tạo mã đơn hàng
        $orderCode = $type . $date . str_pad($orderCount, 3, '0', STR_PAD_LEFT);

        return $orderCode;
    }
}
if (!function_exists('log_action')) {
    function log_action($action, $message, $file)
    {
        try {
            LogAction::create([
                'user_id' => Auth::user()->id,
                'action' => $action,
                'message' => $message,
                'file' => $file
            ]);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
if (!function_exists('deduct_money')) {
    function deduct_money($action, $total_money, $message, $file)
    {
        $user = User::findOrFail(Auth::user()->id);
        $coin = $user->coin - $total_money; // lấy tiền khách trừ tiền đơn hàng
        if ($coin < 0) {
            LogPayment::create([
                'user_id' => Auth::user()->id,
                'action' => $action,
                'message' => 'Không đủ tiền',
                'file' => $file,
                'before_coin' => $user->coin,
                'after_coin' => $coin,
            ]);
            return false; //nếu không đủ tiền thì return
        }
        LogPayment::create([
            'user_id' => Auth::user()->id,
            'action' => $action,
            'message' => $message,
            'file' => $file,
            'before_coin' => $user->coin,
            'after_coin' => $coin,
        ]);
        $user->coin = $coin;
        $user->save();
        return true;
    }
}
