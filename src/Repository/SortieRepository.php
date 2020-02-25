<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findBySearch(User $user, Search $search)
    {
        $sorties = $this->getEntityManager()->getRepository(Sortie::class)->findAll();
        /**
         * si la chaine du champs search fait partie du nom de la sortie
         */
        $req = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.nom LIKE :nom')->setParameter('nom', "%" . $search->getNomSearch() . "%");
        /**
         * si l'utilisateur est l'organisateur
         */
        if (!is_null($search->getOrganisateur()) && $search->getOrganisateur()) {
            $req->andwhere('IDENTITY(s.organisateur) LIKE :organisateur')->setParameter('organisateur', $search->getOrganisateur());
        }

        /**
         * En fonction du site
         */
        if (!is_null($search->getSiteSortie())) {
            $req->andWhere('IDENTITY(s.site) LIKE :siteSortie')->setParameter('siteSortie', $search->getSiteSortie());
        }

//            ->andWhere('s.dateHeureDebut LIKE :dateDebut')->setParameter('dateDebut', $search->getDateDebut())
//            ->andWhere('s.dateLimitInscription LIKE :dateFin')->setParameter('dateFin', $search->getDateFin())

        /**
         * sorties auxquelles je suis inscrit ou non
         */

        if (!is_null($search->getEtatInscrit()) && $search->getEtatInscrit()) {
            $req->innerJoin('s.participant','p', 'WITH', 'p.id = :userId')->setParameter('userId', $user->getId());
        }

        return $req->getQuery()->getResult();

        // /**
        //  * @return Sortie[] Returns an array of Sortie objects
        //  */
        /*
        public function findByExampleField($value)
        {
            return $this->createQueryBuilder('s')
                ->andWhere('s.exampleField = :val')
                ->setParameter('val', $value)
                ->orderBy('s.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }
        */

        /*
        public function findOneBySomeField($value): ?Sortie
        {
            return $this->createQueryBuilder('s')
                ->andWhere('s.exampleField = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
        */
    }
}
