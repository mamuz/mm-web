<?php

namespace Application\Service\Feature;

interface MailObjectInterface
{
    /**
     * Bind a object which will be filtered to message object
     *
     * @param mixed $object
     * @return object
     */
    public function bind($object);

    /**
     * Send message object as mail
     *
     * @return void
     */
    public function send();
}
