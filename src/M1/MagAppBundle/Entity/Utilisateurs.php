<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Utilisateurs
 *
 * @ORM\Table(name="utilisateurs")
 * @ORM\Entity(repositoryClass="M1\MagAppBundle\Repository\UtilisateursRepository")
 * @UniqueEntity(fields={"username"},message="Email existe déjà")
 */
class Utilisateurs implements  UserInterface
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
      *     message="Nom doit constitue que des Caractère"
      * )
      * @Assert\Length(
      *     min=3,
      *     max=100,
      *     minMessage = "Votre nom doit contenir au moins {{ limit }} charactère ",
      *     maxMessage = "Votre nom ne doit pas depasse {{ limit }} charactère"
      * )
      *
      *
      * @ORM\Column(name="nom", type="string", length=255)
     */
      private $nom;


    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]*$/",
     *     message="Prénom doit constitue que des Caractère")
     *
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage = "Votre prénom doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Votre prénom ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;



    /**
     * @var string
     * @Assert\Email( message = "Le email '{{ value }}' n\'est pas valide.",checkMX = true)
     *@Assert\Length(
     *     min=3,
     *     max=150,
     *     minMessage = "Votre email doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Votre email ne doit pas depasse {{ limit }} charactère"
     * )
     * @Assert\Regex(
     *     pattern="/^<>/",
     *     match=false,
     *     message="Le nom d'utilisateur ne doit pas contenir les symbole < >"
     * )
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^<>/",
     *     match=false,
     *     message="Le mot de passe doit contenir les symbole < >"
     * )
     *@Assert\Length(
     *     min=8,
     *     max=200,
     *     minMessage = "Votre mot de passe doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Votre mot de passe ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;


    /**
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    // Les getters et setters

    public function eraseCredentials()
    {
    }

   


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
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
  /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Utilisateurs
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }
   /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
  /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Utilisateurs
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }
    /**
     * Get motdepasse
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

  /**
     * Set motdepasse
     *
     * @param string $motdepasse
     *
     * @return Utilisateurs
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }



    /**
     * Set Salt
     * @param $salt
     *
     * @return Utilisateurs
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Get Salt
     *
     * @return Salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set Roles
     *
     * @param $roles
     *
     * @return Utilisateurs
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get Roles
     *
     * @return Roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set nomUtilisateur
     *
     * @param string $nomUtilisateur
     *
     * @return Utilisateurs
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get nomUtilisateur
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}

