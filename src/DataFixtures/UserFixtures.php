<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Gender;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const PREFIX = 'user-';
    public const NB_ITEMS = 100;

    public function __construct(private UserPasswordHasherInterface $hasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();
        for ($i = 1; $i <= self::NB_ITEMS; $i++) {
            $faker->seed($i);
            $user = new User();
            $male = $faker->boolean();
            $gender = GenderFixtures::PREFIX . ($male ? GenderFixtures::MALE : GenderFixtures::FEMALE);
            $user->setGender($this->getReference($gender, Gender::class));
            $user->setFirstName($male ? $faker->firstNameMale() : $faker->firstNameFemale());
            $user->setLastName($faker->lastName());
            $user->setEmail(preg_replace('/([\w.]+)@(\w+)/', $slugify->slugify($user->getFirstName()) . '.' . $slugify->slugify($user->getLastName()) . '@$2', $faker->email()));
            // $user->setPassword($this->hasher->hashPassword($user, $faker->password));
            $user->setPassword($faker->password());
            $user->setBirthDate($faker->dateTimeBetween('-90 years', '-10 years'));
            if ($faker->boolean()) {
                $user->setAddress($faker->streetAddress());
                // Loop to help big cities have more population
                do {
                    /** @var City $city */
                    $city = $this->getReference(CityFixtures::PREFIX . $faker->numberBetween(0, 36700), City::class);
                } while($city->getPopulation2012() < $faker->numberBetween(0, 1000));
                $user->setCity($city);
            }
            $manager->persist($user);
            $this->addReference(self::PREFIX . $i, $user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [GenderFixtures::class, CityFixtures::class];
    }
}
