<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\InviteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InviteRepository::class)
 */
class Invite extends AbstractEntity
{
    public const TOTAL_LIFE_TIME = 2;   // days

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\OneToOne(targetEntity=Registration::class, mappedBy="invite", cascade={"persist", "remove"})
     */
    private ?Registration $registration;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private ?string $hash = null;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="invites")
     */
    private ?User $sender = null;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="invite", cascade={"persist", "remove"})
     */
    private ?User $newUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistration(): ?Registration
    {
        return $this->registration;
    }

    public function setRegistration(Registration $registration): self
    {
        // set the owning side of the relation if necessary
        if ($registration->getInvite() !== $this) {
            $registration->setInvite($this);
        }

        $this->registration = $registration;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function generateHash(): string
    {
        return md5('test');
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getNewUser(): ?User
    {
        return $this->newUser;
    }

    public function setNewUser(?User $newUser): self
    {
        $this->newUser = $newUser;

        return $this;
    }
}
