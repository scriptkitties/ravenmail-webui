<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoregLocal extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    const UPDATED_AT = null;
}
