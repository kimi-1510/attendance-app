<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BreakTime;
use App\Models\CorrectionRequest;
use Carbon\Carbon;


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

    public function getBreakMinutesAttribute()
    {
        // 休憩がない場合は0を返す
        if ($this->breaks->isEmpty()) {
            return 0;
        }

        //各休憩の差分を合計
        return $this->breaks->sum(function ($break) {
            return $break->duration_in_minutes; //BreakTimeのアクセサメソッドを使用
        });
    }

    public function getWorkMinutesAttribute()
    {
            // 出勤 or 退勤が無い場合は0を返す
            if (!$this->start_time || !$this->end_time) {
                return 0;
            }

            // 出勤～退勤の差分を計算
            $total = Carbon::parse($this->start_time)
                ->diffInMinutes(Carbon::parse($this->end_time));

            // 休憩合計
            $break = $this->break_minutes;

            // 実働時間
            return max($total - $break, 0);
    }
}
