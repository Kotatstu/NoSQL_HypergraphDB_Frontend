<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AdminController extends Controller
{
    private $apiUrl = 'http://localhost:8080/api'; // URL của API Java

    // =========================
    // === DASHBOARD CHÍNH ===
    // =========================
    public function index()
    {
        $error = '';
        try {
            $response = Http::get("{$this->apiUrl}/users");

            if ($response->successful()) {
                $users = collect($response->json());
            } else {
                $users = collect();
                $error = 'Không thể lấy danh sách người dùng từ API.';
            }

            return view('admin.dashboard', compact('users', 'error'));

        } catch (\Exception $e) {
            return view('admin.dashboard', [
                'users' => collect(),
                'error' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ]);
        }
    }

    // =========================
    // === USERS / NGƯỜI DÙNG ===
    // =========================
    public function listUsers()
    {
        return $this->fetchAndRender('users', 'admin.users', 'Không thể lấy danh sách người dùng từ API.');
    }

    public function editUser($email)
    {
        $response = Http::get("{$this->apiUrl}/user/{$email}");

        if ($response->successful()) {
            $user = $response->json();
            return view('admin.editUser', compact('user'));
        }

        return redirect()->route('admin.users')->with('error', 'Không tìm thấy người dùng.');
    }

    public function updateUser(Request $request, $email)
    {
        $data = $request->only(['name', 'role']);
        $response = Http::put("{$this->apiUrl}/user/{$email}", $data);

        if ($response->successful()) {
            return redirect()->route('admin.users')->with('success', 'Cập nhật người dùng thành công.');
        }

        return redirect()->route('admin.users')->with('error', 'Cập nhật người dùng thất bại.');
    }

    public function deleteUser($email)
    {
        $response = Http::delete("{$this->apiUrl}/user/{$email}");

        if ($response->successful()) {
            return redirect()->route('admin.users')->with('success', 'Xoá người dùng thành công.');
        }

        return redirect()->route('admin.users')->with('error', 'Xoá người dùng thất bại.');
    }

    // =========================
    // === ĐÁNH GIÁ ===
    // =========================
    public function listDanhGia()
    {
        return $this->fetchAndRender('danhgia', 'admin.danhgia', 'Không thể lấy danh sách đánh giá từ API.');
    }

    public function editDanhGia($id)
    {
        $response = Http::get("{$this->apiUrl}/danhgia/{$id}");

        if ($response->successful()) {
            $danhGia = $response->json();
            return view('admin.editDanhGia', compact('danhGia'));
        }

        return redirect()->route('admin.danhgia')->with('error', 'Không tìm thấy đánh giá.');
    }

    public function updateDanhGia(Request $request, $id)
    {
        $data = $request->only(['khachHangEmail', 'tourId', 'diemDanhGia', 'binhLuan', 'ngayDanhGia']);

        try {
            if ($request->has('ngayDanhGia')) {
                $data['ngayDanhGia'] = Carbon::parse($request->input('ngayDanhGia'))->toIso8601String();
            }

            $response = Http::put("{$this->apiUrl}/danhgia/{$id}", $data);

            session()->flash('success', $response->successful() ? 'Đánh giá đã được cập nhật thành công!' : 'Lỗi khi cập nhật đánh giá.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.danhgia');
    }

    public function deleteDanhGia($id)
    {
        try {
            $response = Http::delete("{$this->apiUrl}/danhgia/{$id}");

            session()->flash('success', $response->successful() ? 'Đánh giá đã được xóa thành công!' : 'Lỗi khi xóa đánh giá.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.danhgia');
    }

    // =========================
    // === HÓA ĐƠN ===
    // =========================
    public function listHoaDon()
    {
        return $this->fetchAndRender('hoadon', 'admin.hoadon', 'Không thể lấy danh sách hóa đơn từ API.');
    }

    public function editHoaDon($id)
    {
        try {
            $response = Http::get("{$this->apiUrl}/hoadon/{$id}");

            if ($response->successful()) {
                $hoaDon = $response->json();
                if (isset($hoaDon['id'])) {
                    return view('admin.editHoaDon', compact('hoaDon'));
                }
                return redirect()->route('admin.hoadon')->with('error', 'Không tìm thấy hóa đơn');
            }

            return redirect()->route('admin.hoadon')->with('error', 'Lỗi khi gọi API để lấy hóa đơn');
        } catch (\Exception $e) {
            return redirect()->route('admin.hoadon')->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function updateHoaDon(Request $request, $id)
    {
        $data = $request->only(['datTourId', 'tongTien', 'phuongThucThanhToan', 'trangThaiThanhToan', 'ngayThanhToan']);

        try {
            if ($request->has('ngayThanhToan')) {
                $data['ngayThanhToan'] = Carbon::parse($request->input('ngayThanhToan'))->toIso8601String();
            }

            $response = Http::put("{$this->apiUrl}/hoadon/{$id}", $data);

            if ($response->successful()) {
                session()->flash('success', 'Hóa đơn đã được cập nhật!');
                return redirect()->route('admin.hoadon.show', ['id' => $id]);
            } else {
                session()->flash('error', 'Lỗi khi cập nhật hóa đơn.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.hoadon');
    }

    public function deleteHoaDon($id)
    {
        try {
            $response = Http::delete("{$this->apiUrl}/hoadon/{$id}");
            session()->flash('success', $response->successful() ? 'Đã xóa hóa đơn thành công!' : 'Lỗi khi xóa hóa đơn.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.hoadon');
    }

    // =========================
    // === ĐẶT TOUR ===
    // =========================
    public function listDatTour()
    {
        return $this->fetchAndRender('dattour', 'admin.dattour', 'Không thể lấy danh sách đặt tour từ API.');
    }

    public function editDatTour($id)
    {
        try {
            $response = Http::get("{$this->apiUrl}/dattour/{$id}");

            if ($response->successful()) {
                $datTour = $response->json();
                return view('admin.editDatTour', compact('datTour'));
            }

            return redirect()->route('admin.dattour')->with('error', 'Không tìm thấy đặt tour');
        } catch (\Exception $e) {
            return redirect()->route('admin.dattour')->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function updateDatTour(Request $request, $id)
    {
        $data = $request->only(['khachHangEmail', 'tourId', 'soNguoi', 'ngayDat', 'ngayKhoiHanh', 'trangThai']);

        try {
            if (isset($data['ngayDat'])) {
                $data['ngayDat'] = Carbon::parse($data['ngayDat'])->format('Y-m-d');
            }
            if (isset($data['ngayKhoiHanh'])) {
                $data['ngayKhoiHanh'] = Carbon::parse($data['ngayKhoiHanh'])->format('Y-m-d');
            }

            $response = Http::put("{$this->apiUrl}/dattour/{$id}", $data);
            session()->flash('success', $response->successful() ? 'Đặt tour đã được cập nhật!' : 'Lỗi khi cập nhật đặt tour.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.dattour');
    }

    public function deleteDatTour($id)
    {
        try {
            $response = Http::delete("{$this->apiUrl}/dattour/{$id}");
            session()->flash('success', $response->successful() ? 'Đã xóa đặt tour thành công!' : 'Lỗi khi xóa đặt tour.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.dattour');
    }

    // =========================
    // === NHÀ TỔ CHỨC ===
    // =========================
    public function listNhaToChuc()
    {
        return $this->fetchAndRender('nhatochuc', 'admin.nhatc', 'Không thể lấy danh sách nhà tổ chức từ API.');
    }

    public function createNhaToChuc()
    {
        return view('admin.createNhatc');
    }

    public function storeNhaToChuc(Request $request)
    {
        $data = $request->only(['id', 'ten', 'email', 'sdt', 'diaChi', 'moTa']);

        try {
            $response = Http::post("{$this->apiUrl}/nhatochuc", $data);
            session()->flash('success', $response->successful() ? 'Đã thêm nhà tổ chức mới!' : 'Lỗi khi thêm nhà tổ chức.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.nhatc');
    }

    public function editNhaToChuc($id)
    {
        $response = Http::get("{$this->apiUrl}/nhatochuc/{$id}");

        if ($response->successful()) {
            $nhatochuc = $response->json();
            return view('admin.editNhatc', compact('nhatochuc'));
        }

        session()->flash('error', 'Không tìm thấy nhà tổ chức!');
        return redirect()->route('admin.nhatc');
    }

    public function updateNhaToChuc(Request $request, $id)
    {
        $data = $request->only(['ten', 'email', 'sdt', 'diaChi', 'moTa']);

        try {
            $response = Http::put("{$this->apiUrl}/nhatochuc/{$id}", $data);
            session()->flash('success', $response->successful() ? 'Đã cập nhật nhà tổ chức!' : 'Lỗi khi cập nhật nhà tổ chức.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.nhatc');
    }

    public function deleteNhaToChuc($id)
    {
        try {
            $response = Http::delete("{$this->apiUrl}/nhatochuc/{$id}");
            session()->flash('success', $response->successful() ? 'Đã xóa nhà tổ chức!' : 'Lỗi khi xóa nhà tổ chức.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.nhatc');
    }

    // === ĐỊA ĐIỂM ===
    public function listDiaDiem()
    {
        return $this->fetchAndRender('diadiem', 'admin.diadiem', 'Không thể lấy danh sách địa điểm từ API.');
    }

    public function createDiaDiem()
    {
        return view('admin.createDiaDiem');
    }

    public function storeDiaDiem(Request $request)
    {
        $data = $request->only(['id', 'tenDiaDiem', 'moTa', 'hinhAnh']);

        try {
            $response = Http::post("{$this->apiUrl}/diadiem", $data);
            session()->flash('success', $response->successful() ? 'Đã thêm địa điểm mới!' : 'Lỗi khi thêm địa điểm.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.diadiem');
    }

    public function editDiaDiem($id)
    {
        $response = Http::get("{$this->apiUrl}/diadiem/{$id}");

        if ($response->successful()) {
            $diaDiem = $response->json();
            return view('admin.editDiaDiem', compact('diaDiem'));
        }

        return redirect()->route('admin.diadiem')->with('error', 'Không tìm thấy địa điểm');
    }

    public function updateDiaDiem(Request $request, $id)
    {
        $data = $request->only(['tenDiaDiem', 'moTa', 'hinhAnh']);

        try {
            $response = Http::put("{$this->apiUrl}/diadiem/{$id}", $data);
            session()->flash('success', $response->successful() ? 'Địa điểm đã được cập nhật thành công!' : 'Lỗi khi cập nhật địa điểm.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.diadiem');
    }

    public function deleteDiaDiem($id)
    {
        try {
            $response = Http::delete("{$this->apiUrl}/diadiem/{$id}");
            session()->flash('success', $response->successful() ? 'Đã xóa địa điểm thành công!' : 'Lỗi khi xóa địa điểm.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.diadiem');
    }

    // === TOURS ===
    public function listTours()
    {
        return $this->fetchAndRender('tours', 'admin.tours', 'Không thể lấy danh sách tour từ API.');
    }

    public function createTour()
    {
        return view('admin.createTour');
    }

    public function storeTour(Request $request)
    {
        $data = $request->only(['id', 'tenTour', 'gia', 'thoiGian', 'diemKhoiHanh', 'diemDen', 'phuongTien', 'hinhAnh', 'nhaToChucId']);

        try {
            $response = Http::post("{$this->apiUrl}/tours", $data);
            session()->flash('success', $response->successful() ? 'Đã thêm tour mới!' : 'Lỗi khi thêm tour.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.tours');
    }

    public function editTour($id)
    {
        $response = Http::get("{$this->apiUrl}/tours/{$id}");

        if ($response->successful()) {
            $tour = $response->json();
            return view('admin.editTour', compact('tour'));
        }

        return redirect()->route('admin.tours')->with('error', 'Không tìm thấy tour.');
    }

    public function updateTour(Request $request, $id)
    {
        $data = $request->only(['id', 'tenTour', 'gia', 'thoiGian', 'diemKhoiHanh', 'diemDen', 'phuongTien', 'hinhAnh', 'nhaToChucId']);

        try {
            $response = Http::put("{$this->apiUrl}/tours/{$id}", $data);
            session()->flash('success', $response->successful() ? 'Tour đã được cập nhật thành công!' : 'Lỗi khi cập nhật tour.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.tours');
    }

    public function deleteTour($id)
    {
        try {
            $response = Http::delete("{$this->apiUrl}/tours/{$id}");
            session()->flash('success', $response->successful() ? 'Tour đã được xóa thành công!' : 'Lỗi khi xóa tour.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('admin.tours');
    }

    // === THỐNG KÊ ===
    public function showStatistical()
    {
        $error = null;
        $data = null;

        try {
            $response = Http::get('http://localhost:8080/api/statistical/totalRevenue');

            if ($response->successful()) {
                $data = $response->json();
            } else {
                $error = 'Không thể lấy dữ liệu từ server thống kê';
            }
        } catch (\Exception $e) {
            $error = 'Lỗi kết nối tới server thống kê: ' . $e->getMessage();
        }

        return view('admin.statistical', compact('data', 'error'));
    }

    // =========================
    // === DANH SÁCH THÀNH VIÊN NHÓM ===
    // =========================
    public function listMembers()
    {
        $members = [
            ['name' => 'Nguyễn Hoàng Long', 'mssv' => '2001222438', 'contribution' => '50%'],
            ['name' => 'Tô Minh Lợi', 'mssv' => '2001222485', 'contribution' => '50%'],
            ['name' => 'Trần Nguyên Khang', 'mssv' => '2001221983', 'contribution' => '0%'],
        ];

        return view('admin.members', compact('members'));
    }

    // =========================
    // === HÀM DÙNG CHUNG ===
    // =========================
    private function fetchAndRender($endpoint, $view, $errorMessage)
    {
        $error = '';
        try {
            $response = Http::get("{$this->apiUrl}/{$endpoint}");

            if ($response->successful()) {
                $data = collect($response->json());
            } else {
                $data = collect();
                $error = $errorMessage;
            }

            return view($view, [
                str_replace('.', '_', $endpoint) => $data,
                'error' => $error
            ]);
        } catch (\Exception $e) {
            return view($view, [
                str_replace('.', '_', $endpoint) => collect(),
                'error' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ]);
        }
    }
}
