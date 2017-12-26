<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     *
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
        $this->libelleCategoriele = $libelleCategoriele;

        return $this;
    }

    /**
     * Get libelleCategoriele
     *
     * @return string
     */
    public function getLibelleCategoriele()
    {
        return $this->libelleCategoriele;
    }
}

