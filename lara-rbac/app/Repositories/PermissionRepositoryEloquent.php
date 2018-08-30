<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PermissionRepository;
use App\Models\Permission;
use App\Validators\PermissionValidator;

/**
 * Class PermissionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * get top permissions
     * @return mixed
     */
    public function topPermissions()
    {
        return $this->model->where('fid', '0')->orderBy('sort', 'asc')->orderBy('_id', 'asc')->get();
    }

    public function create(array $attributes)
    {
        $attributes['guard_name'] = $this->model->guard_name;
        return $this->model->create($attributes);
    }

    /**
     * update permission
     * @param array $attributes
     * @param $id
     * @return array
     */
    public function update(array $attributes, $id)
    {
        if(starts_with($attributes['name'], '#')) {
            $inputs['name'] = '#-' . time();
        }

        $isAble = $this->model->where('_id', '<>', $id)->where('name', $attributes['name'])->count();
        if($isAble) {
            return [
                'status' => false,
                'msg' => '权限路由已被使用'
            ];
        }
        $result = parent::update($attributes, $id);
        if(!$result) {
            return [
                'status' => false,
                'msg' => '权限更新失败'
            ];
        }

        return ['status' => true];
    }

    /**
     * Destroy permission by id
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        $permission = $this->model->find($id);
        if(!$permission) {
            return false;
        }
        $permission->roles()->detach();
        return parent::delete($id);
    }

    /**
     * Permission Menus
     * @return array
     */
    public function menus()
    {
        $menus = [];
        $father = $this->model->where('fid', '0')->where('is_menu', '1')->orderBy('sort', 'asc')->orderBy('_id', 'asc')->get()->toArray();
        if($father) {
            foreach ($father as $item) {

                if($item['sub_permission']) {
                    foreach ($item['sub_permission'] as $key => $sub) {
                        if($sub['is_menu']) {
                            $item['sub'][] = $sub;
                        }
                    }
                    unset($item['sub_permission']);
                }

                $menus[] = $item;
            }
        }

        return $menus;
    }
}
