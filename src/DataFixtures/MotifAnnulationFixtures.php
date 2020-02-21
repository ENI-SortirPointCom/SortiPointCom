<?php

namespace App\DataFixtures;

use App\Entity\MotifAnnulation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MotifAnnulationFixtures extends Fixture
{

    const REF_PREFIX = 'motif';

    const REF_METEO = 'fait pas beau';
    const REF_MALADE = 'J\'ai la grippe';
    const REF_PONEY = 'J\'ai poney';
    public function load(ObjectManager $manager)
    {
        $user = new MotifAnnulation();
        $entities = [
            $this->make(self::REF_METEO),
            $this->make(self::REF_MALADE),
            $this->make(self::REF_PONEY)
        ];

        array_walk($entities, function ($e) use ($manager) {
            $manager->persist($e);
        });

        $manager->flush();
    }
    private function make(string $libelle): MotifAnnulation
    {
        $entity = new MotifAnnulation();

        $entity->setLibelle($libelle);

        $this->addReference(self::REF_PREFIX.'_'.$libelle, $entity);

        return $entity;
    }
}
