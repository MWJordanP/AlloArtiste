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
        $password    = password_hash('xxx', PASSWORD_BCRYPT, ['cost' => 4]);
        $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla pellentesque, ante at tempus iaculis, risus ligula efficitur lacus, a feugiat enim mauris in risus. Sed sollicitudin nunc a neque porta auctor. Proin suscipit fringilla metus sed accumsan. Nam rhoncus nulla non magna aliquam euismod. Duis vestibulum mattis venenatis. Aliquam ultricies ultrices tempor. Mauris tellus velit, molestie vitae pharetra ut, ultricies a eros. Maecenas dignissim urna ac bibendum vehicula. Aliquam consectetur consectetur nibh et vehicula. Maecenas sit amet blandit velit, in hendrerit est. Donec lobortis posuere velit, id molestie lectus placerat sit amet. Praesent ut molestie eros. Nullam condimentum cursus augue at ultricies. Fusce ac felis iaculis, feugiat ante nec, molestie ex. Nam fringilla ligula sed dignissim congue.";
        $datas       = [
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
                ->setDescription($description)
                ->setEnabled(true);

            $manager->persist($user);
            $this->addReference('user'.$key, $user);
        }

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user
                ->setDescription($description)
                ->setCity($this->getReference('city'.$i))
                ->setJob($this->getReference('job'.$i))
                ->setFirstName('First Name '.$i)
                ->setLastName('Last Name '.$i)
                ->setUsername('Username '.$i)
                ->setEmail('email'.$i.'@gmail.com')
                ->setPassword($password)
                ->setEnabled(true);

            for ($e = 0; $e < 2; $e++) {
                $number = random_int(0, 98);
                if (!$user->getTags()->contains($this->getReference('tag'.$number))) {
                    $user->getTags()->add($this->getReference('tag'.$number));
                }
            }
            $bool = random_int(0, 1);
            if ($bool) {
                $user->addRole('ROLE_ARTIST');
            } else {
                $user->addRole('ROLE_CUSTOMER');
            }

            $manager->persist($user);
            $this->addReference('userfack'.$i, $user);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }
}
