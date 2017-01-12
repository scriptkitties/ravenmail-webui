<?php

namespace App\Policies;

use App\User;
use App\Domain;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy
{
    use HandlesAuthorization;

    public function before(User $user, Domain $domain)
    {
        if ($user->admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function view(User $user, Domain $domain)
    {
        if ($domain->moderators()
            ->where('user_id', $user->id)
            ->count() > 0
        ) {
            return true;
        }
    }

    /**
     * Determine whether the user can create domains.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function update(User $user, Domain $domain)
    {
        if ($domain->moderators()
            ->where('admin', true)
            ->where('user_id', $user->id)
            ->count() > 0
        ) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function delete(User $user, Domain $domain)
    {
        return false;
    }
}
