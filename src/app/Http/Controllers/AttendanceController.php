<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\BreakTime;

class AttendanceController extends Controller
{
    public function create()
    {
        // 今日の勤怠レコードを取得
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', now()->toDateString())
            ->first();

        // ステータスを判定
        if (!$attendance) {
            $status = '勤務外'; // まだ出勤していない

        } elseif ($attendance->end_time !== null) {
            $status = '退勤済'; // 出勤して退勤済み

        } else {
            // 出勤はしているので、休憩中かどうかを判定する
            $break = $attendance->breaks()
                ->whereNull('break_end')
                ->latest()
                ->first();
            if ($break) {
                $status = '休憩中';
            } else {
                $status = '出勤中';
            }
        }

        // ビューにステータスを渡す
        return view('attendance.index', compact('status', 'attendance'));
    }

    public function store(Request $request)
    {
        $action = $request->input('action'); // 打刻ボタンのアクションを取得

        // 打刻ボタンのアクションに応じてステータスを更新
        switch ($action) {
            case 'start':
                // 出勤時刻を保存
                Attendance::create([
                    'user_id' => auth()->id(),
                    'date' => now()->toDateString(),
                    'start_time' => now(),
                ]);
                break;

            case 'break_start':
                // 今日の勤怠レコードを取得
                $attendance = Attendance::where('user_id', auth()->id()) 
                    ->where('date', now()->toDateString()) 
                    ->first(); 

                // 休憩開始時刻を保存（BreakTimeテーブルに保存）
                BreakTime::create([
                    'attendance_id' => $attendance->id, // 勤怠ID
                    'break_start' => now(), // 休憩開始時刻
                ]);
                break;

            case 'break_end':
                // 今日の勤怠レコードを取得
                $attendance = Attendance::where('user_id', auth()->id())
                    ->where('date', now()->toDateString())
                    ->first();

                // 休憩終了時刻を取得
                $break = $attendance->breaks()
                    ->whereNull('break_end') // 休憩終了時刻が未設定の休憩を取得
                    ->latest()
                    ->first(); 

                if ($break) {
                    $break->update(['break_end' => now()]); // 休憩終了時刻を保存（更新）
                }
                break;

            case 'end':
                // 今日の出勤記録を取得して退勤時刻を保存
                $attendance = Attendance::where('user_id', auth()->id())
                    ->where('date', now()->toDateString()) // 今日の日付の出勤記録を取得
                    ->first();
                if ($attendance) {
                    $attendance->update(['end_time' => now()]); // 退勤時刻を保存
                }
                break;
        }
        // 勤怠登録画面にリダイレクト
        return redirect()->route('attendance.create');
    }
}
