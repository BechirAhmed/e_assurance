<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Permission extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function defaultPermissions()
    {
        return [
            'access_users',
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',

            'access_roles',
            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',

            'access_permissions',
            'view_permissions',
            'add_permissions',
            'edit_permissions',
            'delete_permissions',


            'access_assurances',
            'view_assurances',
            'add_assurances',
            'edit_assurances',
            'delete_assurances',

            'access_customers',
            'view_customers',
            'add_customers',
            'edit_customers',
            'delete_customers',

        ];
    }
}
