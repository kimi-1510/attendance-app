@extends('layouts.app')

@section('title', '勤怠登録画面')

@section('content')

    {{-- ステータス表示 --}}
    <div class="attendance-status">
        <p id="status-text">{{ session('attendance_status', '勤務外') }}</p>
    </div>

    {{-- 現在日時のリアルタイム表示 --}}
    <div class="current-datetime">
        <p id="current-date"></p>
        <p id="current-time"></p>
    </div>

    {{-- 打刻ボタン --}}
    <div class="attendance-buttons">
        <form method="POST" action="{{ route('attendance.store') }}">
            @csrf
            <button type="submit" name="action" value="start">出勤</button>
            <button type="submit" name="action" value="end">退勤</button>
            <button type="submit" name="action" value="break_start">休憩入</button>
            <button type="submit" name="action" value="break_end">休憩戻</button>
        </form>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();

            const weekdays = ['日','月','火','水','木','金','土'];
            const dateStr = now.getFullYear() + '年'
                        + (now.getMonth() + 1) + '月'
                        + now.getDate() + '日'
                        + ' (' + weekdays[now.getDay()] + ')';

            const timeStr = String(now.getHours()).padStart(2, '0')
                        + ':' 
                        + String(now.getMinutes()).padStart(2, '0');

            document.getElementById('current-date').textContent = dateStr;
            document.getElementById('current-time').textContent = timeStr;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
@endsection