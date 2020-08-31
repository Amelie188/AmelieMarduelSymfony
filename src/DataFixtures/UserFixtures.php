<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('amelie@journal.com');
        $user->setRoles(['ROLE_USER']);

        $password = $this->encoder->encodePassword($user, 'azerty1234');
        $user->setPassword($password);
    
        $manager->persist($user);
        $manager->flush();




        $user = new User();
        $user->setEmail('stephanie@journal.com');
        $user->setRoles(['ROLE_USER']);

        $password = $this->encoder->encodePassword($user, 'azerty5678');
        $user->setPassword($password);
    
        $manager->persist($user);
        $manager->flush();
        
    }
}

?>