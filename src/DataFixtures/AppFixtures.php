<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Dicton;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();


        for ($i = 0;$i<=4;$i++){
            $author = new Author();
            $author->setName($faker->name());
            $manager->persist($author);
            for ($j = 0;$j<=10;$j++){
                $dicton = new Dicton();
                $dicton->setAuthor($author);
                $dicton->setContent($faker->realText(100));
                $manager->persist($dicton);
            }

        }




        $manager->flush();
    }
}
