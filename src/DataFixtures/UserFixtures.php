<?php

namespace App\DataFixtures;

use App\Entity\CategoryEchange;
use App\Entity\User;
use App\Entity\Echange;
use App\Entity\Fiche;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $category = new CategoryEchange;
        $category->setName('Fixtures');
        $manager->persist($category);

        for($i = 1; $i <= 10; $i++){
            $user = new User();
            $user->setUsername($faker->firstNameMale())
                ->setPassword($this->encoder->encodePassword($user, 'totototo'))
                ->setEmail($faker->email())
                ->setRoles('ROLE_USER')
                ->setTelephone($faker->phoneNumber());
                
            $manager->persist($user);
            

            for($j = 1; $j <= 10; $j++){
                $echange = new Echange();
                $echange->setTitle($faker->word())
                        ->setDescription($faker->sentence())
                        ->setCreatedAt(new \DateTime)
                        ->setPlace($faker->city())
                        ->setCategory($category)
                        ->setAuthor($user);

                $manager->persist($echange);
            }
        }

        $manager->flush();
    }
}
