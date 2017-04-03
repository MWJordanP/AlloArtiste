<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Contact;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ContactFixtures
 */
class ContactFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $datas = [
            [
                'firstName' => 'Jordan',
                'lastName'  => 'PREVOT',
                'email'     => 'jordan@gmail.com',
                'title'     => 'Contact 1',
                'content'   => 'Content 1',
            ],
            [
                'firstName' => 'Laura',
                'lastName'  => 'Balk',
                'email'     => 'laura@gmail.com',
                'title'     => 'Contact 2',
                'content'   => 'Content 2',
            ],
        ];

        foreach ($datas as $data) {
            $contact = new Contact();
            $contact
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setEmail($data['email'])
                ->setTitle($data['title'])
                ->setContent($data['content']);

            $manager->persist($contact);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
