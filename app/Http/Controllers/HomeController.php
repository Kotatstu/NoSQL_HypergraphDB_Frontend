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
            return redirect()->route('login.show')->with('error', 'Vui lòng đăng nhập trước!');
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
            // Gọi API chi tiết tour
            $tourRes = Http::get("http://localhost:8080/api/tour/{$id}");
            if ($tourRes->failed()) {
                return abort(404, 'Không thể kết nối tới API hoặc tour không tồn tại.');
            }

            $tour = $tourRes->json();
            $nhaToChuc = $tour['nhaToChuc'] ?? null;

            // Gọi API đánh giá tour
            $danhGiaRes = Http::get("http://localhost:8080/api/tour/{$id}/danhgia");
            $danhGiaList = $danhGiaRes->ok() ? $danhGiaRes->json() : [];

            return view('main.details', [
                'tour' => $tour,
                'nhaToChuc' => $nhaToChuc,
                'danhGiaList' => $danhGiaList
            ]);
        } catch (\Exception $e) {
            return abort(500, 'Lỗi khi gọi API: ' . $e->getMessage());
        }
    }

    // Hàm đặt tour
    public function datTour(Request $request)
    {
        try {
            $validated = $request->validate([
                'khachHangEmail' => 'required|email',
                'tourId' => 'required|string',
                'soNguoi' => 'required|integer|min:1',
                'ngayKhoiHanh' => 'required|date',
            ]);

            // Chuẩn bị payload đúng theo model DatTour (bỏ id)
            $payload = [
                "khachHangEmail" => $validated['khachHangEmail'],
                "tourId" => $validated['tourId'],
                "soNguoi" => $validated['soNguoi'],
                "ngayDat" => now()->toDateString(), // YYYY-MM-DD
                "ngayKhoiHanh" => $validated['ngayKhoiHanh'],
                "trangThai" => "Pending"
            ];

            $response = Http::asJson()->post('http://localhost:8080/api/dattour', [
                'khachHangEmail' => $request->khachHangEmail,
                'tourId' => $request->tourId,
                'soNguoi' => $request->soNguoi,
                'ngayDat' => now()->toDateString(),
                'ngayKhoiHanh' => $request->ngayKhoiHanh,
                'trangThai' => 'Pending',
            ]);

            if ($response->failed()) {
                return back()->with('error', 'Không thể đặt tour. Vui lòng thử lại.');
            }

            $result = $response->json();
            return redirect()->back()->with('success', $result['message'] ?? 'Đặt tour thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi đặt tour: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('name');

        // Gọi API tìm kiếm Java
        $response = Http::get("http://localhost:8080/api/search", [
            'name' => $keyword
        ]);

        if (!$response->ok()) {
            return back()->with('error', 'Không thể kết nối API tìm kiếm.');
        }

        $result = $response->json();

        // Lấy danh sách tour
        $tours = $result['data'] ?? [];

        return view('main.home', [
            'tours' => $tours,
            'searchKeyword' => $keyword
        ]);
    }

    

}
