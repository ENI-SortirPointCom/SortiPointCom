<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Utilisateur;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->remplirSite();
        $this->remplirEtat();
        $this->remplirVille();
        $this->remplirUtilisateur();
        $this->remplirLieu();


    }

    public function remplirVille(ObjectManager $manager)
    {
        $ville = new Ville();
        $ville->setNom('Rennes');
        $ville->setCodePostal('35000');

        $ville1 = new Ville();
        $ville1->setNom('Nantes');
        $ville1->setCodePostal('44000');

        $ville2 = new Ville();
        $ville2->setNom('Brest');
        $ville2->setCodePostal('29000');

        $ville3 = new Ville();
        $ville3->setNom('Niort');
        $ville3->setCodePostal('79000');

        $manager->persist($ville);
        $manager->persist($ville1);
        $manager->persist($ville2);
        $manager->persist($ville3);
        $manager->flush();
    }

    public function remplirSite(ObjectManager $manager)
    {
        $site = new Site();
        $site->setNom('Rennes');

        $site1 = new Site();
        $site1->setNom('Nantes');

        $site2 = new Site();
        $site2->setNom('Brest');

        $manager->persist($site);
        $manager->persist($site1);
        $manager->persist($site2);

        $manager->flush();

    }

    public function remplirUtilisateur(ObjectManager $manager)
    {
        $user = new User();
        $user->setNom('Evano');
        $user->setPrenom('Tristan');
        $user->setMail('Tristan@eni.fr');
        $user->setAdministrateur('true');
        $user->setActif('true');
        $user->setSite(1);
        $manager->persist($user);

        $user1 = new User();
        $user1->setNom('Coste');
        $user1->setPrenom('Arnaud');
        $user1->setMail('Arnaud@eni.fr');
        $user1->setAdministrateur('true');
        $user1->setActif('true');
        $user1->setSite(2);
        $manager->persist($user1);

        $manager->flush();
    }

    public function remplirEtat(ObjectManager $manager)
    {
        $etat = new Etat();
        $etat->setLibelle('Crée');

        $etat1 = new Etat();
        $etat1->setLibelle('Ouverte');

        $etat2 = new Etat();
        $etat2->setLibelle('Clôturée,');

        $etat3 = new Etat();
        $etat3->setLibelle('Activité en cours');

        $etat4 = new Etat();
        $etat4->setLibelle('passée,');

        $etat5 = new Etat();
        $etat5->setLibelle('Annulée,');

        $manager->persist($etat);
        $manager->persist($etat1);
        $manager->persist($etat2);
        $manager->persist($etat3);
        $manager->persist($etat4);
        $manager->persist($etat5);

        $manager->flush();

    }

    public function remplirLieu(ObjectManager $manager)
    {
        $lieu = new Lieu();
        $lieu->setNom('lieu1');
        $lieu->setRue('rue rue');
        $lieu->setLattitude('51° 28\' 38" N');
        $lieu->setLongitude(' 76,60°');
        $lieu->setVille(1);
        $manager->persist($lieu);

        $lieu1 = new Lieu();
        $lieu1->setNom('lieu2');
        $lieu1->setRue('rue rue rue');
        $lieu1->setLattitude('46° 38\' 38" N');
        $lieu1->setLongitude(' 98,60°');
        $lieu1->setVille(2);
        $manager->persist($lieu1);

        $manager->flush();

    }

    public function remplirSortie(ObjectManager $manager)
    {
        $sortie = new Sortie();
        $sortie->setDateHeureDebut('2020-02-18 14:33:43');
        $sortie->setHeureFin('2020-02-18 17:33:43');
        $sortie->setDateLimitInscription('2020-03-18 17:33:43');
        $sortie->setNbInscriptionMax(10);
        $sortie->setInfosSortie('pas d\'info');
        $sortie->setEtat(2);
        $sortie->setOrganisateur(1);
    }
}
