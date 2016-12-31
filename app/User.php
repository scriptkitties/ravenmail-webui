<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; 

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    use AddressTrait;

    public $timestamps = false;

    public function getDestinationAliases() : Collection
    {
        $aliases = Alias::where('destination', $this->getAddress())->get();

        return $aliases;
    }
}
