<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    const REF_PREFIX = 'ville';

    const REF_CP_RENNES = '35000';
    const REF_CP_NANTES = '44000';
    const REF_CP_BREST = '29000';
    const REF_CP_NIORT = '79000';

    public function load(ObjectManager $manager)
    {
        $entities = [
            $this->make('Rennes', '35000'),
            $this->make('Nantes','44000'),
            $this->make('Brest', '29000'),
            $this->make('Niort', '79000')
        ];
        array_walk($entities, function ($e) use ($manager) { $manager->persist($e); });

        $manager->flush();
    }

    private function make(string $nom,string $cdpost): Ville
    {
        $entity = new Ville();

        $entity->setNom($nom);
        $entity->setCodePostal($cdpost);

        $this->addReference($nom, $entity);

//        $this->getReference('ville_35000');

        return $entity;
    }
}
