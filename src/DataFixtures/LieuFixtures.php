<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LieuFixtures extends Fixture implements DependentFixtureInterface
{
    const REF_PREFIX = 'lieu';
    const REF_PARC = 'PARC';
    const REF_MER= 'MER';

    public function load(ObjectManager $manager)
    {
        $user = new Lieu();
        $entities = [
            $this->make(self::REF_MER,'de la plage',48.037888,1.7006592,VilleFixtures::REF_CP_BREST),
            $this->make(self::REF_PARC,'rue duparc',51.254677,1.2547899,VilleFixtures::REF_CP_NANTES)
        ];

        array_walk($entities, function ($e) use ($manager) {
            $manager->persist($e);
        });

        $manager->flush();
    }
    private function make(string $nom,string $rue,string $lattitude, string $longitude, string $ville): Lieu
    {
        $entity = new Lieu();

        $entity->setNom($nom);
        $entity->setRue($rue);
//        $entity->setVille($this->getReference(VilleFixtures::));
        $entity->setVille($this->getReference('Rennes'));
        $entity->setLattitude($lattitude);
        $entity->setLongitude($longitude);

        $this->addReference('lieu_' . $nom, $entity);

        return $entity;
    }
    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [VilleFixtures::class];
    }
}
