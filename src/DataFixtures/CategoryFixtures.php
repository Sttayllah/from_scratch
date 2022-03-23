<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
class CategoryFixtures extends Fixture
{
    protected $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger=$slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i=1; $i<10; $i++){
            $category= new Category();
            $category->setName($faker->words(2, true));
            $category->setDescription($faker->paragraph(1,true));
            $category->setSlug(strtolower($this->slugger->slug($category->getName())));
            $manager->persist($category);
        }

        $manager->flush();
    }
}
