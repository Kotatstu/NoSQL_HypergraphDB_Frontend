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
                return redirect()->route('login')->with('success', 'Đăng ký thành công, hãy đăng nhập.');
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
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất.');
    }
}
