<?php namespace App\Presenters;

use App\Repositories\RoleRepositoryEloquent;
use App\Transformers\RoleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RolePresenter
 *
 * @package namespace App\Presenters;
 */
class RolePresenter extends FractalPresenter
{
    protected $role;

    public function __construct(RoleRepositoryEloquent $role)
    {
        $this->role = $role;
    }

    public function getTransformer()
    {
        return new RoleTransformer();
    }

    public function rolesCheckbox($user = null)
    {
        $roles = $this->role->all();

        if (!$roles->count()) {
            return '<a class="btn btn-danger-alt btn-xs" href="' . route('admin.role.create') . '"> <i class="fa fa-hand-o-right"> 添加角色</i></a>';
        }

        $checkbox = '';
        foreach ($roles as $role) {
            if ($user != null && $user->hasRole($role->name)) {
                $checkbox .= '<div class="checkbox block"><label><input type="checkbox" checked="checked"  name="roles[]" value="' . $role->name . '">' . $role->display_name . '</label></div>';
            } else {
                $checkbox .= '<div class="checkbox block"><label><input type="checkbox" name="roles[]" value="' . $role->name . '">' . $role->display_name . '</label></div>';
            }
        }

        return $checkbox;
    }
}
