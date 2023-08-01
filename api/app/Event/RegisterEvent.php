<?php


namespace App\Event;

class RegisterEvent
{
    public $user;

    public $inviteUser;

    public function __construct($user, $inviteUser)
    {
        $this->user = $user;

        $this->inviteUser = $inviteUser;
    }
}