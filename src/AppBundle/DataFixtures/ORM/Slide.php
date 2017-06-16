<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Picture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Slide;

/**
 * Class SlideFixtures
 */
class SlideFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $datas = [
            [
                'name' => 'https://res.cloudinary.com/dhtqnerfj/image/upload/v1497534628/2377659.jpg',
            ],
            [
                'name' => 'http://res.cloudinary.com/dhtqnerfj/image/upload/v1497549845/Plus-belles-photos-de-nature.jpg',
            ],
            [
                'name' => 'http://res.cloudinary.com/dhtqnerfj/image/upload/v1497608010/t%C3%A9l%C3%A9chargement.jpg',
            ],
            [
                'name' => 'http://res.cloudinary.com/dhtqnerfj/image/upload/v1497608216/parc-national-de-banff-paysage-canada.jpg',
            ],
        ];

        foreach ($datas as $key => $data) {
            $picture = new Picture();
            $picture->setName($data['name']);

            $slide = new Slide();
            $slide->setPicture($picture);

            $manager->persist($slide);
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
