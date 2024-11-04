<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectAPIController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MomoController;
use App\Http\Controllers\NowPaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\TwoFaceAuthsController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyTwoFaceController;
use App\Http\Controllers\VietcombankController;
use App\Http\Controllers\XMDTController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth', '2fa', 'user_has_block')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    // Route::get('/muamail', [HomeController::class, 'muamail'])->name('muamail');
    Route::get('baiviet', [HomeController::class, 'baiviet'])->name('baiviet');
    Route::get('posts/show/{slug}', [PostController::class, 'show'])->name('posts.show');
    Route::post('comment', [CommentController::class, 'store'])->name('posts.comment');
    // Route::get('muahang/{id}', [HomeController::class, 'muahang'])->name('home.muahang');

    Route::group(["prefix" => "two_face_auths"], function () {
        Route::get("/", [TwoFaceAuthsController::class, 'index'])->name("2fa_setting");
        Route::post("/enable", [TwoFaceAuthsController::class, 'enable'])->name("enable_2fa_setting");
        Route::post("/disable", [TwoFaceAuthsController::class, 'disable'])->name("disable_2fa_setting");
    });
    Route::get('orders/{path}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders/{path}', [OrderController::class, 'store'])->name('orders.store');
    Route::middleware('can:admin_role')->group(function () {
        Route::get('users', [HomeController::class, 'listUser'])->name('listUser');
        Route::get('users/export_excel', [HomeController::class, 'user_export_excel'])->name('user_export_excel');
        Route::post('users/bulk', [UserController::class, 'bulk_update_user'])->name('bulk_update_user');
        Route::get('users/{id}', [UserController::class, 'edit'])->name('edit_user');
        Route::post('users/{id}', [UserController::class, 'post_edit'])->name('post_edit_user');
        Route::get('category/create', [CategoryController::class, 'create'])->name('get_create_cate');
        Route::post('category/create', [CategoryController::class, 'post_create'])->name('post_create_cate');
        Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('get_edit_cate');
        Route::post('category/edit/{id}', [CategoryController::class, 'post_edit'])->name('post_edit_cate');
        Route::get('category', [CategoryController::class, 'index'])->name('category_index');
        Route::get('category/import', [CategoryController::class, 'import'])->name('import');
        Route::post('category/ajax_import', [CategoryController::class, 'ajax_import'])->name('ajax_import');
        Route::get('category/export_data_sell/{id}', [CategoryController::class, 'export_data_sell'])->name('export_data_sell');
        Route::get('setting', [HomeController::class, 'setting'])->name('setting');
        Route::post('setting', [HomeController::class, 'post_setting'])->name('post_setting');
        Route::get('setting_telegram', [HomeController::class, 'setting_telegram'])->name('setting_telegram');
        Route::post('setting_telegram', [HomeController::class, 'post_setting_telegram'])->name('post_setting_telegram');
        Route::get('deposit_all', [HomeController::class, 'deposit_all'])->name('deposit_all');
        Route::get('login_history', [HomeController::class, 'login_history'])->name('login_history');
        Route::get('doanhthu', [HomeController::class, 'doanhthu_chart'])->name('doanhthu_chart');
        Route::post('get_chart', [HomeController::class, 'get_chart'])->name('get_chart');
        Route::post('export_deposit_excel', [HomeController::class, 'export_deposit_excel'])->name('export_deposit_excel');
        Route::post('export_buy_excel', [HomeController::class, 'export_buy_excel'])->name('export_buy_excel');
        Route::get('download_export/{filename}', [HomeController::class, 'download_export'])->name('download_export');
        Route::get('addcoin', [HomeController::class, 'addcoin'])->name('addcoin');
        Route::post('addcoin', [HomeController::class, 'post_addcoin'])->name('post_addcoin');
        Route::get('posts', [PostController::class, 'index'])->name('posts');
        Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
        Route::get('posts/edit/{id}', [PostController::class, 'getEdit'])->name('posts.getEdit');
        Route::post('posts/edit/{id}', [PostController::class, 'postEdit'])->name('posts.postEdit');
        Route::get('posts/del/{id}', [PostController::class, 'delete'])->name('posts.delete');
        Route::get('comment/del/{id}', [CommentController::class, 'delete'])->name('comment.delete');

        Route::get('dropzone', [DropzoneController::class, 'index'])->name('dropzone.index');
        Route::post('dropzone/upload', [DropzoneController::class, 'upload'])->name('dropzone.upload');
        Route::get('dropzone/fetch', [DropzoneController::class, 'fetch'])->name('dropzone.fetch');
        Route::get('dropzone/delete', [DropzoneController::class, 'delete'])->name('dropzone.delete');
        Route::get('dropzone/renameall', [DropzoneController::class, 'renameall'])->name('dropzone.renameall');


        Route::get('dropzone_phoi', [DropzoneController::class, 'phoi_index'])->name('dropzone_phoi.index');
        Route::post('dropzone_phoi/upload', [DropzoneController::class, 'phoi_upload'])->name('dropzone_phoi.upload');
        Route::get('dropzone_phoi/fetch', [DropzoneController::class, 'phoi_fetch'])->name('dropzone_phoi.fetch');
        Route::get('dropzone_phoi/delete', [DropzoneController::class, 'phoi_delete'])->name('dropzone_phoi.delete');
        Route::get('dropzone_phoi/renameall', [DropzoneController::class, 'phoi_renameall'])->name('dropzone_phoi.renameall');

        Route::get('type', [TypeController::class, 'index'])->name('type.index');
        Route::get('type/create', [TypeController::class, 'create'])->name('get_create_type');
        Route::post('type/create', [TypeController::class, 'post_create'])->name('post_create_type');
        Route::get('type/edit/{id}', [TypeController::class, 'edit'])->name('get_edit_type');
        Route::post('type/edit/{id}', [TypeController::class, 'post_edit'])->name('post_edit_type');
        Route::get('momo', [MomoController::class, 'index'])->name('momo.index');
        Route::get('momo/add/{phone?}', [MomoController::class, 'add'])->name('momo.add');
        Route::post('momo/get_otp', [MomoController::class, 'get_otp'])->name('momo.get_otp');
        Route::post('momo/check_otp', [MomoController::class, 'check_otp'])->name('momo.check_otp');
        Route::post('momo/login', [MomoController::class, 'login'])->name('momo.login');
        Route::post('momo/set_auto', [MomoController::class, 'set_auto'])->name('momo.set_auto');
        Route::post('momo/relogin', [MomoController::class, 'relogin'])->name('momo.relogin');
        Route::get('momo/chuyentien', [MomoController::class, 'chuyentien'])->name('momo.chuyentien');
        Route::post('momo/getinfo', [MomoController::class, 'getinfo'])->name('momo.getinfo');
        Route::post('momo/init_pay', [MomoController::class, 'init_pay'])->name('momo.init_pay');

        Route::get('listsell', [CategoryController::class, 'listviasell'])->name('get_listviasell');
        Route::get('listsell/update/{id}', [CategoryController::class, 'listviasell_update'])->name('get_listviasell_update');
        Route::post('listsell/update/{id}', [CategoryController::class, 'listviasell_postupdate'])->name('post_listviasell_update');
        Route::get('listsell/delete/{id}', [CategoryController::class, 'listviasell_delete'])->name('sell_delete');

        Route::group(["prefix" => "api-management"], function () {
            Route::get("/", [ConnectAPIController::class, 'index'])->name("list_api_connect");
            Route::get("/re_sync/{id}", [ConnectAPIController::class, 're_sync']);
            Route::get("/add", [ConnectAPIController::class, 'add_site'])->name("api_add_site");
            Route::post("/add", [ConnectAPIController::class, 'post_add_site'])->name("post_api_add_site");
            Route::get("/edit/{id}", [ConnectAPIController::class, 'edit_site'])->name("api_edit_site");
            Route::post("/edit/{id}", [ConnectAPIController::class, 'post_edit_site'])->name("post_api_edit_site");
            Route::get("/{id}/category", [ConnectAPIController::class, 'get_category'])->name("get_api_manager_category");
            Route::get("/{id}/product", [ConnectAPIController::class, 'get_product'])->name("get_api_manager_product");
            Route::get("/{id}/orders", [ConnectAPIController::class, 'get_orders'])->name("get_api_manager_orders");
            Route::post("/ajax/product/update_price", [ConnectAPIController::class, 'ajax_product_update_price'])->name("ajax_api_manager_product_update_price");
        });
    });
    Route::middleware('can:staff_role')->group(function () {
        Route::get('buy_all', [HomeController::class, 'buy_all'])->name('buy_all');
    });
    Route::post('category/buy', [CategoryController::class, 'ajax_buy'])->name('ajax_buy');
    Route::get('history_buy', [CategoryController::class, 'history_buy'])->name('history_buy');
    Route::get('don-hang/{id}', [CategoryController::class, 'don_hang'])->name('don_hang');
    Route::get('naptien', [MomoController::class, 'naptien'])->name('naptien');
    Route::get('lichsunap', [HomeController::class, 'lichsunap'])->name('lichsunap');
    Route::get('hotro', [HomeController::class, 'hotro'])->name('hotro');
    Route::get('account', [UserController::class, 'account'])->name('account');
    Route::post('doimatkhau', [UserController::class, 'doimatkhau'])->name('doimatkhau');
    Route::get('export_txt/{id}', [CategoryController::class, 'export_txt'])->name('export_txt');
    Route::get('download_zip_backup/{id}', [CategoryController::class, 'download_zip_backup'])->name('download_zip_backup');
    Route::get('download_backup/{buy_id}/{uid}', [CategoryController::class, 'download_backup'])->name('download_backup');
    Route::get('download_phoi/{buy_id}/{uid}', [CategoryController::class, 'download_phoi'])->name('download_phoi');
    Route::get('checkliveuid', [HomeController::class, 'checkliveuid'])->name('checkliveuid');
    Route::get('checkbm', [HomeController::class, 'checkbm'])->name('checkbm');
    Route::post('apicheckbm', [HomeController::class, 'apicheckbm'])->name('apicheckbm');
    Route::get('checkbmxmdt', [HomeController::class, 'checkbmxmdt'])->name('checkbmxmdt');
    Route::post('apicheckbmxmdt', [HomeController::class, 'apicheckbmxmdt'])->name('apicheckbmxmdt');
    Route::get('2fa', [HomeController::class, 'tool2fa'])->name('tool2fa');

    Route::get('/tao_phoi_xmdt', [XMDTController::class, 'index'])->name('xmdt.index');
    Route::post('/preview-phoi-xmdt', [XMDTController::class, 'preview'])->name('xmdt.preview');

    Route::get('/setting_api', [HomeController::class, 'setting_api'])->name('setting_api');
    Route::post('/updateAPIKEY', [HomeController::class, 'updateAPIKEY']);

    Route::post('/paypal/callback', [PaypalController::class, 'callback']);
    Route::get('/tools/share_tkqc_via', [ToolsController::class, 'share_tkqc_to_via'])->name('share_tkqc_to_via');
    Route::post('/tools/share_tkqc_via/api', [ToolsController::class, 'share_tkqc_to_via_api'])->name('share_tkqc_to_via_api');

    Route::get('/tickets', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('ticket.create');
    Route::post('/tickets/create', [TicketController::class, 'postCreate'])->name('ticket.post.create');
    Route::get('/tickets/{ticket_id}', [TicketController::class, 'show'])->name('ticket.show');
    Route::post('/tickets/{ticket_id}/comment', [TicketController::class, 'postComment'])->name('ticket.post.comment');
    Route::post('/tickets/close', [TicketController::class, 'close'])->name('ticket.post.close');

    Route::post('/nowpayment/create', [NowPaymentController::class, 'create_payment'])->name('nowpayment.create');
    Route::get('category/getDetail/{id}', [CategoryController::class, 'getDetail'])->name('getDetail');
});
// Route::post('/nowpayment/callback', [NowPaymentController::class, 'callback'])->name('nowpayment.callback');
// Route::post('/perfectmoney/callback', [NowPaymentController::class, 'perfectmoney_callback'])->name('perfectmoney_callback');

// Route::get('/api/vcb/auto', [VietcombankController::class, 'autoVCB'])->name('autoVCB');
// Route::post('/api/vcb/get', [VietcombankController::class, 'api']);
// Route::get('/api/momo/auto', [MomoController::class, 'autoMomo'])->name('autoMomo');
Route::get('/login', [UserController::class, 'login'])->name('get.login');
Route::post('/login', [UserController::class, 'postLogin'])->name('post.login');
Route::get('/register', [UserController::class, 'register'])->name('get.register');
Route::post('/register', [UserController::class, 'postRegister'])->name('post.register');

// Route::post('/bank/tcb/endpoint', [BankController::class, 'endpoint_tcb']);
// Route::post('/bank/mb/endpoint', [BankController::class, 'endpoint_mb']);
// Route::post('/bank/vietinbank/endpoint', [BankController::class, 'endpoint_vietinbank']);
// Route::get('/tool/autoremovefile/{day}', [DropzoneController::class, 'removefiles']);

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );
    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => 'Chúng tôi đã gửi email liên kết đặt lại mật khẩu của bạn!'])
        : back()->withErrors(['email' => 'Chúng tôi không thể tìm thấy người dùng có địa chỉ email đó.']);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token, Request $request) {
    return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
})->middleware('guest')->name('password.reset');



Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) use ($request) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();

            $user->setRememberToken(Str::random(60));
            event(new PasswordReset($user));
        }
    );

    return $status == Password::PASSWORD_RESET
        ? redirect()->route('get.login')->with('register_completed', 'Đổi mật khẩu thành công!')
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

Route::group(["middleware" => "auth", "prefix" => "two_face"], function () {
    Route::get("/", [VerifyTwoFaceController::class, 'index'])->name("two_face.index");
    Route::post("/verify", [VerifyTwoFaceController::class, 'verify'])->name("two_face.verify");
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});
Route::group(["middleware" => "auth"], function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});

// Route::post("/webhook_telegram", [TelegramController::class, 'webhook'])->name("webhook_telegram");
Route::get("/lang/{locale}", [LocalizationController::class, 'lang'])->name("change_lang");
