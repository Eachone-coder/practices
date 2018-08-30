<?php

Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin.home'));
});

Breadcrumbs::register('admin-user', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('用户管理', route('admin.admin_user.index'));
});

Breadcrumbs::register('admin-permission', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('权限管理', route('admin.permission.index'));
});

Breadcrumbs::register('admin-role', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('角色管理', route('admin.role.index'));
});

