<?php

namespace MyApp\FilmothequeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="MyApp\FilmothequeBundle\Repository\ImageRepository")
 * @ORM\HaslifecycleCallbacks
 */
class Image
{

    /**
     * @ORM\ManyToOne(targetEntity="MyApp\FilmothequeBundle\Entity\Film",inversedBy="images")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="film_id",referencedColumnName="id",onDelete="cascade")
     * })
     */
    private $film;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    private $file;

    private $extension;

    private $tempFilename;

    public function getFile(){
        return $this->file;
    }

    public function setFile(UploadedFile $file){
        $this->file = $file;

        if(null !== $this->path){

            $this->tempFilename = $this->path;
            $this->path = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){

        if(null === $this->file){
            return;
        }

        $path = $this->file->getClientOriginalName();
        $expl = explode('.',$path);
        $this->path = md5($expl[0].date('U')).'.'.$this->file->guessExtension();

    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if(null === $this->file){
            return;
        }
        if(null !== $this->tempFilename){
            $oldFile = $this->getUploadRootDir().'.'.$this->tempFilename;
            if(file_exists($oldFile)){
                unlink($oldFile);
            }
        }
        $this->file->move($this->getUploadRootDir(),$this->path.'.'.$this->extension);
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload(){
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * @ORM\PostRemove()
     */
    public function RemoveUpload(){
        if(file_exists($this->tempFilename)){
            unlink($this->tempFilename);
        }
    }


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * @return Image
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

    public function getUploadDir(){
        return 'uploads/img';
    }

    protected function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Set film
     *
     * @param \MyApp\FilmothequeBundle\Entity\Film $film
     *
     * @return Image
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
