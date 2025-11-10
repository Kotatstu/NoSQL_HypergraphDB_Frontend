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

    public function show($id)
    {
        try {
            // Gọi API Java ở cổng 8080
            $response = Http::get("http://localhost:8080/api/tour/{$id}");

            // Kiểm tra trạng thái phản hồi
            if ($response->failed()) {
                return abort(404, 'Không thể kết nối tới API hoặc tour không tồn tại.');
            }

            // Parse JSON trả về
            $tour = $response->json();

            // Gộp dữ liệu nhà tổ chức (để tiện cho view)
            $nhaToChuc = $tour['nhaToChuc'] ?? null;

            // Chuẩn bị dữ liệu truyền sang view
            return view('main.details', [
                'tour' => $tour,
                'nhaToChuc' => $nhaToChuc,
                'danhGiaList' => [] // tạm để trống vì API hiện chưa có phần đánh giá
            ]);
        } catch (\Exception $e) {
            return abort(500, 'Lỗi khi gọi API: ' . $e->getMessage());
        }
    }
}
