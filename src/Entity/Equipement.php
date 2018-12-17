<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipementRepository")
 */
class Equipement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Vous devez renseigner un nom pour enregistrer votre équipement")
     * @Assert\Length(max = 255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReservationEquipement", mappedBy="equipement")
     */
    private $reservationEquipements;

    public function __construct()
    {
        $this->reservationEquipements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|ReservationEquipement[]
     */
    public function getReservationEquipements(): Collection
    {
        return $this->reservationEquipements;
    }

    public function addReservationEquipement(ReservationEquipement $reservationEquipement): self
    {
        if (!$this->reservationEquipements->contains($reservationEquipement)) {
            $this->reservationEquipements[] = $reservationEquipement;
            $reservationEquipement->setEquipement($this);
        }

        return $this;
    }

    public function removeReservationEquipement(ReservationEquipement $reservationEquipement): self
    {
        if ($this->reservationEquipements->contains($reservationEquipement)) {
            $this->reservationEquipements->removeElement($reservationEquipement);
            // set the owning side to null (unless already changed)
            if ($reservationEquipement->getEquipement() === $this) {
                $reservationEquipement->setEquipement(null);
            }
        }

        return $this;
    }
}
