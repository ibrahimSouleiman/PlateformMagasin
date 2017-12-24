<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateurs
 *
 * @ORM\Table(name="utilisateurs")
 * @ORM\Entity(repositoryClass="M1\MagAppBundle\Repository\UtilisateursRepository")
 */
class Utilisateurs
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
     * @ORM\Column(name="motdepasse", type="string", length=255)
     */
    private $motdepasse;

    /**
     * @var string
     *
     * @ORM\Column(name="nomUtilisateur", type="string", length=255)
     */
    private $nomUtilisateur;


   
    /**
    * @ORM\ManyToOne(targetEntity="Types")
    */
    
    private $type; 
    
    /**
    * @ORM\ManyToOne(targetEntity="Personnes")
    */
    private $personne;

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
     * Get idtype
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set idType
     *
     * @param string $idtype
     *
     * @return Utilisateurs
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

      /**
     * Get idtype
     *
     * @return int
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set idType
     *
     * @param string $idPersonne
     *
     * @return Utilisateurs
     */
    public function setPersonne($personne)
    {
        $this->personne = $personne;

        return $this;
    }
    /**
     * Get motdepasse
     *
     * @return string
     */
    public function getMotdepasse()
    {
        return $this->motdepasse;
    }

  /**
     * Set motdepasse
     *
     * @param string $motdepasse
     *
     * @return Utilisateurs
     */
    public function setMotdepasse($motdepasse)
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    /**
     * Set nomUtilisateur
     *
     * @param string $nomUtilisateur
     *
     * @return Utilisateurs
     */
    public function setNomUtilisateur($nomUtilisateur)
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    /**
     * Get nomUtilisateur
     *
     * @return string
     */
    public function getNomUtilisateur()
    {
        return $this->nomUtilisateur;
    }
}

