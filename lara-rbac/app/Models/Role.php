<?php

namespace App\Models;

use Maklad\Permission\Models\Role as MakladRole;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Role extends MakladRole implements Transformable
{
    use TransformableTrait;

    protected $guard_name = 'admin';

    protected $fillable = ['name', 'display_name', 'description', 'guard_name'];

}

