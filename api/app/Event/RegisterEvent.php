<?php


namespace App\Event;

class RegisterEvent
{
    public $userId;

    public $inviteUserId;

    public function __construct($userId, $inviteUserId)
    {
        $this->userId = $userId;

        $this->inviteUserId = $inviteUserId;
    }
}