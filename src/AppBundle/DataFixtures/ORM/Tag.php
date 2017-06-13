<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class TagFixtures
 */
class TagFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $tag = new Tag();
            $tag->setName('Tag '.$i);

            $manager->persist($tag);
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
