<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 * @ORM\Table(name="`member`")
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="members")
     */
    private ?User $talker = null;

    /**
     * @ORM\ManyToOne(targetEntity=Talk::class, inversedBy="members")
     */
    private ?Talk $talk = null;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="members")
     */
    private ?Message $viewedMessage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTalker(): ?User
    {
        return $this->talker;
    }

    public function setTalker(?User $talker): self
    {
        $this->talker = $talker;

        return $this;
    }

    public function getTalk(): ?Talk
    {
        return $this->talk;
    }

    public function setTalk(?Talk $talk): self
    {
        $this->talk = $talk;

        return $this;
    }

    public function getViewedMessage(): ?Message
    {
        return $this->viewedMessage;
    }

    public function setViewedMessage(?Message $viewedMessage): self
    {
        $this->viewedMessage = $viewedMessage;

        return $this;
    }
}
