<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Paniers
 *
 * @ORM\Table(name="paniers")
 * @ORM\Entity(repositoryClass="M1\MagAppBundle\Repository\PaniersRepository")
 */
class Paniers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]*$/",
     *     message="Etat du Panier doit constitue que des Caractère")
     *
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage = "Etat du  Panier doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Etat du  Panier ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateHoraireValide", type="datetimetz")
     */
    private $datehorairevalide;


    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]*$/",
     *     message="Description du Panier doit constitue que des Caractère")
     *
     * @Assert\Length(
     *     min=0,
     *     max=255,
     *     minMessage = "Description du  Panier doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Description du  Panier ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
    * @ORM\ManyToOne(targetEntity="Utilisateurs")
    */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="Adresses",fetch="EAGER")
     */
    private $adresse;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateHoraireValide
     *
     * @param \DateTime $dateHoraire
     *
     * @return Panier
     */
    public function setDateHoraireValide($datehorairevalide)
    {
        $this->datehorairevalide = $datehorairevalide;

        return $this;
    }

    /**
     * Get dateHoraire
     *
     * @return \DateTime
     */
    public function getDateHoraireValide()
    {
        return $this->datehorairevalide;
    }

 /**
     * Set Utilisateur
     *
     * @param id $utilisateur
     *
     * @return Paniers
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get Utilisateur
     *
     * @return Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Paniers
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * Get adresse
     *
     * @return Adresse
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

     /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Paniers
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Paniers
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

