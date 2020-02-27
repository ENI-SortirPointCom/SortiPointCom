<?php

namespace App\Command;

use App\Entity\Etat;
use App\Entity\Sortie;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateDatabaseCommand extends Command
{
    protected static $defaultName = 'updateDatabase';

    /**
     * UpdateDatabaseCommand constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Met le champ etat a jour');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $dateDuJour = new datetime(date("Y-m-d H:i:s"));
        $io = new SymfonyStyle($input, $output);
        $listeSortie = $this->em->getRepository(Sortie::class)->findAll();
        $output->writeln([
            'Mise a jour de la table etat en fonction de la date du jour',
            '***********************************************************',
        ]);

        /**
         * pour toutes les sorties si le status est :
         *  si la date de fin est inferieur a la date du jour
         *  - OUVERT ou CLOTURE => PASSE
         *  - ANNULE => CLOTURE
         *  si datedebut superieur a date du jour et datelimite < datejour et n'est pas ANNULE
         *  - CLOTURE
         * si datedebut < date du jour et date de fin > date du jour et n'est pas ANNULE
         *  - EN COURS
         */
        foreach ($listeSortie as $sortie) {
            $output->writeln('A ce jour : '.$dateDuJour->format('d-m-Y'). ' la sortie : '.$sortie . ' a le status : '.$sortie->getEtat()->getLibelle());
            if ($sortie->getHeureFin() < $dateDuJour) {
                if (($sortie->getEtat()->getLibelle() == 'OUVERT') || ($sortie->getEtat()->getLibelle() == 'CLOTURE')) {
                    $sortie->setEtat($this->em->getRepository('App:Etat')->find(4));
                    $output->writeln('changement du status de : '.$sortie.' vers : '.$this->em->getRepository('App:Etat')->find(4));
                }
            }
            if (($sortie->getDateHeureDebut() > $dateDuJour) && ($sortie->getDateLimitInscription() < $dateDuJour) && ($sortie->getEtat()->getLibelle() != 'ANNULE')) {
                $sortie->setEtat($this->em->getRepository('App:Etat')->find(2));
                $output->writeln('changement du status de : '.$sortie.' vers : '.$this->em->getRepository('App:Etat')->find(2));
            }
            if (($sortie->getDateHeureDebut() < $dateDuJour) && ($sortie->getHeureFin() > $dateDuJour) && ($sortie->getEtat()->getLibelle() != 'ANNULE')) {
                $sortie->setEtat($this->em->getRepository('App:Etat')->find(3));
                $output->writeln('changement du status de : '.$sortie.' vers : '.$this->em->getRepository('App:Etat')->find(3));
            }
        }
        $this->em->persist($sortie);
        $this->em->flush();
        return 0;
    }
}
