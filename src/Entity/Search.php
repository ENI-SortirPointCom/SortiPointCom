<?php
namespace App\Entity;
class Search
{
private $organisateur;
private $etatInscrit;
private $passe;
private $siteSortie;
private $nomSearch;
private $dateDebut;
private $dateFin;
private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param mixed $organisateur
     */
    public function setOrganisateur($organisateur): void
    {
        $this->organisateur = $organisateur;
    }

    /**
     * @return mixed
     */
    public function getEtatInscrit()
    {
        return $this->etatInscrit;
    }

    /**
     * @param mixed $etatInscrit
     */
    public function setEtatInscrit($etatInscrit): void
    {
        $this->etatInscrit = $etatInscrit;
    }

    /**
     * @return mixed
     */
    public function getPasse()
    {
        return $this->passe;
    }

    /**
     * @param mixed $passe
     */
    public function setPasse($passe): void
    {
        $this->passe = $passe;
    }

    /**
     * @return mixed
     */
    public function getSiteSortie()
    {
        return $this->siteSortie;
    }

    /**
     * @param mixed $siteSortie
     */
    public function setSiteSortie($siteSortie): void
    {
        $this->siteSortie = $siteSortie;
    }

    /**
     * @return mixed
     */
    public function getNomSearch()
    {
        return $this->nomSearch;
    }

    /**
     * @param mixed $nomSearch
     */
    public function setNomSearch($nomSearch): void
    {
        $this->nomSearch = $nomSearch;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin): void
    {
        $this->dateFin = $dateFin;
    }



}