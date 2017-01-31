<?php

namespace App\Policies;

use App\User;
use App\Domain;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $domain)
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
    public function view(User $user, Domain $domain) : bool
    {
        if ($domain->moderators()
            ->where('user_uuid', $user->uuid)
            ->count() > 0
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create domains.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user) : bool
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
    public function update(User $user, Domain $domain) : bool
    {
        if ($domain->moderators()
            ->where('domain_moderators.admin', true)
            ->where('user_uuid', $user->uuid)
            ->count() > 0
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function delete(User $user, Domain $domain) : bool
    {
        return false;
    }
}
