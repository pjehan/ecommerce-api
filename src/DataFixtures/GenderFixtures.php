<?php

namespace App\DataFixtures;

use App\Entity\Gender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenderFixtures extends Fixture
{
    public const PREFIX = 'gender-';
    public const MALE = 'male';
    public const FEMALE = 'female';

    public function load(ObjectManager $manager): void
    {
        $male = new Gender();
        $male->setName("Male");
        $manager->persist($male);
        $this->addReference(self::PREFIX . self::MALE, $male);

        $female = new Gender();
        $female->setName("Female");
        $manager->persist($female);
        $this->addReference(self::PREFIX . self::FEMALE, $female);

        $manager->flush();
    }
}
