<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use EasySlugger\Slugger;

class UtilisateursFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;

    }

    public function load(ObjectManager $manager)
    {

        $toto = new Utilisateur();
        $toto->setPrenom('Toto');
        $toto->setNom('Velo');
        $toto->setRoles(['ROLE_ENCADRANT']);
        $toto->setEmail('totofaitduvelo@yopmail.com');
        $toto->setIsActif(true);
        $toto->setPassword(
            $this->encoder->encodePassword(
                $toto,
                'Stagehb2020'
            )
        );
        $manager->persist($toto);

        $encadrantFixe = new Utilisateur();
        $encadrantFixe->setPrenom('Encadrant');
        $encadrantFixe->setNom('HB');
        $encadrantFixe->setRoles(['ROLE_ENCADRANT']);
        $encadrantFixe->setEmail('encadrant@humanbooster.com');
        $encadrantFixe->setIsActif(true);
        $encadrantFixe->setPassword(
            $this->encoder->encodePassword(
                $encadrantFixe,
                'Stagehb2020'
            )
        );
        $manager->persist($encadrantFixe);

        $formateurFixe = new Utilisateur();
        $formateurFixe->setPrenom('Formateur');
        $formateurFixe->setNom('HB');
        $formateurFixe->setRoles(['ROLE_FORMATEUR']);
        $formateurFixe->setEmail('formateur@humanbooster.com');
        $formateurFixe->setIsActif(true);
        $formateurFixe->setPassword(
            $this->encoder->encodePassword(
                $formateurFixe,
                'Stagehb2020'
            )
        );
        $manager->persist($formateurFixe);

        $formateurTREFixe = new Utilisateur();
        $formateurTREFixe->setPrenom('FormateurTRE');
        $formateurTREFixe->setNom('HB');
        $formateurTREFixe->setRoles(['ROLE_FORMATEUR_TRE', 'ROLE_FORMATEUR']);
        $formateurTREFixe->setEmail('formateurTRE@humanbooster.com');
        $formateurTREFixe->setIsActif(true);
        $formateurTREFixe->setPassword(
            $this->encoder->encodePassword(
                $formateurTREFixe,
                'Stagehb2020'
            )
        );
        $manager->persist($formateurTREFixe);

        $stagiaireFixe = new Utilisateur();
        $stagiaireFixe->setPrenom('Stagiaire');
        $stagiaireFixe->setNom('HB');
        $stagiaireFixe->setRoles(['ROLE_STAGIAIRE']);
        $stagiaireFixe->setEmail('stagiaire@humanbooster.com');
        $stagiaireFixe->setIsActif(true);
        $stagiaireFixe->setPassword(
            $this->encoder->encodePassword(
                $stagiaireFixe,
                'Stagehb2020'
            )
        );
        $manager->persist($stagiaireFixe);

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++ ){
            $firstname = str_replace(' ', '', $faker->firstname);
            $lastname = str_replace(' ', '', $faker->lastName);
            $encadrant = new Utilisateur();
            $encadrant->setPrenom($firstname);
            $encadrant->setNom($lastname);
            $encadrant->setRoles(['ROLE_ENCADRANT']);
            $encadrant->setEmail(Slugger::slugify($firstname) . '.' . Slugger::slugify($lastname) . '@' . $faker->safeEmailDomain);
            $encadrant->setIsActif(true);
            $encadrant->setPassword(
                $this->encoder->encodePassword(
                    $encadrant,
                    'Stagehb2020'
                ));

            $manager->persist($encadrant);
        }

        for ($i = 0; $i < 2; $i++) {
            $firstname = str_replace(' ', '', $faker->firstname);
            $lastname = str_replace(' ', '', $faker->lastName);
            $formateurTre = new Utilisateur();
            $formateurTre->setPrenom($firstname);
            $formateurTre->setNom($lastname);
            $formateurTre->setRoles(['ROLE_FORMATEUR_TRE', 'ROLE_FORMATEUR']);
            $formateurTre->setEmail(Slugger::slugify($firstname) . '.' . Slugger::slugify($lastname) . '@' . $faker->safeEmailDomain);
            $formateurTre->setIsActif(true);
            $formateurTre->setPassword(
                $this->encoder->encodePassword(
                    $formateurTre,
                    'Stagehb2020'
                )
            );


            $manager->persist($formateurTre);
        }

        for ($i = 0; $i < 10; $i++) {
            $firstname = str_replace(' ', '', $faker->firstname);
            $lastname = str_replace(' ', '', $faker->lastName);
            $formateur = new Utilisateur();
            $formateur->setPrenom($firstname);
            $formateur->setNom($lastname);
            $formateur->setRoles(['ROLE_FORMATEUR']);
            $formateur->setEmail(Slugger::slugify($firstname) . '.' . Slugger::slugify($lastname) . '@' . $faker->safeEmailDomain);
            $formateur->setIsActif(true);
            $formateur->setPassword(
                $this->encoder->encodePassword(
                    $formateur,
                    'Stagehb2020'
                )
            );
            $manager->persist($formateur);
        }

        for ($i = 0; $i < 30; $i++) {
            $firstname = str_replace(' ', '', $faker->firstname);
            $lastname = str_replace(' ', '', $faker->lastName);
            $stagiaire = new Utilisateur();
            $stagiaire->setPrenom($firstname);
            $stagiaire->setNom($lastname);
            $stagiaire->setRoles(['ROLE_STAGIAIRE']);
            $stagiaire->setEmail(Slugger::slugify($firstname) . '.' . Slugger::slugify($lastname) . '@' . $faker->safeEmailDomain);
            $stagiaire->setIsActif(true);
            $stagiaire->setPassword(
                $this->encoder->encodePassword(
                    $stagiaire,
                    'Stagehb2020'
                )
            );
            $manager->persist($stagiaire);
        }

        // // EXCEPTIONS POUR LES TESTS

        // // Stagiaire inactif
        // $inactif = new Utilisateur();
        // $inactif->setPrenom('utilisateur');
        // $inactif->setNom('inactif');
        // $inactif->setRoles(['ROLE_STAGIAIRE']);
        // $inactif->setEmail($faker->email);
        // $inactif->setIsActif(false);
        // $inactif->setPassword(
        //     $this->encoder->encodePassword(
        //         $inactif,
        //         'Stagehb2020'
        //     )
        // );
        // $manager->persist($inactif);

        // // Stagiaire token register expiré
        // $tokenexpire = new Utilisateur();
        // $tokenexpire->setPrenom('token');
        // $tokenexpire->setNom('expiré');
        // $tokenexpire->setRoles(['ROLE_STAGIAIRE']);
        // $tokenexpire->setEmail($faker->email);
        // $tokenexpire->setIsActif(false);
        // $tokenexpire->setTokenCreatedAt(date_create('2020-02-01'));
        // $tokenexpire->setConfirmationToken('tokenconfirmationtest');
        // $tokenexpire->setPassword(
        //     $this->encoder->encodePassword(
        //         $tokenexpire,
        //         'Stagehb2020'
        //     )
        // );
        // $manager->persist($tokenexpire);

        // // Stagiaire token oubli de mot de passe
        // $tokenoubli = new Utilisateur();
        // $tokenoubli->setPrenom('token');
        // $tokenoubli->setNom('oubli mot de passe');
        // $tokenoubli->setRoles(['ROLE_STAGIAIRE']);
        // $tokenoubli->setEmail($faker->email);
        // $tokenoubli->setIsActif(true);
        // $tokenoubli->setResetToken('tokenresettest');
        // $tokenoubli->setPassword(
        //     $this->encoder->encodePassword(
        //         $tokenoubli,
        //         'Stagehb2020'
        //     )
        // );
        // $manager->persist($tokenoubli);

        // // Stagiaire token oubli mot de passe et lien de modification inactif
        // $tokenoubli = new Utilisateur();
        // $tokenoubli->setPrenom('token inactif');
        // $tokenoubli->setNom('oubli mot de passe');
        // $tokenoubli->setRoles(['ROLE_STAGIAIRE']);
        // $tokenoubli->setEmail($faker->email);
        // $tokenoubli->setIsActif(true);
        // $tokenoubli->setResetToken('tokenresettest');
        // $tokenoubli->setTokenMailCreatedAt(date_create('2020-02-01'));
        // $tokenoubli->setPassword(
        //     $this->encoder->encodePassword(
        //         $tokenoubli,
        //         'Stagehb2020'
        //     )
        // );
        // $manager->persist($tokenoubli);

        $manager->flush();
    }
}
