<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BreakTime extends Model
{
    use HasFactory;

    protected $table = 'breaks';

    // 一括代入を許可するカラム
    protected $fillable = [
        'attendance_id',
        'break_start',
        'break_end',
    ];

    protected $casts = [
        'break_start' => 'datetime',
        'break_end' => 'datetime',
    ];

    // リレーション：休憩は勤怠に属する
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function getDurationInMinutesAttribute()
    {
        if ($this->break_start && $this->break_end) {
            return Carbon::parse($this->break_start)->diffInMinutes(Carbon::parse($this->break_end));
        }
        return 0;
    }
}
