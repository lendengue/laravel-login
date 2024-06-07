<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    const CREATED_AT = 'created_at';
    const UPDATE_AT = 'updated_at';

    protected $connection = 'mysql';
    protected $table = 'tbl_user';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'username',
        'password',
        'email',
        'name',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes[$this->getAuthIdentifierName()];
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
