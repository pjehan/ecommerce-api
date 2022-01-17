<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public const PREFIX = 'city-';

    public function load(ObjectManager $manager): void
    {
        $row = 0;
        if (($handle = fopen(__DIR__ . '/Resources/villes_france.csv', 'rb')) !== false) {
            while (($data = fgetcsv($handle, 1000)) !== false) {
                $city = new City();
                $city->setName($data[5]);
                $city->setZipCode((int)$data[10]);
                $city->setPopulation1999($data[14]);
                $city->setPopulation2010($data[15]);
                $city->setPopulation2012($data[16]);
                $manager->persist($city);
                $this->addReference(self::PREFIX . $row, $city);
                if ($row % 1000 === 0) {
                    $manager->flush();
                }
                $row++;
            }
            fclose($handle);
        }

        $manager->flush();
    }
}
