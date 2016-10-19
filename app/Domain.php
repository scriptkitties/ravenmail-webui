<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany('App\User', 'domain', 'name');
    }

    public function aliases()
    {
        return $this->hasMany('App\Alias', 'domain', 'name');
    }
}

