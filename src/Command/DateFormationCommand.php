<?php

namespace App\Command;

use App\Repository\SessionRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DateFormationCommand extends Command
{
    private $container;

    public function __construct(ContainerInterface $container, SessionRepository $sessionRepository)
    {
        $this->repository = $sessionRepository;
        parent::__construct();
        $this->container = $container;
    }
    // the name of the command (the part after "bin/console")
    public static $defaultName = 'app:dateFormation';

    public function configure()
    {
        // ...
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // On prend la date d'aujourd'hui
        $dateNow = new \DateTime('now');
        // On cherche toute les sessions. Elles s'inscrivent dans un tableau $sessions
        $sessions = $this->repository->findAll();

        //Pour chaque session dans le tableau $sessions
        foreach ($sessions as $session) {
            // On récupère la date de fin de la session
            $dateFin = $session->getDateFin();

            $dateDebut = $session->getDateDebut();

            // On définit sa date d'expiration (la date de fin plus 4 mois)
            $dateExpire = $dateFin->add(new DateInterval('P4M'));

            // SI la date d'aujourd'hui ($dateNow) est supérieur ou égale à la date de début de la session
            // ET que la date d'aujourd'hui est inférieur à la date d'expiration
            if ($dateNow >= $dateDebut && $dateNow < $dateExpire) {

                // Alors on passe son statut sur actif dans la base de donnée
                $session->setIsActif(true);
                $entityManager = $this->container->get('doctrine')->getManager();
                $entityManager->persist($session);
                $entityManager->flush();

                //et on affiche dans la commande serveur le message de controle pour les tests
                $output->writeln("Date(s) vérifiée(s)");
            }

            // SI la date d'aujourd'hui ($dateNow) est supérieur ou égale à la date d'expiration de la session
            if ($dateNow >= $dateExpire) {
                // dump($dateNow, $dateExpire);

                // Alors on passe son statut sur inactif dans la base de donnée
                $session->setIsActif(false);
                $entityManager = $this->container->get('doctrine')->getManager();
                $entityManager->persist($session);
                $entityManager->flush();

                //et on affiche dans la commande serveur le message de controle pour les tests
                $output->writeln("Date(s) d'expiration vérifiée(s)");
            }
        }
    }
}