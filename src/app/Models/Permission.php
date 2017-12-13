<?php

namespace Backpack\PermissionManager\app\Models;

use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Models\Permission as OriginalPermission;

class Permission extends OriginalPermission
{
    use CrudTrait;

    protected $fillable = ['name', 'updated_at', 'created_at'];

    /**
     * Gets the permission prefix (eg. admin.page)
     *
     * @return null|string
     */
    public function prefix()
    {
        if (!str_contains($this->name, '::')) {
            return null;
        }

        list($prefix) = explode('::', $this->name);

        return $prefix;
    }

    /**
     * Gets the permission item (eg. list, create, update...)
     *
     * @return string
     */
    public function item()
    {
        return str_after($this->name, '::');
    }
}
