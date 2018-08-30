<?php

namespace App\Models;

use Maklad\Permission\Models\Permission as MakladPermission;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Permission.
 *
 * @package namespace App\Models;
 */
class Permission extends MakladPermission implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fid', 'icon', 'name', 'display_name', 'description', 'is_menu', 'sort', 'guard_name'];

    protected $appends = ['icon_html', 'sub_permission'];

    protected $guard_name = 'admin';

    public function getIconHtmlAttribute()
    {
        return $this->attributes['icon'] ? '<i class="fa fa-' . $this->attributes['icon'] . '"></i>' : '';
    }

    // public function getNameAttribute($value)
    // {
    //     if(starts_with($value, '#')) {
    //         return head(explode('-', $value));
    //     }
    //     return $value;
    // }
    //
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ($value == '#') ? '#-' . time() : $value;
    }

    public function getSubPermissionAttribute()
    {
        return ($this->fid == 0) ? $this->where('fid',$this->_id)->orderBy('sort', 'asc')->get() : null;
    }
}
