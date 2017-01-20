<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    use AddressTrait;
    use UuidTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    public static function makeWithVerification() : self
    {
        $verification = Verification::generate();
        $self = new Alias();
        $self->verification_uuid = $verification->uuid;

        return $self;
    }
}
