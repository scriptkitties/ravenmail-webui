<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DomainModerator extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    public function domain()
    {
        return $this->hasOne(Domain::class, 'id', 'domain_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
