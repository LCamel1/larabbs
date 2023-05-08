<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    /**
     * 授权之前 $user当前用户 $ability权限策略
     */
    public function before($user, $ability)
	{
	    // if ($user->isSuperAdmin()) {
	    // 		return true;
	    // }

        if ($user->can('manage_contents')) {
            return true;
        }
	}
}
