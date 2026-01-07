<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BreakTime;
use App\Models\CorrectionRequest;

class Attendance extends Model
{
    use HasFactory;

    // 一括代入を許可するカラム
    protected $fillable = [
        'user_id',
        'date',
        'status',
        'start_time',
        'end_time',
    ];

    // リレーション：ユーザーは複数の勤怠を持つ
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // リレーション：勤怠は複数の休憩を持つ
    public function breaks()
    {
        return $this->hasMany(BreakTime::class);
    }

    // リレーション：勤怠は複数の修正申請を持つ
    public function correctionRequests()
    {
        return $this->hasMany(CorrectionRequest::class);
    }
}
