<?php

namespace App\Entity;

use App\Repository\MessagerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessagerieRepository::class)
 */
class Messagerie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRead;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="messageries")
     */
    private $expediteur;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="messageries")
     */
    private $destinataire;

    public function __construct()
    {
        $this->expediteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpediteur(): ?string
    {
        return $this->expediteur;
    }

    public function setExpediteur(?string $expediteur): self
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDestinataire(): ?User
    {
        return $this->destinataire;
    }

    public function setDestinataire(?User $destinataire): self
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function addExpediteur(User $expediteur): self
    {
        if (!$this->expediteur->contains($expediteur)) {
            $this->expediteur[] = $expediteur;
        }

        return $this;
    }

    public function removeExpediteur(User $expediteur): self
    {
        $this->expediteur->removeElement($expediteur);

        return $this;
    }
}
