<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function hello()
    {
        // Gọi API GET
        $response = Http::get('http://localhost:8080/api/hello');
        
        // Chuyển kết quả sang mảng
        $data = $response->json();
        
        // Truyền dữ liệu sang view
        return view('hello', ['data' => $data]);
    }

    public function add()
    {
        // Gọi API POST
        $response = Http::post('http://localhost:8080/api/add', [
            'value' => 'Laravel gửi sang Java'
        ]);
        
        $data = $response->json();
        
        return view('add', ['data' => $data]);
    }
}
