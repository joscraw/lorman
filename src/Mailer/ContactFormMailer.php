<?php

namespace App\Mailer;


use App\Model\Message;

/**
 * Adapter class for the Swiftmailer library. Follows the same interface as the SwiftMailer
 * but if the Swiftmailer core code every changes we will only need to update the code
 * for sending email in one spot. RIGHT HERE!
 *
 *
 *
 * Class ContactFormMailer
 * @package App\Mailer
 *
 * @author Josh Crawmer <jcrawmer@lorman.com> - wishful thinking ;)
 */
class ContactFormMailer implements MailerInterface
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Message $message
     */
    public function send(Message $message)
    {
        $message = (new \Swift_Message($message->getSubject()))
            ->setFrom($message->getFrom())
            ->setTo($message->getTo())
            ->setBody($message->getBody(), 'text/html');

        $this->mailer->send($message);
    }


}