<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    use AddressTrait;

    public $timestamps = false;
}
