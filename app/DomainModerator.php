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

        $self = self::where('domain_id', $domain->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return $self;
    }

    public function domain()
    {
        return $this->hasOne(Domain::class, 'id', 'domain_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
