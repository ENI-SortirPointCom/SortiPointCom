<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture implements DependentFixtureInterface
{

    const REF_PREFIX = 'sortie';
    const REF_SORTIE1 = 'SORTIE1';
    const REF_SORTIE2 = 'SORTIE2';

    public function load(ObjectManager $manager)
    {
        $format = 'Y-m-d H:i:s';

        $user = new Sortie();
        $entities = [
            $this->make('SORTIE1', DateTime::createFromFormat($format, '2020-02-18 14:33:44'), DateTime::createFromFormat($format, '2020-02-18 17:33:43'), DateTime::createFromFormat($format, '2020-02-20 17:33:43'), UserFixtures::REF_TRISTAN, 10, 'pas d\'infos', LieuFixtures::REF_PARC, EtatFixtures::REF_OUVERT),
            $this->make('SORTIE2', DateTime::createFromFormat($format, '2020-02-22 14:33:43'), DateTime::createFromFormat($format, '2020-02-22 17:33:43'), DateTime::createFromFormat($format, '2020-03-25 17:33:43'), UserFixtures::REF_ARNAUD, 10, 'pas d\'infos', LieuFixtures::REF_MER, EtatFixtures::REF_OUVERT)

        ];

        array_walk($entities, function ($e) use ($manager) {
            $manager->persist($e);
        });

        $manager->flush();
    }

    private function make(string $nom, DateTime $HeureDebut, DateTime $HeureFin, DateTime $DateLimiteInscription, string $organisateur, int $nbInscriptionMax, string $InfoSortie, string $lieu, string $etat): Sortie
    {
        $entity = new Sortie();

        $entity->setNom($nom);
        $entity->setDateHeureDebut($HeureDebut);
        $entity->setHeureFin($HeureFin);
        $entity->setNbInscriptionMax($nbInscriptionMax);
        $entity->setDateLimitInscription($DateLimiteInscription);
        $entity->setOrganisateur($this->getReference(UserFixtures::REF_PREFIX . '_' . $organisateur));
        $entity->setInfosSortie($InfoSortie);
        $entity->setLieu($this->getReference(LieuFixtures::REF_PREFIX . '_' . $lieu));
        $entity->setEtat($this->getReference(EtatFixtures::REF_PREFIX . '_' . $etat));

        $this->addReference('Sortie_' . $nom, $entity);

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [LieuFixtures::class, EtatFixtures::class, SiteFixtures::class, UserFixtures::class, MotifAnnulationFixtures::class];

    }
}
