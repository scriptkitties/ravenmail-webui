<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; 

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    public $timestamps = false;
}
