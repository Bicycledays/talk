<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $username = '';

    /**
     * @ORM\Column(type="json")
     * @var string[]
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\ManyToMany(targetEntity=Talk::class, mappedBy="talkers")
     */
    private Collection $talks;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="author")
     */
    private Collection $messages;

    /**
     * @ORM\OneToMany(targetEntity=Invite::class, mappedBy="sender")
     */
    private Collection $invites;

    /**
     * @ORM\OneToOne(targetEntity=Invite::class, mappedBy="newUser", cascade={"persist", "remove"})
     */
    private ?Invite $invite = null;

    /**
     * @ORM\OneToMany(targetEntity=Talk::class, mappedBy="owner")
     */
    private $ownTalks;

    public function __construct()
    {
        $this->talks = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->invites = new ArrayCollection();
        $this->ownTalks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Talk>
     */
    public function getTalks(): Collection
    {
        return $this->talks;
    }

    public function addTalk(Talk $talk): self
    {
        if (!$this->talks->contains($talk)) {
            $this->talks[] = $talk;
            $talk->addTalker($this);
        }

        return $this;
    }

    public function removeTalk(Talk $talk): self
    {
        if ($this->talks->removeElement($talk)) {
            $talk->removeTalker($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invite>
     */
    public function getInvites(): Collection
    {
        return $this->invites;
    }

    public function addInvite(Invite $invite): self
    {
        if (!$this->invites->contains($invite)) {
            $this->invites[] = $invite;
            $invite->setSender($this);
        }

        return $this;
    }

    public function removeInvite(Invite $invite): self
    {
        if ($this->invites->removeElement($invite)) {
            // set the owning side to null (unless already changed)
            if ($invite->getSender() === $this) {
                $invite->setSender(null);
            }
        }

        return $this;
    }

    public function getInvite(): ?Invite
    {
        return $this->invite;
    }

    public function setInvite(?Invite $invite): self
    {
        // unset the owning side of the relation if necessary
        if ($invite === null && $this->invite !== null) {
            $this->invite->setNewUser(null);
        }

        // set the owning side of the relation if necessary
        if ($invite !== null && $invite->getNewUser() !== $this) {
            $invite->setNewUser($this);
        }

        $this->invite = $invite;

        return $this;
    }

    /**
     * @return Collection<int, Talk>
     */
    public function getOwnTalks(): Collection
    {
        return $this->ownTalks;
    }

    public function addOwnTalk(Talk $ownTalk): self
    {
        if (!$this->ownTalks->contains($ownTalk)) {
            $this->ownTalks[] = $ownTalk;
            $ownTalk->setOwner($this);
        }

        return $this;
    }

    public function removeOwnTalk(Talk $ownTalk): self
    {
        if ($this->ownTalks->removeElement($ownTalk)) {
            // set the owning side to null (unless already changed)
            if ($ownTalk->getOwner() === $this) {
                $ownTalk->setOwner(null);
            }
        }

        return $this;
    }
}
