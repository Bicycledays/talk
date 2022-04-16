<?php

namespace App\Entity;

use App\Repository\TalkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TalkRepository::class)
 */
class Talk extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="talks")
     */
    private Collection $talkers;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="talk")
     */
    private Collection $messages;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ownTalks")
     */
    private ?User $owner = null;

    public function __construct()
    {
        $this->talkers = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getTalkers(): Collection
    {
        return $this->talkers;
    }

    public function addTalker(User $talker): self
    {
        if (!$this->talkers->contains($talker)) {
            $this->talkers[] = $talker;
        }

        return $this;
    }

    public function removeTalker(User $talker): self
    {
        $this->talkers->removeElement($talker);

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
            $message->setTalk($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getTalk() === $this) {
                $message->setTalk(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
