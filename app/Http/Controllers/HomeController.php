<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    private $apiUrl = 'http://localhost:8080/api'; //địa chỉ Java API

    public function index()
    {
        // Kiểm tra người dùng đăng nhập
        if (!session('loggedIn')) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước!');
        }

        $user = session('user');
        $tours = [];

        try {
            // Gọi API Java để lấy danh sách tour
            $response = Http::timeout(5)->get($this->apiUrl . '/tours');

            if ($response->successful()) {
                $tours = $response->json();
            } else {
                // Nếu API trả lỗi
                session()->flash('error', 'Không thể lấy danh sách tour từ API!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi kết nối API: ' . $e->getMessage());
        }

        return view('main.home', compact('tours', 'user'));
    }
}
