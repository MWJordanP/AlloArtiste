<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\City;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CityFixtures
 */
class CityFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var string
     */
    private $filePath = 'Data/villes_france_full.csv';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $filename = __DIR__.'/../'.$this->filePath;
        $data     = $this->convertCsvArray($filename);
        if ($data) {
            $flushFrequency = 1000;
            $i              = 1;

            foreach ($data as $key => $row) {
                $num = substr($row['simpleNum'], 0, 2);
                $num = trim($num);
                if (strlen($num) < 2) {
                    $num = '0'.$num;
                }
                $department = $manager->getRepository('AppBundle:Department')->findOneBy(['simpleNum' => $num]);
                $city       = new City();
                $this->addReference('city'.$key, $city);
                $city
                    ->setName($row['name'])
                    ->setSimpleName($row['simpleName'])
                    ->setLongitude($row['longitude'])
                    ->setLatitude($row['latitude'])
                    ->setDepartment($department);

                $zipCode = substr($row['zipCode'], 0, 5);
                $zipCode = trim($zipCode);
                if (strlen($zipCode) < 5) {
                    $zipCode = '0'.$zipCode;
                }
                $city->setZipCode($zipCode);

                $manager->persist($city);

                if (($i % $flushFrequency) === 0) {
                    $manager->flush();
                    $manager->clear();
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
        return 2;
    }

    /**
     * @param string $filename
     * @param string $delimiter
     *
     * @return array|bool
     */
    private function convertCsvArray($filename, $delimiter = ',')
    {
        $header = ['name', 'simpleNum', 'simpleName', 'zipCode', 'longitude', 'latitude', 'county'];
        $data   = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $data[] = array_combine($header, [$row[5], $row[1], $row[4], $row[8], $row[13], $row[14], $row[1]]);
            }
            fclose($handle);
        }

        return $data;
    }
}
