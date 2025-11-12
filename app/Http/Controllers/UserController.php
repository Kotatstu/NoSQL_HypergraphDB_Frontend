<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    private $apiUrl = 'http://localhost:8080/api'; // URL của Java API

    /*HIỂN THỊ TRANG LOGIN */
    public function showLogin()
    {
        if (session('loggedIn')) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /*XỬ LÝ ĐĂNG NHẬP*/
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 3 ký tự.',
        ]);

        try {
            $response = Http::post("{$this->apiUrl}/login", [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Nếu đăng nhập thành công
            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['user'])) {
                    session([
                        'loggedIn' => true,
                        'user' => $data['user'],
                    ]);

                    return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
                }

                return back()->with('error', 'Sai email hoặc mật khẩu.');
            }

            // Nếu API trả lỗi 401 (unauthorized)
            if ($response->status() === 401) {
                return back()->with('error', 'Sai email hoặc mật khẩu.');
            }

            return back()->with('error', 'Không thể kết nối tới API.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    /*HIỂN THỊ TRANG ĐĂNG KÝ */
    public function showRegister()
    {
        if (session('loggedIn')) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    /*XỬ LÝ ĐĂNG KÝ*/
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|min:3|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'name.min' => 'Họ tên phải có ít nhất 3 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 3 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        try {
            $response = Http::post("{$this->apiUrl}/register", [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Nếu đăng ký thành công
            if ($response->successful()) {
                return redirect()->route('login.post')->with('success', 'Đăng ký thành công, hãy đăng nhập.');
            }

            // Nếu API trả về lỗi (VD: email trùng)
            $status = $response->status();
            $data = $response->json();

            if (in_array($status, [400, 409])) {
                $message = $data['message'] ?? 'Email đã tồn tại, vui lòng chọn email khác.';
                return back()->withInput()->with('error', $message);
            }

            return back()->withInput()->with('error', 'Không thể kết nối tới API.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    /*ĐĂNG XUẤT*/
    public function logout()
    {
        session()->flush();
        return redirect()->route('login.show')->with('success', 'Bạn đã đăng xuất.');
    }

    public function showUserTours()
    {
        // Kiểm tra đăng nhập
        if (!session('loggedIn') || !session('user')) {
            return redirect()->route('login.show')->with('error', 'Vui lòng đăng nhập để xem tour của bạn.');
        }

        $user = session('user');
        $email = $user['email'];

        try {
            $response = Http::get("{$this->apiUrl}/dattour/{$email}");

            if ($response->successful()) {
                $tours = $response->json();
                return view('main.tours', compact('tours', 'user'));
            }

            if ($response->status() === 404) {
                return view('main.tours', [
                    'tours' => [],
                    'user' => $user,
                    'message' => 'Bạn chưa đặt tour nào.'
                ]);
            }

            return view('main.tours', [
                'tours' => [],
                'user' => $user,
                'message' => 'Không thể lấy danh sách tour. Vui lòng thử lại sau.'
            ]);
        } catch (\Exception $e) {
            return view('main.tours', [
                'tours' => [],
                'user' => $user,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ]);
        }
    }

    public function payTour(Request $request, $id)
    {
        if (!session('loggedIn') || !session('user')) {
            return redirect()->route('login.show')->with('error', 'Vui lòng đăng nhập.');
        }

        $user = session('user');
        $email = $user['email'];

        // Nhận phương thức thanh toán từ form modal (ví dụ: MoMo, Card, Cash)
        $phuongThuc = $request->input('phuongThucThanhToan', 'Cash');

        try {
            // =====Cập nhật trạng thái tour sang Paid =====
            $updateResponse = Http::put("{$this->apiUrl}/dattour/{$email}/{$id}/paid");

            if (!$updateResponse->successful()) {
                $data = $updateResponse->json();
                $message = $data['message'] ?? 'Không thể cập nhật trạng thái tour.';
                return redirect()->route('user.tours')->with('error', $message);
            }

            // =====Gọi API tạo hóa đơn thanh toán =====
            $payResponse = Http::asJson()->post("{$this->apiUrl}/hoadon/{$email}/{$id}/pay", [
                'phuongThucThanhToan' => $phuongThuc
            ]);

            if ($payResponse->successful()) {
                $data = $payResponse->json();
                $message = $data['message'] ?? "Thanh toán tour $id thành công.";
                $method = $data['phuongThucThanhToan'] ?? $phuongThuc;
                $tongTien = $data['tongTien'] ?? null;

                $successMsg = $message;
                if ($tongTien !== null) {
                    $successMsg .= " (Số tiền: " . number_format($tongTien, 0, ',', '.') . "đ, Phương thức: $method)";
                }

                return redirect()->route('user.tours')->with('success', $successMsg);
            }

            // Nếu hóa đơn không được tạo thành công
            $data = $payResponse->json();
            $message = $data['message'] ?? 'Không thể tạo hóa đơn thanh toán.';
            return redirect()->route('user.tours')->with('error', $message);

        } catch (\Exception $e) {
            return redirect()->route('user.tours')->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }


    public function cancelTour($id)
    {
        // Kiểm tra đăng nhập
        if (!session('loggedIn') || !session('user')) {
            return redirect()->route('login.show')->with('error', 'Vui lòng đăng nhập.');
        }

        $user = session('user');
        $email = $user['email'];

        try {
            // Gọi API Java để cập nhật trạng thái sang Cancelled
            $response = Http::put("{$this->apiUrl}/dattour/{$email}/{$id}/cancelled");

            if ($response->successful()) {
                return redirect()->route('user.tours')->with('success', 'Đã hủy tour thành công!');
            } else {
                return redirect()->route('user.tours')->with('error', 'Không thể hủy tour. Vui lòng thử lại.');
            }
        } catch (\Exception $e) {
            return redirect()->route('user.tours')->with('error', 'Lỗi khi hủy tour: ' . $e->getMessage());
        }
    }



}
