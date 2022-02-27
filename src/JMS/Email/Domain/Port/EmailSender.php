<?php

namespace JMS\Email\Domain\Port;

use JMS\Email\Domain\Entity\Email;

interface EmailSender
{
    public function send(Email $email): void;
}
