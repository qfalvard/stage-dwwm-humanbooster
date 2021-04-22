<?php

namespace App\DataFixtures;

use App\Entity\Commune;
use App\Entity\Adresse;
use App\Entity\CodePostal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AdresseFixtures extends Fixture
{



    public function load(ObjectManager $manager)
    {

        $commune = new Commune();
        $commune->setNom('Lyon');
        $commune->addCodePostaux($codePostal = new CodePostal, [
            $codePostal->setCodePostal('69007'),
            $manager->persist($codePostal)
        ]);
        $commune->addAdress($adresse = new Adresse, [
            $adresse->setLigne1('Now Coworking Lyon'),
            $adresse->setLigne2('35 rue de Marseille'),
            $adresse->setLigne3('Lyon'),
            $adresse->setCp('69007'),
            $manager->persist($adresse)
        ]);
        $manager->persist($commune);


        $commune = new Commune();
        $commune->setNom('Clermont-Ferrand');
        $commune->addCodePostaux($codePostal = new CodePostal, [
            $codePostal->setCodePostal('63000'),
            $manager->persist($codePostal)
        ]);
        $commune->addAdress($adresse = new Adresse, [
            $adresse->setLigne1('Montgolfier'),
            $adresse->setLigne2('15 avenue des Frères '),
            $adresse->setLigne3('Aubière'),
            $adresse->setCp('63170'),
            $manager->persist($adresse)
        ]);
        $manager->persist($commune);

        $commune = new Commune();
        $commune->setNom('Montpellier');
        $commune->addCodePostaux($codePostal = new CodePostal, [
            $codePostal->setCodePostal('34170'),
            $manager->persist($codePostal)
        ]);
        $commune->addAdress($adresse = new Adresse, [
            $adresse->setLigne1('Immeuble Wonderful'),
            $adresse->setLigne2('50 rue Didier Daurat '),
            $adresse->setLigne3('Castelnau-le-Lez'),
            $adresse->setCp('34170'),
            $manager->persist($adresse)
        ]);
        $manager->persist($commune);

        $manager->flush();
    }

}
