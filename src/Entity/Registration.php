<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegistrationRepository::class)
 */
class Registration extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Invite::class, inversedBy="registration", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $invite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvite(): ?Invite
    {
        return $this->invite;
    }

    public function setInvite(Invite $invite): self
    {
        $this->invite = $invite;

        return $this;
    }
}
