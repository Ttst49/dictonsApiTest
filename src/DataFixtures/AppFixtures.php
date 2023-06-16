<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Dicton;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Query\Expr\Math;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $startDate = "-5 years";
        $endDate = "now";
        $faker = Faker\Factory::create();



        for ($i = 0;$i<=6;$i++){
            $author = new Author();
            $author->setName($faker->name());
            $manager->persist($author);
            for ($j = 0;$j<=rand(10,500);$j++){
                $dicton = new Dicton();
                $dicton->setAuthor($author);
                $dicton->setContent($faker->realText(100));
                $dicton->setCreatedAt($faker->dateTimeBetween("-5 years","now",null));
                $manager->persist($dicton);
            }

        }

        $manager->flush();
    }
}
