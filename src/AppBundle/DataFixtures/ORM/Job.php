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
        $datas = [
            'job 1',
            'job 2',
            'job 3',
        ];

        foreach ($datas as $data) {
            $job = new Job();
            $job->setName($data);

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
