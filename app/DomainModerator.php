<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DomainModerator extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    public static function findByCredsOrFail(string $domain_name, string $user_address) : self
    {
        $domain = Domain::findByNameOrFail($domain_name);
        $user = User::findByAddressOrFail($user_address);

        $self = self::where('domain_uuid', $domain->uuid)
            ->where('user_uuid', $user->uuid)
            ->firstOrFail();

        return $self;
    }

    public function domain()
    {
        return $this->hasOne(Domain::class, 'uuid', 'domain_uuid');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
