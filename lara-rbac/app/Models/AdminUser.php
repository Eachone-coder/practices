<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Maklad\Permission\Traits\HasRoles;
use DesignMyNight\Mongodb\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $collection = 'admin_users';

    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'is_super'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
