<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class XMDTController extends Controller
{
    public function index(){
        return view('xmdt.index');
    }


    public function preview(Request $request){
        if(Auth::user()->coin < 100000){
            return response()->json(['status' => false, 'msg' => 'Dịch vụ này hoàn toàn miễn phí nhưng yêu cầu số dư tối thiếu trong tài khoản là 100,000 VNĐ']);
        }
        if($request->phoi == "phoi-fra"){
            $img = Image::make(public_path('assets/xmdt/fra/fra.png'));
            $name = explode(" ",$request->name,2);
            $img->text((isset($name[0]) && !empty($name[0])) ? $name[0] : "SANZ", 1285, 660, function($font) {
                $font->file(public_path('assets/xmdt/fra/font/Revans-Medium.ttf'));
                $font->size(50);
                $font->color('#333333');
                $font->align('left');
            });
            $img->text($name[1] ?? "Fransic Co", 1285, 828, function($font) {
                $font->file(public_path('assets/xmdt/fra/font/Revans-Medium.ttf'));
                $font->size(50);
                $font->color('#333333');
                $font->align('left');
            });
            $img->text("F", 1285, 944, function($font) {
                $font->file(public_path('assets/xmdt/fra/font/Revans-Medium.ttf'));
                $font->size(50);
                $font->color('#333333');
                $font->align('left');
            });
            if($request->dob){
                $img->text($request->dob ? Carbon::createFromFormat('d/m/Y', $request->dob)->format('d m Y') : "21 05 2021", 1867, 944, function($font) {
                    $font->file(public_path('assets/xmdt/fra/font/Revans-Medium.ttf'));
                    $font->size(50);
                    $font->color('#333333');
                    $font->align('left');
                });
            }
            if($request->photo){
                $avt = Image::make($request->photo);
                $avt->resize(630,749);
                $img->insert($avt,'top-left',628, 630);
            }else{
                $avt = Image::make(file_get_contents("https://thispersondoesnotexist.com/image"));
                $avt->resize(630,749);
                $img->insert($avt,'top-left',628, 630);
            }
            
            $mark = Image::make(public_path('assets/xmdt/fra/mark_fra.png'));
            // $avt->resize(630,749);
            $img->insert($mark,'top-left',628, 500);
            // $img->save(public_path('assets/xmdt/fra2.png'), 60);

            return response()->json(['status' => true, 'data' => $img->encode('data-url')->encoded]);
            
        }

        return response()->json(['status' => false, 'msg' => 'Dữ liệu không chính xác']);
        
    }
}
