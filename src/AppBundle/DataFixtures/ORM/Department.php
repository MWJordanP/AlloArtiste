<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Department;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DepartmentFixtures
 */
class DepartmentFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var string
     */
    private $filePath = 'Data/departement.csv';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $filename = __DIR__.'/../'.$this->filePath;
        $data     = $this->convertCsvArray($filename);
        if ($data) {
            $flushFrequency = 100;
            $i              = 0;
            foreach ($data as $row) {
                $department = new Department();
                $department
                    ->setName($row['name'])
                    ->setSimpleName($row['simpleName'])
                    ->setSimpleNum($row['simpleNum']);

                $manager->persist($department);

                if (($i % $flushFrequency) === 0) {
                    $manager->flush();
                }
                $i++;
            }

            $manager->flush();
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * @param string $filename
     * @param string $delimiter
     *
     * @return array|bool
     */
    private function convertCsvArray($filename, $delimiter = ',')
    {
        $header = ['name', 'simpleName', 'simpleNum'];
        $data   = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $data[] = array_combine($header, [$row[2], $row[4], $row[1]]);
            }
            fclose($handle);
        }

        return $data;
    }
}
