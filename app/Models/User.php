<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'mobile',
        'password',
        'role',

        'type',
        'first_name',
        'last_name',
        'corporate_name',
        'sex',
        'mobile_sms',
        'phone1',
        'phone2',
        'phone3',
        'national_code',
        'economical_code',
        'register_code',
        'website',
        'birthday',
        'description',

        'address',
        'province_id',
        'city_id',
        'postal_code',

        'status',
        'last_login',
        'last_try',
        'failed_login_count',
        'email_verified_at',
        'mobile_verified_at',
        'is_deleted',
        'remember_token',
        'created_at',
        'updated_at',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullName()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }
}
