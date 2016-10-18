<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    protected $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;
}
