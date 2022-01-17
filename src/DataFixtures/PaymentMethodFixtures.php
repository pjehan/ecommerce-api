<?php

namespace App\DataFixtures;

use App\Entity\PaymentMethod;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaymentMethodFixtures extends Fixture
{
    public const PREFIX = 'payment-method-';
    public const CREDIT_CARD = 'CREDIT_CARD';
    public const CHECK = 'CHECK';
    public const PAYPAL = 'PAYPAL';

    public function load(ObjectManager $manager): void
    {
        $creditCard = new PaymentMethod();
        $creditCard->setName("Carte bancaire");
        $manager->persist($creditCard);
        $this->addReference(self::PREFIX . self::CREDIT_CARD, $creditCard);

        $check = new PaymentMethod();
        $check->setName("Chèque");
        $manager->persist($check);
        $this->addReference(self::PREFIX . self::CHECK, $check);

        $paypal = new PaymentMethod();
        $paypal->setName("Paypal");
        $manager->persist($paypal);
        $this->addReference(self::PREFIX . self::PAYPAL, $paypal);

        $manager->flush();
    }
}
