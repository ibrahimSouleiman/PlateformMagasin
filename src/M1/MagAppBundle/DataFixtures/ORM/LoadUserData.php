<?php

namespace M1\MagAppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use M1\MagAppBundle\Entity\Utilisateurs;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Les noms d'utilisateurs à créer
        $listNames = array('ibrahim', 'choukri', 'hamda');

        foreach ($listNames as $name) {
            // On crée l'utilisateur
            $user = new Utilisateurs();

            // Le nom d'utilisateur et le mot de passe sont identiques
            $user->setUsername($name);
            $user->setPassword($name);

            $user->setPrenom('jean');
            $user->setNom($name);

            // On ne se sert pas du sel pour l'instant
            $user->setSalt('');
            // On définit uniquement le role ROLE_USER qui est le role de base
            $user->setRoles(array('ROLE_USER'));

            // On le persiste
            $manager->persist($user);
        }

        // On déclenche l'enregistrement
        $manager->flush();
    }
}