<?php

namespace M1\MagAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Images
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="M1\MagAppBundle\Repository\TypesRepository")
 */
class Images
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
     * @ORM\Column(name="Url", type="string", length=255)
     */
    private $url;


     /**
     * @var string
     *
     * @ORM\Column(name="Alt", type="string", length=255)
     */
    private $alt;

    private $file;
  
    public function getFile()
    {
        return $this->file;
    } 

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
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
     * Set url
     *
     * @param string $url
     *
     * @return Images
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


     /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Images
     */
    public function setAlt($alt)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }


    public function upload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }

    // On récupère le nom original du fichier de l'internaute
    $name = $this->file->getClientOriginalName();

    // On déplace le fichier envoyé dans le répertoire de notre choix
    $this->file->move($this->getUploadRootDir(), $name);

    // On sauvegarde le nom de fichier dans notre attribut $url
    $this->url = 'uploads/img/'.$name;

    // On crée également le futur attribut alt de notre balise <img>
    $this->alt = $name;
  }

  public function getUploadDir()
  {
    // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
    return 'uploads/img';
  }

  protected function getUploadRootDir()
  {
    // On retourne le chemin relatif vers l'image pour notre code PHP
    return __DIR__.'/../../../../web/'.$this->getUploadDir();
  }
}

