<?php

use App\Models\Category;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Type;
use App\Models\TypeOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

if (!function_exists('active_menu')) {
    function active_menu($routeName = [])
    {
        if (in_array(Route::currentRouteName(), $routeName)) {
            return 'active open';
        }

        return '';
    }
}

if (!function_exists('format_time')) {
    function format_time($date, $format = 'Y/m/d')
    {
        return Carbon::parse($date)->format($format);
    }
}

if (!function_exists('get_type')) {
    function get_type($type)
    {
        switch ($type) {
            case 1:
                return 'Via';
                break;
            case 2:
                return 'Clone';
                break;
            case 3:
                return 'BM';
                break;
            case 4:
                return 'Mail';
                break;
        }
    }
}

if (!function_exists('get_priority_ticket')) {
    function get_priority_ticket($priority)
    {
        switch ($priority) {
            case 1:
                return '<label class="badge badge-pill badge-danger">Cao<label>';
                break;
            case 2:
                return '<label class="badge badge-pill badge-warning">Bình thường<label>';
                break;
            case 3:
                return '<label class="badge badge-pill badge-info">Thấp<label>';
                break;
        }
    }
}

if (!function_exists('get_status_ticket')) {
    function get_status_ticket($status)
    {
        switch ($status) {
            case 1:
                return '<label class="badge badge-pill badge-primary">Ticket new<label>';
                break;
            case 2:
                return '<label class="badge badge-pill badge-success">Khách hàng đã trả lời<label>';
                break;
            case 3:
                return '<label class="badge badge-pill badge-success">Admin đã trả lời<label>';
                break;
            case 4:
                return '<label class="badge badge-pill badge-danger">Đã đóng<label>';
                break;
            case 5:
                return 'Mở lại';
                break;
        }
    }
}

if (!function_exists('get_unread_tickets')) {
    function get_unread_tickets()
    {
        if (Auth::user()->role == 1) {
            return Ticket::whereIn('status', [1, 2])->count();
        } else {
            return Ticket::where('user_id', Auth::user()->id)->whereIn('status', [1, 3])->count();
        }
    }
}

if (!function_exists('get_display')) {
    function get_display($display)
    {
        switch ($display) {
            case 0:
                return '<span class="badge badge-pill badge-danger"><i class="fa fa-fw fa-times-circle"></i> Không</span>';
                break;
            case 1:
                return '<span class="badge badge-pill badge-success"><i class="fa fa-fw fa-check"></i> Có!</span>';
                break;
        }
    }
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function getSetting($cd_key)
{
    return Setting::getValuebyKey($cd_key);
}

function checkEmptyType($type)
{
    $list =  Category::getListByType($type);
    if (count($list) == 0) {
        return true;
    }
    return false;
}
function getChild($user_id)
{
    $list =  User::getChild($user_id);
    return $list;
}

function getTypes()
{
    $list =  Type::with('allCategory')->whereHas('allCategory')->where('display', 1)->orderBy('sort_num')->orderBy('id')->get();
    return $list;
}
function getTypeOrder()
{
    $list =  TypeOrder::where('id', '!=', 2)->orderBy('id')->get();
    return $list;
}

function vn_to_str($str)
{

    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );

    foreach ($unicode as $nonUnicode => $uni) {

        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }

    return $str;
}

function generate_vietqr($acqId, $accountNo, $accountName)
{
    // get token
    $content = json_decode(vietqr_cURL("https://vietqr.net/portal-service/api/data/generate"));
    $token = $content->data;

    $currentDate = date("Ymd");
    $key = "{$currentDate}{$token}";

    // get qr
    $payload = array(
        'isMask' => 0,
        'acqId' => $acqId, //"970436", // id bank
        'accountNo' => $accountNo,
        'accountName' => $accountName,
        'amount' => "100000",
        'addInfo' => getSetting('bank_syntax') . " " . Auth::user()->id
    );
    $cipherText = vietqr_encrypt(json_encode($payload), $key);
    $content = json_decode(vietqr_cURL("https://vietqr.net/portal-service/v1/qr-ibft/generate", array('payload' => $cipherText), $headers = array("Authorization: Bearer $token")));
    $res = $content->data ?? null;
    if ($res) {
        $data = json_decode(vietqr_decrypt($res, $key));

        return $data->qrBase64 ?? null;
    }

    return null;
}

// functions
function vietqr_cURL($url, $data = array(), $headers = [])
{
    $ch = curl_init($url);
    $defaultHeaders = array(
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36",
        "Referer: https://vietqr.net/",
        "Origin: https://vietqr.net",
        "Content-Type: application/json"
    );
    $headers = array_merge($defaultHeaders, $headers);
    $ch = curl_init($url);
    if ($data && sizeof($data) > 0) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function vietqr_encrypt($string, $pass)
{
    $salt = openssl_random_pseudo_bytes(8);
    $salted = '';
    $dx = '';
    $key_length = (int) (256 / 8);
    $block_length = 16;
    $salted_length = $key_length + $block_length;

    while (strlen($salted) < $salted_length) {
        $dx = md5($dx . $pass . $salt, true);
        $salted .= $dx;
    }

    $key = substr($salted, 0, $key_length);
    $iv = substr($salted, $key_length, $block_length);
    $encrypted = openssl_encrypt($string, "aes-256-cbc", $key, true, $iv);

    return base64_encode('Salted__' . $salt . $encrypted);
}

function vietqr_decrypt($string, $pass)
{
    $key_length = (int) (256 / 8);
    $block_length = 16;
    $data = base64_decode($string);
    $salt = substr($data, 8, 8);
    $encrypted = substr($data, 16);
    $rounds = 3;
    $data00 = $pass . $salt;
    $md5_hash = array();
    $md5_hash[0] = md5($data00, true);
    $result = $md5_hash[0];

    for ($i = 1; $i < $rounds; $i++) {
        $md5_hash[$i] = md5($md5_hash[$i - 1] . $data00, true);
        $result .= $md5_hash[$i];
    }

    $key = substr($result, 0, $key_length);
    $iv = substr($result, $key_length, $block_length);

    return openssl_decrypt($encrypted, "aes-256-cbc", $key, true, $iv);
}

function randomStr($length = 6)
{
    $string = "";
    $alpha  = "0123456789abcdefghijklmnopqrstuvwxyz";

    for ($i = 0; $i < $length; $i++) {
        $string .= $alpha[rand(0, strlen($alpha) - 1)];
    }

    return $string;
}
