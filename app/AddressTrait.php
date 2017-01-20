<?php

namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait AddressTrait {
    public function getAddress() : string
    {
        return $this->local . '@' . $this->domain->name;
    }

    public static function findByAddressOrFail(string $address) : self
    {
        $result = self::findByAddress($address);

        if ($result === null) {
            throw new ModelNotFoundException();
        }

        return $result;
    }

    public static function findByAddress(string $address)
    {
        $parts = explode('@', $address);

        if (count($parts) < 2) {
            throw new ModelNotFoundException();
        }

        $result = Domain::findByNameOrFail(array_pop($parts))
            ->users->where('local', implode('@', $parts))
            ->first();

        return $result;
    }
}

