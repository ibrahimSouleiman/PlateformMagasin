<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commandes
 *
 * @ORM\Table(name="commandes")
 * @ORM\Entity(repositoryClass="M1\MagAppBundle\Repository\CommandesRepository")
 */
class Commandes
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateHoraireAjout", type="datetimetz")
     */
    private $dateHoraireAjout;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]*$/",
     *     message="Etat de la Commande doit constitue que des Caractère")
     *
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage = "Etat de la Commande doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Etat de la Commande ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;


    /**
    *
    * @ORM\ManyToOne(targetEntity="Produit")
    */
    private $produit;

    /**
    *
    * @ORM\ManyToOne(targetEntity="Paniers")
    */
    private $panier;


    /**
     * @var int
     * @Assert\NotBlank(message="Quantite du Produit ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     message="Quantite Commande doit contenir que  des chiffres")
     *
     * @Assert\Length(
     *     min=1,
     *     max=4,
     *     minMessage = " Quantite C doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Quantite Commande ne doit pas depasse {{ limit }} charactère"
     * )
     * @Assert\Range(
     *     min=0,
     *     max=200,
     *     minMessage = "Quantite Commande doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Quantite Commande ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

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
     * Set dateHoraire
     *
     * @param \DateTime $dateHoraire
     *
     * @return Commande
     */
    public function setDateHoraireAjout($dateHoraireAjout)
    {
        $this->dateHoraireAjout = $dateHoraireAjout;

        return $this;
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
     * Get dateHoraire
     *
     * @return \DateTime
     */
    public function getDateHoraireAjout()
    {
        return $this->dateHoraireAjout;
    }


     /**
     * Set Produit
     *
     * @param Produit
     *
     * @return Commandes
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }
    /**
     * Get Produit
     *
     * @return Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }
  
    /**
     * Set Panier
     *
     * @param Produit
     *
     * @return Commandes
     */
    public function setPanier($panier)
    {
        $this->panier = $panier;

        return $this;
    }

   /**
     * Get Panier
     *
     * @return Panier
     */
    public function getPanier()
    {
        return $this->panier;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Commandes
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }
}

