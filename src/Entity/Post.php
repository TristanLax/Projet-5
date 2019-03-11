<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @UniqueEntity("title")
 * @Vich\Uploadable
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min=4, max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $votes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $add_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $edit_date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="post", orphanRemoval=true, cascade={"persist"})
     */
    private $pictures;
    
    /**
    * @Assert\All({
    * @Assert\Image(mimeTypes="image/jpeg")
    * })
    */
    private $pictureFiles;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $mainfile;


    /**
     * @var File|null
     * @Assert\Image(
     *     mimeTypes="image/jpeg")
     * @Vich\UploadableField(mapping="post_main", fileNameProperty="mainfile")
     */

    private $mainImage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="user_posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Author;

    
    
    public function __construct()
    {
        $this->add_date = new \DateTime();
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(?int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function getAddDate(): ?\DateTimeInterface
    {
        return $this->add_date;
    }

    public function setAddDate(\DateTimeInterface $add_date): self
    {
        $this->add_date = $add_date;

        return $this;
    }

    public function getEditDate(): ?\DateTimeInterface
    {
        return $this->edit_date;
    }

    public function setEditDate(\DateTimeInterface $edit_date): self
    {
        $this->edit_date = $edit_date;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMainfile(): ?string
    {
        return $this->mainfile;
    }

    /**
     * @param string|null $mainfile
     */
    public function setMainfile(?string $mainfile): void
    {
        $this->mainfile = $mainfile;
    }

    /**
     * @return File|null
     */
    public function getMainImage(): ?File
    {
        return $this->mainImage;
    }

    /**
     * @param File|null $mainImage
     */
    public function setMainImage(?File $mainImage): void
    {
        $this->mainImage = $mainImage;
        if($this->mainImage instanceof UploadedFile) {
            $this->edit_date = new \DateTime('now');
        }
    }






    
    public function getPictureFiles()
    {
        return $this->pictureFiles;
    }
    
    public function setPictureFiles($pictureFiles): self
    {
        foreach($pictureFiles as $pictureFile) {
            $picture = new Picture();
            $picture->setImageFile($pictureFile);
            $this->addPicture($picture);
        }
        
        $this->pictureFiles = $pictureFiles;
        return $this;
    }
    
    
    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setPost($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getPost() === $this) {
                $picture->setPost(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): self
    {
        $this->Author = $Author;

        return $this;
    }

}
