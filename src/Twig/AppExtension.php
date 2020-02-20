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
            new TwigFilter('nbParticipant',[$this,'nbParticipant'])
        ];
    }

    public function getFunctions(): array
    {
        return [];
    }

    public function action(Sortie $sortie)
    {

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
        foreach ($sortie->getParticipant() as $participant) {
            if ($participant->getId() === $user->getId()) {
                return 'X';
            }
        }
        return '-';
    }
}
