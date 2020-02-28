<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    const REF_PREFIX_ORG = 'organise';
    const REF_PREFIX = 'user';
    const REF_TRISTAN = 'TRISTAN';
    const REF_ARNAUD = 'ARNAUD';

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'thenewpassword'));
        $entities = [
            $this->make('Evano', 'TRISTAN', 'Tristan@eni.fr', '$argon2id$v=19$m=65536,t=4,p=1$eWQ3NmxZNGhob05tWFZuUw$zWbcydwtG3oo8hzxvQ/ILCDWihPe1sd1mRkdMTHLPcU', SiteFixtures::REF_RENNES)
                ->setRoles(['ROLE_ADMIN']),
            $this->make('Coste', 'ARNAUD', 'arnaud@eni.fr', '$argon2id$v=19$m=65536,t=4,p=1$eWQ3NmxZNGhob05tWFZuUw$zWbcydwtG3oo8hzxvQ/ILCDWihPe1sd1mRkdMTHLPcU', SiteFixtures::REF_RENNES)
                ->setRoles(['ROLE_ADMIN']),
            $this->make('Xavier', 'Charles', 'charles.xanier@eni.fr', '$argon2id$v=19$m=65536,t=4,p=1$UzJVdjlhWnQucVZTUjMyZA$fH4yn5bGnvxgL0Th3NJC8OCcKUjbp0sTvG24Q78M1ds', SiteFixtures::REF_NIORT)
                ->setRoles(['ROLE_USER']),
        ];

        array_walk($entities, function ($e) use ($manager) {
            $manager->persist($e);
        });

        $manager->flush();
    }

    private function make(string $nom, string $prenom, string $mail, string $password, string $siteRef): User
    {
        $entity = new User();

        $entity->setNom($nom);
        $entity->setPrenom($prenom);
        $entity->setPassword($password);
        $entity->setEmail($mail);
        $entity->setActif(true);

        $entity->setSite($this->getReference(SiteFixtures::REF_PREFIX . '_' . $siteRef));

        $this->addReference('user_' . $prenom, $entity);

//        $this->getReference('ville_35000');

        return $entity;
    }


    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [SiteFixtures::class];

    }
}