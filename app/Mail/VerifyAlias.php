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
    public function __construct(User $user, Alias $alias)
    {
        $this->user = $user;
        $this->alias = $alias;
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
                'destination' => $this->alias->destination,
                'domain' => $this->user->domain()->name,
                'contact' => $this->user->domain()->contact,
                'url' => route('verify', [
                    'type' => 'alias',
                    'uuid' => $this->alias->verification
                ]),
            ])
        ;
    }
}
