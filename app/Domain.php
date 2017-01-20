<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\NoregAddress;
use App\DomainModerator;

class Domain extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    public function aliases()
    {
        return $this->hasMany(Domain::class, 'domain_uuid', 'uuid');
    }

    public function contact()
    {
        return User::findByAddressOrFail($this->attributes['contact']);
    }

    public function moderators()
    {
        return $this->hasMany(DomainModerator::class);
    }

    public function noreg_addresses()
    {
        return $this->hasMany(NoregAddress::class, 'domain_uuid', 'uuid');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'domain_uuid', 'uuid');
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

