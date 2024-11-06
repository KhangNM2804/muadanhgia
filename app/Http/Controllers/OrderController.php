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
            case 3:
                return $this->store_seo_map($request);
            case 4:
                return $this->store_like_map($request);
            case 5:
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
                'code' => generateOrderCode('D5S'),
                'link' => $request->link,
                'total_money' => $request->total_money,
                'total_quantity' => $request->total_quantity,
                'quantity_run' => $request->quantity_run,
                'content' => $request->content,
                'note' => $request->note
            ];

            // Deduct money and check if the transaction is successful
            $tru_tien = deduct_money('Tạo đơn review 5s', $data['total_money'], 'Mua thành công đơn hàng ' . $data['code'], 'OrderController.php line 71');
            if (!$tru_tien) {
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
            'images' => 'required|image'
        ]);
        $images = $request->file('images');
        foreach ($images as $image) {
            $imageName = $image->getClientOriginalName();
            // Extract numbers from the file name (6 to 16 digits)
            preg_match('/([0-9]{6,16})/', $imageName, $matches);
            // Ensure we have a match before renaming
            if (isset($matches[0])) {
                $imageName = $matches[0] . ".jpg";
            } else {
                $imageName = time() . ".jpg"; // Fallback if no match
            }

            $image->move(storage_path('app/review_images'), $imageName);
        }
        return redirect()->back();
    }
    public function store_seo_map($request)
    {
        $request->validate([
            'link' => 'required',
            'total_quantity' => 'required|numeric|min:3',
            'quantity_run' => 'required|numeric|min:3',
            'content' => 'required',
        ]);
        $data = $request::all();
    }
    public function store_like_map($request)
    {
        $request->validate([
            'link' => 'required',
            'total_quantity' => 'required|numeric|min:3',
        ]);
    }
    public function store_report_map($request)
    {
        $request->validate([
            'link' => 'required',
            'total_quantity' => 'required|numeric|min:3',
            'content' => 'required',
        ]);
    }
}
