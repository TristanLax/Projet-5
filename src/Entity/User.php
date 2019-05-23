<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @Vich\Uploadable()
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var array
     * @ORM\Column(type="text")
     */
    private $roles = '{"0":"ROLE_USER"}';

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="author", orphanRemoval=true, cascade={"persist"})
     */
    private $user_posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author", orphanRemoval=true)
     */
    private $user_comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostVotes", mappedBy="user", orphanRemoval=true)
     */
    private $user_votes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentReports", mappedBy="user", orphanRemoval=true)
     */
    private $user_reports;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostReports", mappedBy="user", orphanRemoval=true)
     */
    private $post_reports;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="sender", orphanRemoval=true)
     */
    private $sender;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="receiver", orphanRemoval=true)
     */
    private $receiver;
    

    public function __construct()
    {
        $this->updated_at = new \DateTime();
        $this->user_posts = new ArrayCollection();
        $this->user_comments = new ArrayCollection();
        $this->user_votes = new ArrayCollection();
        $this->user_reports = new ArrayCollection();
        $this->post_reports = new ArrayCollection();
        $this->sender = new ArrayCollection();
        $this->receiver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {

        $roles = $this->roles ? json_decode($this->roles, TRUE) : [];

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles ? json_encode($roles, JSON_FORCE_OBJECT) : [];
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * @return null|string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param null|string $filename
     */
    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return null|File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param null|File $imageFile
     */
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
    }


    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->roles,
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->roles,
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }


    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Post[]
     */
    public function getUserPosts(): Collection
    {
        return $this->user_posts;
    }

    public function addUserPost(Post $userPost): self
    {
        if (!$this->user_posts->contains($userPost)) {
            $this->user_posts[] = $userPost;
            $userPost->setAuthor($this);
        }

        return $this;
    }

    public function removeUserPost(Post $userPost): self
    {
        if ($this->user_posts->contains($userPost)) {
            $this->user_posts->removeElement($userPost);
            // set the owning side to null (unless already changed)
            if ($userPost->getAuthor() === $this) {
                $userPost->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getUserComments(): Collection
    {
        return $this->user_comments;
    }

    public function addUserComment(Comment $userComment): self
    {
        if (!$this->user_comments->contains($userComment)) {
            $this->user_comments[] = $userComment;
            $userComment->setAuthor($this);
        }

        return $this;
    }

    public function removeUserComment(Comment $userComment): self
    {
        if ($this->user_comments->contains($userComment)) {
            $this->user_comments->removeElement($userComment);
            // set the owning side to null (unless already changed)
            if ($userComment->getAuthor() === $this) {
                $userComment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PostVotes[]
     */
    public function getUserVotes(): Collection
    {
        return $this->user_votes;
    }

    public function addUserVote(PostVotes $userVote): self
    {
        if (!$this->user_votes->contains($userVote)) {
            $this->user_votes[] = $userVote;
            $userVote->setUser($this);
        }

        return $this;
    }

    public function removeUserVote(PostVotes $userVote): self
    {
        if ($this->user_votes->contains($userVote)) {
            $this->user_votes->removeElement($userVote);
            // set the owning side to null (unless already changed)
            if ($userVote->getUser() === $this) {
                $userVote->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|commentReports[]
     */
    public function getUserReports(): Collection
    {
        return $this->user_reports;
    }

    public function addUserReport(commentReports $userReport): self
    {
        if (!$this->user_reports->contains($userReport)) {
            $this->user_reports[] = $userReport;
            $userReport->setUser($this);
        }

        return $this;
    }

    public function removeUserReport(commentReports $userReport): self
    {
        if ($this->user_reports->contains($userReport)) {
            $this->user_reports->removeElement($userReport);
            // set the owning side to null (unless already changed)
            if ($userReport->getUser() === $this) {
                $userReport->setUser(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|PostReports[]
     */
    public function getPostReports(): Collection
    {
        return $this->post_reports;
    }

    public function addPostReport(PostReports $postReport): self
    {
        if (!$this->post_reports->contains($postReport)) {
            $this->post_reports[] = $postReport;
            $postReport->setUser($this);
        }

        return $this;
    }

    public function removePostReport(PostReports $postReport): self
    {
        if ($this->post_reports->contains($postReport)) {
            $this->post_reports->removeElement($postReport);
            // set the owning side to null (unless already changed)
            if ($postReport->getUser() === $this) {
                $postReport->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getSender(): Collection
    {
        return $this->sender;
    }

    public function addSender(Message $sender): self
    {
        if (!$this->sender->contains($sender)) {
            $this->sender[] = $sender;
            $sender->setSender($this);
        }

        return $this;
    }

    public function removeSender(Message $sender): self
    {
        if ($this->sender->contains($sender)) {
            $this->sender->removeElement($sender);
            // set the owning side to null (unless already changed)
            if ($sender->getSender() === $this) {
                $sender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getReceiver(): Collection
    {
        return $this->receiver;
    }

    public function addReceiver(Message $receiver): self
    {
        if (!$this->receiver->contains($receiver)) {
            $this->receiver[] = $receiver;
            $receiver->setReceiver($this);
        }

        return $this;
    }

    public function removeReceiver(Message $receiver): self
    {
        if ($this->receiver->contains($receiver)) {
            $this->receiver->removeElement($receiver);
            // set the owning side to null (unless already changed)
            if ($receiver->getReceiver() === $this) {
                $receiver->setReceiver(null);
            }
        }

        return $this;
    }

}
