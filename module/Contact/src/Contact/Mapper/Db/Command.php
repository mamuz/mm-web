<?php

namespace Contact\Mapper\Db;

use Contact\Entity\Contact;
use Contact\Feature\CommandInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Command implements CommandInterface
{
    /** @var ObjectManager */
    private $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function persist(Contact $contact)
    {
        $this->objectManager->persist($contact);
        return $contact;
    }
}
