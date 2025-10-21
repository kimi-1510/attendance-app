<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // 一括代入が可能なカラム
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    // JSONに変換する隠すカラム
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    // 型変換するカラム
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // リレーション：ユーザーは複数の勤怠を持つ
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // リレーション：ユーザーは複数の修正申請を持つ
    public function correctionRequests()
    {
        return $this->hasMany(CorrectionRequest::class);
    }
}
