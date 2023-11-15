<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$email,$pseudo,$plainPassword,$pays, $annee, $role]) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPseudo($pseudo);
            $user->setPassword($password);
            $user->setAnnee($annee);
            $user->setPays($pays);

            $roles = array();
            $roles[] = $role;
            $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();
    }
    private function getUserData()
    {
        yield [
            'chris@localhost',
            'Chris',
            'chris',
            'France',
            2023,
            'ROLE_USER'
        ];
        yield [
            'anna@localhost',
            'Anna',
            'anna',
            'France',
            2023,
            'ROLE_ADMIN','ROLE_USER'
        ];
        yield [
            'manuia@localhost',
            'Manuia',
            '2002',
            'Tahiti',
            2021,
            'ROLE_ADMIN','ROLE_USER'
        ];
        yield [
            'esteban@localhost',
            'Esteban',
            'Spakex89',
            'France',
            2022,
            'ROLE_USER'
        ];
    }


}