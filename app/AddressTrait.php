<?php

namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait AddressTrait {
    public function getAddress() : string
    {
        return $this->local . '@' . $this->domain;
    }

    public static function findByAddressOrFail(string $address) : self
    {
        $parts = explode('@', $address);

        if (count($parts) < 2) {
            throw new ModelNotFoundException();
        }

        $result = self::where('domain', array_pop($parts))
            ->where('local', implode('@', $parts))
            ->firstOrFail()
        ;

        return $result;
    }

    public static function findByAddress(string $address)
    {
        $parts = explode('@', $address);

        if (count($parts) < 2) {
            throw new ModelNotFoundException();
        }

        $result = self::where('domain', array_pop($parts))
            ->where('local', implode('@', $parts))
            ->first()
        ;

        return $result;
    }
}

