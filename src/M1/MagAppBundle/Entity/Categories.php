<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="M1\MagAppBundle\Repository\CategoriesRepository")
 */
class Categories
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
     * @Assert\NotBlank(message="Reference du Produit ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9]*$/",
     *     message="Libelle du Categorie doit contenir que des caracteres et des chiffres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=200,
     *     minMessage = "Libelle du Categoriet doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Libelle du Categorie ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="LibelleCategorie", type="string", length=100)
     */
    private $libelleCategorie;


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
     * Set libelleCategoriele
     *
     * @param string $libelleCategoriele
     *
     * @return Categories
     */
    public function setLibelleCategorie($libelleCategorie)
    {

        $this->libelleCategorie = $libelleCategorie;

        return $this;
    }

    /**
     * Get libelleCategoriele
     *
     * @return string
     */

    public function getLibelleCategorie()
    {
        return $this->libelleCategorie;
    }


    
}

