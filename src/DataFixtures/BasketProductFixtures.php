<?php

namespace App\DataFixtures;

use App\Entity\BasketProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Biased;

class BasketProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const NB_ITEMS = 1000;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= self::NB_ITEMS; $i++) {
            $faker->seed($i);
            $basketProduct = new BasketProduct();
            $basketProduct->setProduct($this->getReference(ProductFixtures::PREFIX . $faker->numberBetween(1, ProductFixtures::NB_ITEMS)));
            $basketProduct->setBasket($this->getReference(BasketFixtures::PREFIX . $faker->numberBetween(1, BasketFixtures::NB_ITEMS)));
            $basketProduct->setPrice($faker->randomFloat(2, 1, 100));
            $basketProduct->setQuantity($faker->numberBetween(1, 10));
            $manager->persist($basketProduct);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProductFixtures::class, BasketFixtures::class];
    }
}