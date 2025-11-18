<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function create()
    {
        return view('attendance.index'); // 勤怠登録画面を表示
    }

    public function store(Request $request)
    {
        // 勤怠登録処理
    }
}
