<?php

namespace MyApp\FilmothequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="MyApp\FilmothequeBundle\Repository\VideoRepository")
 * @ORM\HaslifecycleCallbacks
 */
class Video
{

    /**
     * @ORM\ManyToOne(targetEntity="MyApp\FilmothequeBundle\Entity\Film",inversedBy="video")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="film_id",referencedColumnName="id",onDelete="cascade")
     * })
     */
    private $film;



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
     * @ORM\Column(name="path", type="string", length=500)
     */
    private $path;


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
     * Set path
     *
     * @param string $path
     *
     * @return Video
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set film
     *
     * @param \MyApp\FilmothequeBundle\Entity\Film $film
     *
     * @return Video
     */
    public function setFilm(\MyApp\FilmothequeBundle\Entity\Film $film = null)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return \MyApp\FilmothequeBundle\Entity\Film
     */
    public function getFilm()
    {
        return $this->film;
    }
}
