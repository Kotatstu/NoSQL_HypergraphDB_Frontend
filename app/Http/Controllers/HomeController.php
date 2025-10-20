<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $apiUrl = 'http://localhost:8080/api'; //địa chỉ Java API
    public function index()
    {
         // Kiểm tra người dùng đã đăng nhập chưa
        if (!session('loggedIn')) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước!');
        }
        $user = session('user');

        $tours = [
            ['id' => 1, 'name' => 'Tour Đà Lạt 3N2Đ', 'description' => 'Tham quan đồi chè, hồ Tuyền Lâm, chợ đêm.', 'price' => 2500000, 'image' => 'dalat.jpg'],
            ['id' => 2, 'name' => 'Tour Phú Quốc 4N3Đ', 'description' => 'Tận hưởng biển xanh và resort sang trọng.', 'price' => 4500000, 'image' => 'phuquoc.jpg'],
            ['id' => 3, 'name' => 'Tour Hà Giang 3N2Đ', 'description' => 'Chinh phục đèo Mã Pí Lèng và cao nguyên đá Đồng Văn.', 'price' => 3200000, 'image' => 'hagiang.jpg'],
        ];

        return view('main.home', compact('tours','user'));
    }
}
