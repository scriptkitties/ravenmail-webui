<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $primaryKey = 'name';
    public $incrementing = false;

    public function aliases()
    {
        return $this->hasMany('App\Alias', 'domain', 'name');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'domain', 'name');
    }

    public function contact()
    {
        return User::findByAddressOrFail($this->attributes['contact']);
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

