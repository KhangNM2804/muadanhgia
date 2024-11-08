<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTypeRequest;
use App\Models\Order;
use App\Models\Type;
use App\Models\TypeOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    // public function index()
    // {
    //     $types = Type::all();
    //     return view('type.index', compact('types'));
    // }

    public function create($path)
    {
        // Retrieve the type based on the path parameter
        if ($path == 'review_images') {
            $path = 'review';
        }
        $type = TypeOrder::where('path', $path)->get();

        // Return the view with the data
        return view('orders.create', compact('type'));
    }

    public function store(Request $request, $path)
    {
        // Handle different types of orders based on the path
        switch ($path) {
            case 'review':
                return $this->store_review_5s($request);
            case 'review_images':
                return $this->store_review_images($request);
            case 'seomap':
                return $this->store_seo_map($request);
            case 'likemap':
                return $this->store_like_map($request);
            case 'reportmap':
                return $this->store_report_map($request);
            default:
                return redirect()->route('orders.create', ['path' => $path])->with('error', 'Invalid order type.');
        }
    }

    public function store_review_5s($request)
    {
        $request->validate([
            'link' => 'required',
            'total_quantity' => 'required|numeric|min:3',
            'quantity_run' => 'required|numeric|min:3',
            'content' => 'required',
            'total_money' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();
            $data = [
                'user_id' => Auth::user()->id,
                'type_order_id' => 1,
                'code' => generateOrderCode('D5S', 1),
                'link' => $request->link,
                'price' => $request->price,
                'total_money' => $request->total_money,
                'total_quantity' => $request->total_quantity,
                'quantity_run' => $request->quantity_run,
                'content' => json_encode(explode("\r\n", $request->content)),
                'note' => $request->note
            ];

            // Deduct money and check if the transaction is successful
            $tru_tien = deduct_money('Tạo đơn review 5s', $data['total_money'], 'Mua thành công đơn hàng ' . $data['code'], 'OrderController.php line 71');
            if (!$tru_tien) {
                DB::rollBack();
                return redirect()->route('orders.create', ['path' => 'review'])->with('error', 'Không đủ tiền để tạo đơn hàng.');
            }
            // Create the order and commit the transaction
            Order::create($data);
            DB::commit();
            return redirect()->route('orders.create', ['path' => 'review'])->with('success', 'Đơn hàng được tạo thành công!');
        } catch (\Exception $e) {
            // Log the error, roll back the transaction, and redirect with an error message
            log_action('Tạo đơn review 5s', $e->getMessage(), 'OrderController.php line 73');
            DB::rollBack();
            return redirect()->route('orders.create', ['path' => 'review'])->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }

    public function store_review_images($request)
    {
        $request->validate([
            'link' => 'required',
            'content' => 'required',
        ]);
        DB::beginTransaction();
        $data = [
            'user_id' => Auth::user()->id,
            'type_order_id' => 2,
            'code' => generateOrderCode('DIM', 2),
            'link' => $request->link,
            'price' => $request->price,
            'total_money' => $request->total_money,
            'content' => json_encode(explode("\r\n", $request->content)),
            'note' => $request->note
        ];
        $tru_tien = deduct_money('Tạo đơn review images', $data['total_money'], 'Mua thành công đơn hàng ' . $data['code'], 'OrderController.php line 113');
        if (!$tru_tien) {
            DB::rollBack();
            return redirect()->route('orders.create', ['path' => 'review'])->with('error', 'Không đủ tiền để tạo đơn hàng.');
        }
        // Kiểm tra có file không ?
        if (!$request->hasFile('images')) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Vui lòng upload ít nhất 1 file');
        }
        //Thực hiện lấy file và upload;
        $images = $request->file('images');
        $images_name = upload_images($images);

        // Kiểm tra có upload file thành công chưa
        if (!$images_name) {
            DB::rollBack();
            return redirect()->route('orders.create', ['path' => 'review'])->with('error', 'Đã xảy ra lỗi upload ảnh. Vui lòng thử lại.');
        }
        //Thêm images đã upload vào
        $data['images'] = json_encode($images_name);
        Order::create($data);
        DB::commit();
        return redirect()->back()->with('success', 'Upload file thành công');
    }
    public function store_seo_map($request)
    {
        $request->validate([
            'link' => 'required',
            'total_quantity' => 'required|numeric|min:3',
            'quantity_run' => 'required|numeric|min:3',
            'content' => 'required',
        ]);
        DB::beginTransaction();
        $data = [
            'user_id' => Auth::user()->id,
            'type_order_id' => 3,
            'code' => generateOrderCode('DSEO', 3),
            'link' => $request->link,
            'price' => $request->price,
            'total_money' => $request->total_money,
            'total_quantity' => $request->total_quantity,
            'quantity_run' => $request->quantity_run,
            'content' => json_encode(explode("\r\n", $request->content)),
            'note' => $request->note
        ];
        $tru_tien = deduct_money('Tạo đơn seo map', $data['total_money'], 'Mua thành công đơn hàng ' . $data['code'], 'OrderController.php line 156');
        if (!$tru_tien) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Không đủ tiền để tạo đơn hàng.');
        }
        Order::create($data);
        DB::commit();
        return redirect()->back()->with('success', 'Đơn hàng được tạo thành công!');
    }
    public function store_like_map($request)
    {
        $request->validate([
            'link' => 'required',
            'total_quantity' => 'required|numeric|min:3',
        ]);
        $data = [
            'user_id' => Auth::user()->id,
            'type_order_id' => 4,
            'code' => generateOrderCode('DLIKE', 4),
            'link' => $request->link,
            'price' => $request->price,
            'total_money' => $request->total_money,
            'total_quantity' => $request->total_quantity,
        ];
        $tru_tien = deduct_money('Tạo đơn like map', $data['total_money'], 'Mua thành công đơn hàng ' . $data['code'], 'OrderController.php line 183');
        if (!$tru_tien) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Không đủ tiền để tạo đơn hàng.');
        }
        Order::create($data);
        DB::commit();
        return redirect()->back()->with('success', 'Đơn hàng được tạo thành công!');
    }
    public function store_report_map($request)
    {
        $request->validate([
            'link' => 'required',
            'total_quantity' => 'required|numeric|min:3',
            'content' => 'required',
        ]);
        $data = [
            'user_id' => Auth::user()->id,
            'type_order_id' => 5,
            'code' => generateOrderCode('DREPORT', 5),
            'link' => $request->link,
            'price' => $request->price,
            'total_money' => $request->total_money,
            'total_quantity' => $request->total_quantity,
            'content' => json_encode(explode("\r\n", $request->content))
        ];
        $tru_tien = deduct_money('Tạo đơn report map', $data['total_money'], 'Mua thành công đơn hàng ' . $data['code'], 'OrderController.php line 209');
        if (!$tru_tien) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Không đủ tiền để tạo đơn hàng.');
        }
        Order::create($data);
        DB::commit();
        return redirect()->back()->with('success', 'Đơn hàng được tạo thành công!');
    }
    public function history_buy(Request $request)
    {
        $user = Auth::user();

        // Nhận các tham số từ request
        $code = $request->input('code');
        $typeOrderId = $request->input('type_order_id');
        $perPage = $request->input('per_page', 10); // Số lượng dòng mặc định là 10
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        // Tạo truy vấn với điều kiện lọc và tìm kiếm
        $query = Order::with(['type'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($code) {
            $query->where('code', 'like', '%' . $code . '%');
        }

        if ($typeOrderId && in_array($typeOrderId, range(1, 5))) {
            $query->where('type_order_id', $typeOrderId);
        }
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        // Phân trang với số lượng dòng tùy chỉnh
        $getHistoryBuy = $query->paginate($perPage);

        return view('orders.history_buy', compact('getHistoryBuy'));
    }
}
