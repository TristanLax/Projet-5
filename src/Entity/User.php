<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
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
     * @ORM\Column(type="json")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="Author", orphanRemoval=true, cascade={"persist"})
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
    

    public function __construct()
    {
        $this->user_posts = new ArrayCollection();
        $this->user_comments = new ArrayCollection();
        $this->user_votes = new ArrayCollection();
        $this->user_reports = new ArrayCollection();
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
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
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

    /**
     * @inheritDoc
     */
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

}
