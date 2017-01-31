<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Domain extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    public function aliases() : Relation
    {
        return $this->hasMany(Alias::class, 'domain_uuid');
    }

    public function moderators() : Relation
    {
        return $this->hasMany(DomainModerator::class, 'domain_uuid');
    }

    public function noregAddresses() : Relation
    {
        return $this->hasMany(NoregAddress::class, 'domain_uuid');
    }

    public function users() : Relation
    {
        return $this->hasMany(User::class, 'domain_uuid');
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

