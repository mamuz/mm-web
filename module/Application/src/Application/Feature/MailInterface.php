<?php

namespace Application\Feature;

interface MailInterface
{
    /**
     * Bind a object which will be filtered to message object
     *
     * @param mixed $object
     * @return void
     */
    public function bind($object);

    /**
     * Send message object as mail
     */
    public function send();
}
