<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Ventes
 *
 * @ORM\Table(name="ventes")
 * @ORM\Entity(repositoryClass="M1\MagAppBundle\Repository\VentesRepository")
 */
class Ventes
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateHoraire", type="datetimetz")
     */
    private $dateHoraire;

    /**
     * @var int
     *
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     message="Quantite  doit  être que  des chiffres")
     *@Assert\Length(
     * max=3,
     *     maxMessage = "La quantite  ne doit pas depasse {{ limit }} chiffre"
     * )
     *
     *@Assert\Range(
     *     min=1,
     *     max=200,
     *     minMessage = "La quantite doit être au moins {{ limit }} ",
     *     maxMessage = "La quantite ne doit pas depassez {{ limit }} "
     * )
     *
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
     * Set dateHoraire
     *
     * @param \DateTime $dateHoraire
     *
     * @return Ventes
     */
    public function setDateHoraire($dateHoraire)
    {
        $this->dateHoraire = $dateHoraire;

        return $this;
    }

    /**
     * Get dateHoraire
     *
     * @return \DateTime
     */
    public function getDateHoraire()
    {
        return $this->dateHoraire;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Ventes
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

