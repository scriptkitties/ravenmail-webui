<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\NoregAddress;

class Domain extends Model
{
    public function aliases()
    {
        return $this->hasMany('App\Alias', 'domain', 'name');
    }

    public function contact()
    {
        return User::findByAddressOrFail($this->attributes['contact']);
    }

    public function moderators()
    {
        return $this->belongsToMany('App\User', 'domain_moderators');
    }

    public function noreg_addresses()
    {
        return $this->hasMany(NoregAddress::class, 'domain', 'name');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'domain', 'name');
    }

    /**
     * Find a domain by its name, or throw a NotFound exception,
     */
    public static function findByNameOrFail(string $name) : Domain
    {
        $domain = self::where('name', $name)
            ->firstOrFail()
        ;

        return $domain;
    }
}

