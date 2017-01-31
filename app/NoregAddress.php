<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoregAddress extends Model
{
    use AddressTrait;
    use UuidTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    const UPDATED_AT = null;
}

