<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Job;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class JobFixtures
 */
class JobFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $job = new Job();
            $this->addReference('job'.$i, $job);
            $job->setName('Job '.$i);

            $manager->persist($job);
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
