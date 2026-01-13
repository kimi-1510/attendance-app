@extends('layouts.app')

@section('title', '勤怠一覧')

@section('content')
    <h1>勤怠一覧</h1>

    <table border="1">
        <thead>
            <tr>
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
        @php
            use Carbon\Carbon;

            $currentMonth = Carbon::parse($month);
            $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
            $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');
        @endphp

        <div style="margin-bottom: 20px;">
            <a href="{{ route('attendance.list', ['month' =>$prevMonth]) }}">前月</a>
            <span style="margin: 0 20px; font-weight: bold;">
                {{ $currentMonth->format('Y年m月') }}
            </span>
            <a href="{{ route('attendance.list', ['month' =>$nextMonth]) }}">翌月</a>
        </div>

        @php
            $current = $start->copy();
            $weekMap = [
                'Sun' => '日', 'Mon' => '月', 'Tue' => '火',
                'Wed' => '水', 'Thu' => '木', 'Fri' => '金', 'Sat' => '土'
            ];
        @endphp

        @while($current->lte($end))
            @php
                $dateKey = $current->toDateString();
                $attendance = $attendances[$dateKey] ?? null;
                $weekday = $weekMap[$current->format('D')];
            @endphp

            <tr>
                {{-- 日付 --}}
                <td>{{ $current->format('m/d') }}({{ $weekday }})</td>

                {{-- 出勤 --}}
                <td>
                    {{ $attendance?->start_time
                        ? Carbon::parse($attendance->start_time)->format('H:i')
                        : '' }}
                </td>

                {{-- 退勤 --}}
                <td>
                    {{ $attendance?->end_time
                        ? Carbon::parse($attendance->end_time)->format('H:i')
                        : '' }}
                </td>

                {{-- 休憩 --}}
                <td>
                    @if($attendance)
                        @php
                            $breakMinutes = $attendance->break_minutes;
                            $breakHours = floor($breakMinutes / 60);
                            $breakRemain = $breakMinutes % 60;
                        @endphp
                        {{ sprintf('%02d:%02d', $breakHours, $breakRemain) }}
                    @endif
                </td>

                {{-- 実働 --}}
                <td>
                    @if($attendance)
                        @php
                            $workMinutes = $attendance->work_minutes;
                            $workHours = floor($workMinutes / 60);
                            $workRemain = $workMinutes % 60;
                        @endphp
                        {{ sprintf('%02d:%02d', $workHours, $workRemain) }}
                    @endif
                </td>

                {{-- 詳細 --}}
                <td>
                    @if($attendance)
                        <a href="{{ route('attendance.show', $attendance->id) }}">詳細</a>
                    @endif
                </td>
            </tr>

            @php
                $current->addDay();
            @endphp
        @endwhile
        </tbody>
    </table>
@endsection
