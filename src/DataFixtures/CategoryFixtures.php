<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public const PREFIX = 'category-';
    public const CLOTHES = 'clothes';
    public const ACCESSORIES = 'accessories';
    public const ART = 'art';

    public function load(ObjectManager $manager): void
    {
        $categories = [
            self::CLOTHES => 'Clothes',
            self::ACCESSORIES => 'Accessories',
            self::ART => 'Art'
        ];

        foreach ($categories as $key => $c) {
            $category = new Category();
            $category->setName($c);
            $manager->persist($category);
            $this->addReference(self::PREFIX . $key, $category);
        }

        $manager->flush();
    }
}
