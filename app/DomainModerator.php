<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Domain;
use App\User;

class DomainModerator extends Model
{
    public $incrementing = false;

    public function domain()
    {
        return $this->hasOne(Domain::class, 'id', 'domain_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
