<?php

namespace App\Mailer;

use App\Model\Message;

/**
 * Interface MailerInterface
 * @package App\Mailer
 *
 * @author Josh Crawmer <jcrawmer@lorman.com> - wishful thinking ;)
 */
interface MailerInterface
{
    public function send(Message $message);
}