<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Category;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface

{
           
            protected $slugger;
            public function __construct(SluggerInterface $slugger)
            {
                $this->slugger=$slugger;
            }

        public function load(ObjectManager $manager): void
        {
            $faker = Factory::create('fr_FR');
            $categories = $manager->getRepository(Category::class)->findAll();
            $users = $manager->getRepository(User::class)->findAll();
         
         
                
                    for ($i = 1; $i <= 30; $i++){   
                  
                  
                    $post= new Post();
                    
                    $post->setName($faker->words(5, true));
                    $post->setContent($faker->paragraphs(3,true));
                    $post->setSlug(strtolower($this->slugger->slug($post->getName())));
                    $post->setCreatedAt(new \DateTimeImmutable());
                    $post->addCategory($faker->randomElement($categories));
                    $post->setUser($faker->randomElement($users));
                    $manager->persist($post);

                    }
                  
                    
                
                  
                
               $manager->flush();
        }

        public function getDependencies(): array
        {
            return [CategoryFixtures::class];
            return [UserFixtures::class];
        }
}
