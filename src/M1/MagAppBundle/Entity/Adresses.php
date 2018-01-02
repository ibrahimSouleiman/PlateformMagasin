<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Adresses
 *
 * @ORM\Table(name="adresses")
 * @ORM\Entity(repositoryClass="M1\MagAppBundle\Repository\AdressesRepository")
 */
class Adresses
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
     * @Assert\NotBlank(message="Nom contenu dans adresse ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]*$/",
     *     message="Nom contenu dans adresse doit contenir que des caracteres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage = "Nom contenu dans adresse doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Nom contenu dans adresse ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="nom", type="string", length=125)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message="Adresse ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9]*$/",
     *     message="Adresse doit contenir que des caracteres ou des chiffres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage = "Adresse doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "Adresse ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     * @Assert\NotBlank(message="le Champ ville contenu dans adresse ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]*$/",
     *     message="le Champ ville contenu  dans adresse doit contenir que des caracteres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage = "le Champ ville contenu  dans adresse doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "le Champ ville contenu  ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     * @Assert\NotBlank(message="le Champ region contenu dans adresse ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]*$/",
     *     message="le Champ region contenu  dans adresse doit contenir que des caracteres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage = "le Champ region contenu  dans adresse doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "le Champ region contenu  ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="region", type="string", length=100)
     */
    private $region;

    /**
     * @var string
     * @Assert\NotBlank(message="le Champ Code Postal contenu dans adresse ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     message="le Champ Code Postal contenu  dans adresse doit contenir que des caracteres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=10,
     *     minMessage = "le Champ Code Postal contenu  dans adresse doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "le Champ Code Postal contenu  ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="codepostal", type="integer")
     */
    private $codepostal;

    /**
     * @var string
     * @Assert\NotBlank(message="le Champ Pays contenu dans adresse ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]*$/",
     *     message="le Champ Pays contenu  dans adresse doit contenir que des caracteres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage = "le Champ Pays contenu  dans adresse doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "le Champ Pays contenu  ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="Pays", type="string", length=100)
     */
    private $pays;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/^[0-9+()]*$/",
     *     message="le Champ Telephone contenu  dans adresse doit contenir que des caracteres")
     *
     * @Assert\Length(
     *     min=3,
     *     max=10,
     *     minMessage = "le Champ Telephone contenu  dans adresse doit contenir au moins {{ limit }} charactère ",
     *     maxMessage = "le Champ Telephone contenu  ne doit pas depasse {{ limit }} charactère"
     * )
     * @ORM\Column(name="telephone", type="string", length=100)
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     */
    private $utilisateur;
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Adresses
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set adresse.
     *
     * @param string $adresse
     *
     * @return Adresses
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse.
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville.
     *
     * @param string $ville
     *
     * @return Adresses
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville.
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set region.
     *
     * @param string $region
     *
     * @return Adresses
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region.
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set codepostal.
     *
     * @param string $codepostal
     *
     * @return Adresses
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal.
     *
     * @return string
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set pays.
     *
     * @param string $pays
     *
     * @return Adresses
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays.
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }



    /**
     * Set telephone.
     *
     * @param string $telephone
     *
     * @return Adresses
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
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

}
