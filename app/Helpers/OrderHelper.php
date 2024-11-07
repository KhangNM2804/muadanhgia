<?php

use App\Models\LogAction;
use App\Models\LogPayment;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('generateOrderCode')) {
    function generateOrderCode($type, $type_order_id)
    {
        // Lấy ngày hiện tại
        $date = Carbon::now()->format('dmY');

        // Đếm số lượng đơn hàng trong ngày hôm nay
        $orderCount = Order::where('type_order_id', $type_order_id)->whereDate('created_at', Carbon::today())->count() + 1;

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
                'status' => LogPayment::STATUS_ERROR
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
            'status' => LogPayment::STATUS_SUCCESS
        ]);
        $user->coin = $coin;
        $user->save();
        return true;
    }
}
if (!function_exists('upload_images')) {
    function upload_images($images)
    {
        try {
            $file_names = [];
            foreach ($images as $image) {
                $originalName = $image->getClientOriginalName();
                // Extract numbers from the file name (6 to 16 digits)
                preg_match('/([0-9]{6,16})/', $originalName, $matches);

                if (isset($matches[0])) {
                    // Use the extracted number and add a unique suffix
                    $imageName = $matches[0] . '_' . uniqid() . ".jpg";
                } else {
                    // Fallback to a unique name based on time and a random suffix
                    $imageName = time() . '_' . uniqid() . ".jpg";
                }
                $image->move(storage_path('app/review_images'), $imageName);
                $file_names[] = $imageName;
            }
            return $file_names;
        } catch (\Exception $e) {
            log_action('Uploadfile',  $e->getMessage(), 'OrderController line 108');
            return false;
        }
    }
}
