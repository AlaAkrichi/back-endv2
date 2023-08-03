<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $fillable = [
        "user_id",
        "first_name",
        "last_name",
        "date_of_birth",
        "email",
        "password",
        "role",
        "status"
    ];
    protected $casts = [
        "user_role" => UserRole::class,
        "user_status" => UserStatus::class,
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        "password",
        'remember_token',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
