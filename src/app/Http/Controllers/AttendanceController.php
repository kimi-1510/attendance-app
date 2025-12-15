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
        $action = $request->input('action'); // 打刻ボタンのアクションを取得
        $status = '勤務外'; // 初期値を設定

        // 打刻ボタンのアクションに応じてステータスを更新
        switch ($action) {
            case 'start':
                $status = '出勤中';
                break;
            case 'break_start':
                $status = '休憩中';
                break;
            case 'break_end':
                $status = '出勤中';
                break;
            case 'end':
                $status = '退勤済';
                break;
        }

        // セッションに保存
        session(['attendance_status' => $status]);

        // 勤怠登録画面に戻る
        return redirect()->route('attendance.create');
    }
}
