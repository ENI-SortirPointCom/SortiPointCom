<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $entities = [
            $this->make('Rennes', 35000),
            $this->make('Nantes', 44000),
            $this->make('Brest', 29000),
            $this->make('Niort', 79000)
        ];

        array_walk($entities, function ($e) use ($manager) { $manager->persist($e); });

        $manager->flush();
    }

    private function make(string $nom, string $codePostal): Ville
    {
        $entity = new Ville();

        $entity->setNom($nom);
        $entity->setCodePostal($codePostal);

        $this->addReference('ville_'.$codePostal, $entity);

        $this->getReference('ville_35000');

        return $entity;
    }
}
