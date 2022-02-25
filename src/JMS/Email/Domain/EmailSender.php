<?php

namespace JMS\Email\Domain;

use JMS\Email\Domain\Entity\Email;

interface EmailSender
{
    public function send(Email $email): void;
}
