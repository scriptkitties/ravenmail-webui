<?php

namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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
            return null;
        }

        $result = DB::table('domains')
            ->select('users.uuid')
            ->join('users', 'domains.uuid', '=', 'users.domain_uuid')
            ->where('domains.name', '=', array_pop($parts))
            ->where('users.local', '=', implode('@', $parts))
            ->first()
            ;

        if ($result === null) {
            return null;
        }

        return User::find($result->uuid);
    }
}

