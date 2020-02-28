<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use DateInterval;
use DateTime;
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

    public function findByLimitOneMonth()
    {

        $dateDuJour = new datetime(date("Y-m-d H:i:s"));
        $dateLimite = $dateDuJour->modify('-1 month');
        $req = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.heureFin > :dateLimite')->setParameter('dateLimite', $dateLimite);
        return $req->getQuery()->getResult();
    }

    public function findBySearch(User $user, Search $search)
    {

        $dateDuJour = new DateTime('now');
        /**
         * penser a clone car si on 'modify' l'objet datetime ($datedujour) par la suite, même si on ne l'utilise pas il sera quand même modifié
         */
        $dateLimite = clone $dateDuJour;
        $dateLimite->modify('-1 month');
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
            $req->andwhere('IDENTITY(s.organisateur) LIKE :organisateur')->setParameter('organisateur', $user);
        }
        /**
         * En fonction du site
         */
        if (!is_null($search->getSiteSortie())) {
            $req->andWhere('IDENTITY(s.site) LIKE :siteSortie')->setParameter('siteSortie', $search->getSiteSortie());
        }
        /**
         * Entre datedebut et date fin si existe sinon utilise datejour
         */

        if (!is_null($search->getDateDebut()) && (!is_null($search->getDateFin()))) {
            $req->andWhere('s.dateHeureDebut BETWEEN ?1 AND ?2')
                ->setParameter(1, $search->getDateDebut())
                ->setParameter(2, $search->getDateFin());
        }

        if (!is_null($search->getDateDebut()) && (is_null($search->getDateFin()))){
            $req->andWhere('s.dateHeureDebut BETWEEN ?1 AND ?2')
                ->setParameter(1, $search->getDateDebut())
                ->setParameter(2, $dateDuJour);
        }
            /**
             * sorties auxquelles je suis inscrit
             */

            if (!is_null($search->getEtatInscrit()) && $search->getEtatInscrit()) {

                $req->innerJoin('s.participant', 'p', 'WITH', 'p.id = :userId')->setParameter('userId', $user->getId());
            }
        /**
         * sorties auxquelles je ne suis pas inscrit
         */
        if (!is_null($search->getEtatInscrit()) && !$search->getEtatInscrit()) {
            $req->andWhere(':user NOT Member Of s.participant')->setParameter('user', $user->getId());
        }
        /**
         * sorties passees
         */
        if (!is_null($search->getPasse()) && $search->getPasse()) {
            $req->andWhere('s.etat = :etat')->setParameter('etat', $this->getEntityManager()->getRepository(Sortie::class)->find(4));
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
