<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Alias;
use App\User;
use App\Verification;

class VerifyAlias extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Alias $alias, Verification $verification)
    {
        $this->user = $user;
        $this->alias = $alias;
        $this->verification = $verification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify alias destination from ' . $this->user->getAddress())
            ->text('mail.alias.verify')
            ->with([
                'origin' => $this->user->getAddress(),
                'destination' => $this->destination->getAddress(),
                'contact' => $this->user->domain()->contact,
                'url' => route('user.alias.verify.index', [
                    'user' => $this->user->getAddress(),
                    'alias' => $this->alias->getAddress(),
                    'uuid' => $this->verification->uuid
                ]),
            ])
        ;
    }
}
