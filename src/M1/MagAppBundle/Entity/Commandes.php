<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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

