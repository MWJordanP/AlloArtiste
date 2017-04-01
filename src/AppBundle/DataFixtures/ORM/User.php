<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

/**
 * Class UserFixtures
 */
class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $password = password_hash('xxx', PASSWORD_BCRYPT, ['cost' => 4]);
        $datas    = [
            [
                'firstName' => 'Jordan',
                'lastName'  => 'PREVOT',
                'username'  => 'pjordan',
                'email'     => 'jordan@gmail.com',
                'role'      => 'ROLE_SUPER_ADMIN',
            ],
        ];

        foreach ($datas as $key => $data) {
            $user = new User();
            $user
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setUsername($data['username'])
                ->setEmail($data['email'])
                ->addRole($data['role'])
                ->setPassword($password)
                ->setEnabled(true);

            $manager->persist($user);
            $this->addReference('user'.$key, $user);
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
