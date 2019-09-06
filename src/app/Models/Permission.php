<?php

namespace Backpack\PermissionManager\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Models\Permission as OriginalPermission;

class Permission extends OriginalPermission
{
    use CrudTrait;

    protected $fillable = ['name', 'guard_name', 'updated_at', 'created_at'];
}
