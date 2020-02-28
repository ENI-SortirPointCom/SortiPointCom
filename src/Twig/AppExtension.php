<?php

namespace App\Twig;

use App\Entity\Sortie;
use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    use ContainerAwareTrait;

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('inscrit', [$this, 'isInscrit']),
            new TwigFilter('nbParticipant', [$this, 'nbParticipant']),
            new TwigFilter('nbParticipantTotal', [$this, 'nbParticipantTotal']),
            new TwigFilter('dureeSortie', [$this, 'dureeSortie']),
            new TwigFilter('actions', [$this, 'actions']),
            new TwigFilter('isAdmin', [$this, 'isAdmin']),
            new TwigFilter('truncnom', [$this, 'truncnom'])
        ];
    }

    public function getFunctions(): array
    {
        return [];
    }

    public function truncnom(string $nom)
    {
        return $nom[0] . '.';
    }

    public function actions(Sortie $sortie, User $user)
    {
        $actions = [];
        $datetDuJour = date("d-m-Y H:i:s");
        /**
         * si l'utilisateur est inscrit et que la date limite d'insciption n'est pas dépassé alors
         * afficher
         */

        if ($datetDuJour < $sortie->getDateLimitInscription() && count($sortie->getParticipant()) < $sortie->getNbInscriptionMax()) {
            array_push($actions, "<a href=\"sortie/show/" . $sortie->getId() . "\">Afficher</a>&nbsp;");
        }
        /**
         * si le user est l'organisateur alors peut modifier
         */
        if (($sortie->getOrganisateur() == $user) && ($sortie->getEtat()->getLibelle() != 'PASSE')) {
            array_push($actions, "<a href=\"sortie/edit/" . $sortie->getId() . "\">Modifier</a>&nbsp;");
        }
        /**
         * si le user est inscrit alors peut se desister
         */

        if (($sortie->getParticipant()->contains($user)) && ($sortie->getEtat()->getLibelle() != 'PASSE')) {
            array_push($actions, "<a href=\"accueil/register/" . $sortie->getId() . "\">Se désister</a>&nbsp;");
        } elseif ($sortie->getEtat()->getLibelle() == 'PASSE' || ($sortie->getEtat()->getLibelle() == 'ANNULE')  || ($sortie->getParticipant()->count())+1 > $sortie->getNbInscriptionMax() ) {
            array_push($actions, "ND");
        } else {
            array_push($actions, "<a href=\"accueil/register/" . $sortie->getId() . "\">S'inscrire</a>&nbsp;");
        }

        /**
         * si le user est l'organisateur et que l'etat est 'en creation' alors peut publier
         */
        if ($sortie->getOrganisateur() == $user && $sortie->getEtat() == 'EN CREATION') {
            array_push($actions, "<a href=\"publier\">publier</a>&nbsp;");
        }
        /**
         * si le user est l'organisateur et etat ouvert alors peut annuler
         */
        if (($sortie->getOrganisateur() == $user) && ($sortie->getEtat()->getLibelle() == 'OUVERT')) {
            array_push($actions, "<a href=\"sortie/cancel/" . $sortie->getId() . "\">Annuler</a>&nbsp;");
        }
        return $actions;
    }

    /**
     * @param Sortie $sortie
     * @return  'le nombre de participants à une sortie'
     */
    public function nbParticipant(Sortie $sortie)
    {
        return count($sortie->getParticipant());
    }

    /**
     * @param Sortie $sortie
     * @return  'le nombre de participants à une sortie'
     */
    public function nbParticipantTotal(Sortie $sortie)
    {
        return $sortie->getNbInscriptionMax();
    }

    /**
     * @param Sortie $sortie
     * @return  'la durée d'une sortie'
     */
    public function dureeSortie(Sortie $sortie)
    {
        return $sortie->getDateHeureDebut()->diff($sortie->getHeureFin())->format('%hh%I');
    }

    /**
     * @param Sortie $sortie
     * @param User $user
     * @return 'si l'utilisateur courant est present à la sortie'
     */
    public function isInscrit(Sortie $sortie, User $user)
    {
        if ($user) {
            foreach ($sortie->getParticipant() as $participant) {
                if ($participant == $user) {
                    return true;
                }
            }
            return false;
        }
    }

    public function isAdmin(User $user)
    {
        $listeRoles = $user->getRoles();
        foreach ($listeRoles as $role) {
            if ($role == 'ROLE_ADMIN') {
                //' <a class="nav-link " href="{{ path(\'easyadmin\')}}">Administration</a>'
                return true;
            } else {
                return false;
            }
        }
    }
}
