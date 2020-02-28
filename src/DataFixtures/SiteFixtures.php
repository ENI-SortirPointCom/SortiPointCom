<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SiteFixtures extends Fixture
{
    
    const REF_PREFIX = 'site';

    const REF_RENNES = 'REN';
    const REF_NANTES = 'NAN';
    const REF_BREST = 'BRE';
    const REF_NIORT = 'NIO';

    public function load(ObjectManager $manager)
    {

        $entities = [
            $this->make(self::REF_RENNES, 'Rennes'),
            $this->make(self::REF_NANTES, 'Nantes'),
            $this->make(self::REF_BREST, 'Brest'),
            $this->make(self::REF_NIORT, 'Niort')
        ];

        array_walk($entities, function ($e) use ($manager) { $manager->persist($e); });

        $manager->flush();
    }
    private function make(string $ref, string $nom): Site
    {
        $entity = new Site();

        $entity->setNom($nom);

        $this->addReference(self::REF_PREFIX.'_'.$ref, $entity);
        
        return $entity;
    }
}
