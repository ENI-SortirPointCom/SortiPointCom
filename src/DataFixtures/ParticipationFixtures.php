<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ParticipationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $entities = [
            $this->make(UserFixtures::REF_TRISTAN, SortieFixtures::REF_SORTIE1),
            $this->make(UserFixtures::REF_ARNAUD, SortieFixtures::REF_SORTIE2)
            ];

        array_walk($entities, function ($e) use ($manager) {
            $manager->persist($e);
        });

        $manager->flush();
    }

    private function make( string $user, string $sortie): User
    {
        /** @var User $user */
       $user = $this->getReference(UserFixtures::REF_PREFIX.'_'.$user);
       $user->addSorty($this->getReference('Sortie_'.SortieFixtures::REF_SORTIE1));

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [SortieFixtures::class, UserFixtures::class];

    }
}
