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
            new TwigFilter('present', [$this, 'isPresent']),
            new TwigFilter('nbParticipant',[$this,'nbParticipant']),
            new TwigFilter('actions',[$this,'actions'])
        ];
    }

    public function getFunctions(): array
    {
        return [];
    }

    public function actions(Sortie $sortie)
    {
        $actions = [];
        $datetDuJour = date("Y-m-d H:i:s");
        if($datetDuJour < $sortie->getDateLimitInscription()){
            array_push($actions,"<a href=\"cheminVersSinscrire\"></a>");
            array_push($actions,"<a href=\"cheminVersAilleur\"></a>");
        }
        return $actions;
    }

    /**
     * @param Sortie $sortie
     * @return  le nombre de participants à une sortie
     */
    public function nbParticipant(Sortie $sortie)
    {
        return  count($sortie->getParticipant());
    }

    /**
     * @param Sortie $sortie
     * @param User $user
     * @return si l'utilisateur courant est present à la sortie
     */
    public function isPresent(Sortie $sortie, User $user)
    {
        if ($user) {
            foreach ($sortie->getParticipant() as $participant) {
                if ($participant->getId() === $user->getId()) {
                    return 'X';
                }
            }
            return '-';
        }
    }
}
