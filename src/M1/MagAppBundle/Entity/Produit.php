<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="M1\MagAppBundle\Repository\ProduitRepository")
 */
class Produit
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
     *
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Nom Produit doit contenir que des caracteres et des chiffres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=200,
     *     minMessage = "Nom  du produit doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Nom du produit ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="nom", type="string", length=200)
     */
    private $nom;


    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9]*$/",
     *     message="Nom Produit doit contenir que des caracteres et des chiffres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=200,
     *     minMessage = "Nom  du produit doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Nom du produit ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="reference", type="string", length=200)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=5, scale=0)
     */
    private $prix;

    /**
     * @var int
     * @Assert\NotBlank(message="Quantite du Produit ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     message="Quantite du Produit doit contenir que  des chiffres")
     *
     * @Assert\Length(
     *     min=1,
     *     max=4,
     *     minMessage = "Quantite  du produit doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Quantite du produit ne doit pas depasse {{ limit }} charactère"
     * )
     * @Assert\Range(
     *     min=0,
     *     max=200,
     *     minMessage = "Quantite du produit doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Quantite du produit ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
    *
    * @ORM\ManyToOne(targetEntity="Images", cascade={"persist"})
    */
    private $image;

    /**
     * @var string
     *
     *  @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9]*$/",
     *     message="Details du Produit doit contenir que des caracteres et des chiffres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage = "Detail  du produit doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Detail du produit ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="details", type="string", length=255)
     */
    private $details;



    /**
    * @ORM\ManyToOne(targetEntity="Categories")
    */
    private $categorie;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Produit
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }



    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Produit
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }


     /**
     * Set idcategorie
     *
     * @param string $nom
     *
     * @return Produit
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get idcategorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Produit
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

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Produit
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Produit
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }
}

