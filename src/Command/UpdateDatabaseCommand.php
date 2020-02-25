<?php

namespace App\Command;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateDatabaseCommand extends Command
{
    protected static $defaultName = 'updateDatabase';

    protected function configure()
    {
        $this
            ->setDescription('Met le champ etat a jour');
    }

    protected function execute(InputInterface $input, OutputInterface $output, EntityManager $em): int
    {
        $dateDuJour = new datetime(date("Y-m-d H:i:s"));
        $io = new SymfonyStyle($input, $output);

        $listeSortie = $em->getRepository(Sortie::class)->findAll();
        foreach ($listeSortie as $sortie) {
            if ($sortie->getHeureFin() < $dateDuJour) {
                if (($sortie->getEtat()->getLibelle() == 'OUVERT') || ($sortie->getEtat()->getLibelle() == 'CLOTURE') || ($sortie->getEtat()->getLibelle() == 'PASSE')) {
                    $sortie->setEtat($em->getRepository('App:Etat')->find(5));
                }
            }
            if (($sortie->getDateHeureDebut() > $dateDuJour) && ($sortie->getDateLimitInscription() < $dateDuJour) && ($sortie->getEtat()->getLibelle() != 'ANNULE')) {
                $sortie->setEtat($em->getRepository('App:Etat')->find(2));
            }
            if (($sortie->getDateHeureDebut() < $dateDuJour) && ($sortie->getHeureFin() > $dateDuJour) && ($sortie->getEtat()->getLibelle() != 'ANNULE')) {
                $sortie->setEtat($em->getRepository('App:Etat')->find(3));
            }
        }


        return 0;
    }
}
