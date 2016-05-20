<?php

namespace Backpack\PermissionManager\app\Models;

use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Models\Permission as OriginalPermission;

class Permission extends OriginalPermission
{
    use CrudTrait;

    protected $fillable = ['name', 'updated_at', 'created_at'];
}
