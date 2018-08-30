<?php

use Illuminate\Database\Seeder;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;
use App\Models\AdminUser;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {

        app()['cache']->forget('maklad.permission.cache');

        Permission::firstOrCreate([
            'fid'=>'0',
            'name'=>'admin.home',
            'display_name'=>'Dashboard',
            'description'=>'后台首页',
            'icon'=>'home',
            'is_menu'=>'1',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        // create permissions
        $permission = Permission::firstOrCreate([
            'fid'=>'0',
            'name'=>'#',
            'display_name'=>'系统设置',
            'description'=>'',
            'icon'=>'edit',
            'is_menu'=>'1',
            'guard_name'=>'admin',
            'sort'=>'100'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.admin_user.index',
            'display_name'=>'用户权限',
            'description'=>'查看后台用户列表',
            'icon'=>'edit',
            'is_menu'=>'1',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.admin_user.create',
            'display_name'=>'创建后台用户',
            'description'=>'页面',
            'icon'=>'edit',
            'is_menu'=>'1',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.admin_user.store',
            'display_name'=>'保存新建后台用户',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.admin_user.destroy',
            'display_name'=>'删除后台用户',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.admin_user.destory.all',
            'display_name'=>'批量后台用户删除',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.admin_user.edit',
            'display_name'=>'编辑后台用户',
            'description'=>'页面',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.admin_user.update',
            'display_name'=>'保存编辑后台用户',
            'description'=>'',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.permission.index',
            'display_name'=>'权限管理',
            'description'=>'页面',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.permission.create',
            'display_name'=>'新建权限',
            'description'=>'页面',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.permission.store',
            'display_name'=>'保存新建权限',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.permission.edit',
            'display_name'=>'编辑权限',
            'description'=>'页面',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.permission.update',
            'display_name'=>'保存编辑权限',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);


        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.permission.destroy',
            'display_name'=>'删除权限',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.permission.destory.all',
            'display_name'=>'批量删除权限',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.role.index',
            'display_name'=>'角色管理',
            'description'=>'页面',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.role.create',
            'display_name'=>'新建角色',
            'description'=>'页面',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.role.store',
            'display_name'=>'保存新建角色',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.role.edit',
            'display_name'=>'编辑角色',
            'description'=>'页面',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.role.update',
            'display_name'=>'保存编辑角色',
            'description'=>'页面',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.role.permissions',
            'display_name'=>'角色权限设置',
            'description'=>'页面',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.role.destroy',
            'display_name'=>'角色删除',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        Permission::firstOrCreate([
            'fid'=>$permission->_id,
            'name'=>'admin.role.destory.all',
            'display_name'=>'批量删除角色',
            'description'=>'操作',
            'icon'=>'',
            'is_menu'=>'0',
            'guard_name'=>'admin',
            'sort'=>'0'
        ]);

        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name'=>'admin']);
        $role->givePermissionTo('admin.home');
        $role->givePermissionTo('#-1');
        $role->givePermissionTo('admin.admin_user.index');
        $role->givePermissionTo('admin.admin_user.create');
        $role->givePermissionTo('admin.admin_user.store');
        $role->givePermissionTo('admin.admin_user.destroy');
        $role->givePermissionTo('admin.admin_user.destory.all');
        $role->givePermissionTo('admin.admin_user.edit');
        $role->givePermissionTo('admin.admin_user.update');
        $role->givePermissionTo('admin.permission.index');
        $role->givePermissionTo('admin.permission.create');
        $role->givePermissionTo('admin.permission.store');
        $role->givePermissionTo('admin.permission.edit');
        $role->givePermissionTo('admin.permission.update');
        $role->givePermissionTo('admin.permission.destroy');
        $role->givePermissionTo('admin.permission.destory.all');
        $role->givePermissionTo('admin.role.index');
        $role->givePermissionTo('admin.role.create');
        $role->givePermissionTo('admin.role.store');
        $role->givePermissionTo('admin.role.edit');
        $role->givePermissionTo('admin.role.update');
        $role->givePermissionTo('admin.role.permissions');
        $role->givePermissionTo('admin.role.destroy');
        $role->givePermissionTo('admin.role.destory.all');


        $adminUser = AdminUser::where('name','admin')->first();
        $adminUser->assignRole('admin');
    }
}
