<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture
{
    const REF_PREFIX = 'etat';

    const REF_CREE = 'CREE';
    const REF_OUVERT= 'OUVERT';
    const REF_CLOTURE = 'CLOTURE';
    const REF_EN_COURS = 'EN COURS';
    const REF_PASSE = "PASSE";
    const REF_ANNULE = 'ANNULE';

    public function load(ObjectManager $manager)
    {
        $user = new Etat();
        $entities = [
            $this->make(self::REF_CREE),
            $this->make(self::REF_OUVERT),
            $this->make(self::REF_CLOTURE),
            $this->make(self::REF_EN_COURS),
            $this->make(self::REF_PASSE),
            $this->make(self::REF_ANNULE)
            ];

        array_walk($entities, function ($e) use ($manager) {
            $manager->persist($e);
        });

        $manager->flush();
    }

    private function make(string $libelle): Etat
    {
        $entity = new Etat();

        $entity->setLibelle($libelle);

        $this->addReference(self::REF_PREFIX.'_'.$libelle, $entity);

//        $this->getReference('ville_35000');

        return $entity;
    }
}
