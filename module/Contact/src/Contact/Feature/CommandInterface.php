<?php

namespace Contact\Feature;

use Contact\Entity\Contact;

interface CommandInterface
{
    /**
     * @param Contact $contact
     * @return Contact
     */
    public function persist(Contact $contact);
}
