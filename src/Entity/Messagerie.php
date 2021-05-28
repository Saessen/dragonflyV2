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
    private $isRead = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="messages")
     */
    private $event;

    // /**
    //  * @ORM\OneToMany(targetEntity=Event::class, mappedBy="messagerieExpediteur")
    //  */
    // private $Expediteur;

    // /**
    //  * @ORM\OneToMany(targetEntity=Event::class, mappedBy="messagerieDestinataire")
    //  */
    // private $destinataire;

    public function __construct()
    {
        // $this->Expediteur = new ArrayCollection();
        // $this->destinataire = new ArrayCollection();
    }

    
    public function getid(): int
    {
        return $this->id;
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

    // /**
    //  * @return Collection|Event[]
    //  */
    // public function getExpediteur(): ?Collection
    // {
    //     return $this->Expediteur;
    // }

    // public function addExpediteur(?Event $expediteur): self
    // {
    //     if (!$this->Expediteur->contains($expediteur)) {
    //         $this->Expediteur[] = $expediteur;
    //         $expediteur->setMessagerieExpediteur($this);
    //     }

    //     return $this;
    // }

    // public function removeExpediteur(Event $expediteur): self
    // {
    //     if ($this->Expediteur->removeElement($expediteur)) {
    //         // set the owning side to null (unless already changed)
    //         if ($expediteur->getMessagerieExpediteur() === $this) {
    //             $expediteur->setMessagerieExpediteur(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection|Event[]
    //  */
    // public function getDestinataire(): Collection
    // {
    //     return $this->destinataire;
    // }

    // public function addDestinataire(Event $destinataire): self
    // {
    //     if (!$this->destinataire->contains($destinataire)) {
    //         $this->destinataire[] = $destinataire;
    //         $destinataire->setMessagerieDestinataire($this);
    //     }

    //     return $this;
    // }

    // public function removeDestinataire(Event $destinataire): self
    // {
    //     if ($this->destinataire->removeElement($destinataire)) {
    //         // set the owning side to null (unless already changed)
    //         if ($destinataire->getMessagerieDestinataire() === $this) {
    //             $destinataire->setMessagerieDestinataire(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

   
}
