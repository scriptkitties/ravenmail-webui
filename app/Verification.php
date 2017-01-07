<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    public static function generate() : self
    {
        $self = new self();
        $self->uuid = Uuid::generate(5, config('app.name'), Uuid::NS_DNS);
        $self->save();

        return $self;
    }
}
