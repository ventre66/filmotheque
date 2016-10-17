<?php

namespace MyApp\FilmothequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Film
 *
 * @ORM\Table(name="film")
 * @ORM\Entity(repositoryClass="MyApp\FilmothequeBundle\Repository\FilmRepository")
 * @ORM\HaslifecycleCallbacks()
 */
class Film
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
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\FilmothequeBundle\Entity\Image",cascade={"persist","remove"},mappedBy="film")
     * @ORM\JoinColumn(nullable=true)
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\FilmothequeBundle\Entity\Video",cascade={"persist","remove"},mappedBy="film")
     * @ORM\JoinColumn(nullable=true)
     */
    private $video;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @Assert\NotBlank()
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="Acteur",inversedBy="films")
     * @ORM\JoinTable(name="film_acteur")
     */
    private $acteurs;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Film
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Film
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->acteurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set categorie
     *
     * @param \MyApp\FilmothequeBundle\Entity\Categorie $categorie
     *
     * @return Film
     */
    public function setCategorie(\MyApp\FilmothequeBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \MyApp\FilmothequeBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Add acteur
     *
     * @param \MyApp\FilmothequeBundle\Entity\Acteur $acteur
     *
     * @return Film
     */
    public function addActeur(\MyApp\FilmothequeBundle\Entity\Acteur $acteur)
    {
        $this->acteurs[] = $acteur;

        return $this;
    }

    /**
     * Remove acteur
     *
     * @param \MyApp\FilmothequeBundle\Entity\Acteur $acteur
     */
    public function removeActeur(\MyApp\FilmothequeBundle\Entity\Acteur $acteur)
    {
        $this->acteurs->removeElement($acteur);
    }

    /**
     * Get acteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActeurs()
    {
        return $this->acteurs;
    }

    /**
     * Add image
     *
     * @param \MyApp\FilmothequeBundle\Entity\Image $image
     *
     * @return Film
     */
    public function addImage(\MyApp\FilmothequeBundle\Entity\Image $image)
    {
        if($image->getFile()!== null){
                $this->images[] = $image;
             $image->setFilm($this);
        }

        return $this;
    }

    /**
     * Remove image
     *
     * @param \MyApp\FilmothequeBundle\Entity\Image $image
     */
    public function removeImage(\MyApp\FilmothequeBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add video
     *
     * @param \MyApp\FilmothequeBundle\Entity\Video $video
     *
     * @return Film
     */
    public function addVideo(\MyApp\FilmothequeBundle\Entity\Video $video)
    {
        if($video->getPath()!== null){
        $this->video[] = $video;
             $video->setFilm($this);
        }

        return $this;
    }

    /**
     * Remove video
     *
     * @param \MyApp\FilmothequeBundle\Entity\Video $video
     */
    public function removeVideo(\MyApp\FilmothequeBundle\Entity\Video $video)
    {
        $this->video->removeElement($video);
    }

    /**
     * Get video
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideo()
    {
        return $this->video;
    }


}
