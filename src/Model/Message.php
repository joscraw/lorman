<?php
/**
 * Created by PhpStorm.
 * User: joshcrawmer
 * Date: 2/11/18
 * Time: 1:22 AM
 */

namespace App\Model;


/**
 * Stateful message class to hold message data that is used in
 * the email services
 *
 * Class Message
 * @package App\Model
 *
 * @author Josh Crawmer <jcrawmer@lorman.com> - wishful thinking ;)
 */
class Message
{

    private $subject;

    private $from = 'info@lorman.com';

    private $to = 'guy-smiley@example.com';

    private $body;

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }


}