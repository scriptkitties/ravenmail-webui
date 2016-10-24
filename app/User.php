<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; 
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    use AddressTrait;

    public $timestamps = false;

    public static function findByAddressOrFail(string $address) : User
    {
        $parts = explode('@', $address);

        if (count($parts) < 2) {
            throw new ModelNotFoundException();
        }

        $user = self::where('domain', array_pop($parts))
            ->where('local', implode('@', $parts))
            ->firstOrFail()
        ;

        return $user;
    }

    public function getDestinationAliases() : Collection
    {
        $aliases = Alias::where('destination', $this->getAddress())->get();

        return $aliases;
    }
}
