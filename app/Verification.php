<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Verification extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    public static function generate() : self
    {
        $self = new self();
        $self->save();

        return $self;
    }
}
