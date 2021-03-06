<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\MediaObject;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const PREFIX = 'product-';
    public const NB_ITEMS = 100;

    public function load(ObjectManager $manager): void
    {
        /** @var Category $category_clothes */
        $category_clothes = $this->getReference(CategoryFixtures::PREFIX . CategoryFixtures::CLOTHES);
        /** @var Category $category_art */
        $category_art = $this->getReference(CategoryFixtures::PREFIX . CategoryFixtures::ART);

        $hummingbird_shirt = new Product();
        $hummingbird_shirt->setName('Hummingbird printed t-shirt');
        $hummingbird_shirt->setDescription('Regular fit, round neckline, short sleeves. Made of extra long staple pima cotton.');
        $hummingbird_shirt->setPrice(22.94);
        $hummingbird_shirt->setQuantity(10);
        $hummingbird_shirt->setCategory($category_clothes);

        $hummingbird_shirt_image = new MediaObject();
        $hummingbird_shirt_image->filePath = 'hummingbird-printed-t-shirt.jpg';
        $hummingbird_shirt->setImage($hummingbird_shirt_image);

        $manager->persist($hummingbird_shirt);
        $this->addReference(self::PREFIX . '1', $hummingbird_shirt);

        $best_is_yes_to_come_poster = new Product();
        $best_is_yes_to_come_poster->setName('The best is yet to come Framed poster');
        $best_is_yes_to_come_poster->setDescription('Printed on rigid matt paper and smooth surface.');
        $best_is_yes_to_come_poster->setPrice(34.80);
        $best_is_yes_to_come_poster->setQuantity(0);
        $best_is_yes_to_come_poster->setCategory($category_art);

        $best_is_yes_to_come_poster_image = new MediaObject();
        $best_is_yes_to_come_poster_image->filePath = 'the-best-is-yet-to-come-framed-poster.jpg';
        $best_is_yes_to_come_poster->setImage($best_is_yes_to_come_poster_image);

        $manager->persist($best_is_yes_to_come_poster);
        $this->addReference(self::PREFIX . '2', $best_is_yes_to_come_poster);

        $adventure_begins_poster = new Product();
        $adventure_begins_poster->setName('The adventure begins Framed poster');
        $adventure_begins_poster->setDescription('Printed on rigid matt finish and smooth surface.');
        $adventure_begins_poster->setPrice(34.80);
        $adventure_begins_poster->setQuantity(1);
        $adventure_begins_poster->setCategory($category_art);

        $adventure_begins_poster_image = new MediaObject();
        $adventure_begins_poster_image->filePath = 'the-adventure-begins-framed-poster.jpg';
        $adventure_begins_poster->setImage($adventure_begins_poster_image);

        $manager->persist($adventure_begins_poster);
        $this->addReference(self::PREFIX . '3', $adventure_begins_poster);

        $today_is_a_good_day_mug = new Product();
        $today_is_a_good_day_mug->setName('Mug Today is a good day');
        $today_is_a_good_day_mug->setDescription('White Ceramic Mug. 325ml');
        $today_is_a_good_day_mug->setPrice(14.28);
        $today_is_a_good_day_mug->setQuantity(2);
        $today_is_a_good_day_mug->setCategory($category_art);

        $today_is_a_good_day_mug_image = new MediaObject();
        $today_is_a_good_day_mug_image->filePath = 'mug-today-is-a-good-day.jpg';
        $today_is_a_good_day_mug->setImage($today_is_a_good_day_mug_image);

        $manager->persist($today_is_a_good_day_mug);
        $this->addReference(self::PREFIX . '4', $today_is_a_good_day_mug);

        $faker = Factory::create('fr_FR');
        for ($i = 5; $i <= self::NB_ITEMS; $i++) {
            $faker->seed($i);
            $product = new Product();
            $product->setName($faker->sentence(3, true));
            $product->setCategory($this->getReference(CategoryFixtures::PREFIX . array_rand(array_flip([
                CategoryFixtures::ACCESSORIES,
                CategoryFixtures::ART,
                CategoryFixtures::CLOTHES,
            ]))));
            $product->setPrice($faker->randomFloat(2, 1, 100));
            $product->setDescription($faker->sentences(3, true));
            $product->setQuantity($faker->numberBetween(0, 20));
            $manager->persist($product);
            $this->addReference(self::PREFIX . $i, $product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
