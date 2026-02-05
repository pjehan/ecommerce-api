<?php

namespace App\DataFixtures;

use App\Entity\Basket;
use App\Entity\PaymentMethod;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BasketFixtures extends Fixture implements DependentFixtureInterface
{
    public const PREFIX = 'basket-';
    public const NB_ITEMS = 1000;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= self::NB_ITEMS; $i++) {
            $faker->seed($i);
            $basket = new Basket();
            $basket->setReference($faker->isbn10());
            $basket->setUser($this->getReference(UserFixtures::PREFIX . $faker->numberBetween(1, UserFixtures::NB_ITEMS), User::class));
            $basket->setPaymentMethod($this->getReference(PaymentMethodFixtures::PREFIX . array_rand(array_flip([
                PaymentMethodFixtures::CREDIT_CARD,
                PaymentMethodFixtures::CHECK,
                PaymentMethodFixtures::PAYPAL,
            ])), PaymentMethod::class));
            $basket->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $manager->persist($basket);
            $this->addReference(self::PREFIX . $i, $basket);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, PaymentMethodFixtures::class];
    }
}
