<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Model;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //清除缓存
        app()['cache']->forget('spatie.permission.cache');

        //创建权限 Permission::create(['name' => '权限名'])
        Permission::create(['name' => 'manage_contents']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'edit_settings']);

        //创建角色 Role::create(['name' => '权限名'])
        //创建站长（创始人）
        $founder = Role::create(['name' => 'Founder']);
        //赋予权限 $角色->givePermissionTo('权限名')
        $founder->givePermissionTo('manage_contents');
        $founder->givePermissionTo('manage_users');
        $founder->givePermissionTo('edit_settings');

        //创建管理员角色
        $maintainer = Role::create(['name'=>'Maintainer']);
        $maintainer->givePermissionTo('manage_contents');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //清除缓存
        app()['cache']->forget('spatie.permission.cache');

        //清空所有数据表数据

        //从配置文件中读取权限相关的表名
        $tableNames = config('permission.table_names');

        //解除模型保护
        Model::unguard();

        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['role_has_permissions'])->delete();

        // 重新开启模型保护
        Model::reguard();

    }
};
