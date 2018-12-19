<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="reservations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *@Assert\Valid()
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="reservations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Staff", inversedBy="reservation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $staff;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Room", inversedBy="reservations", cascade={"persist"})
     */
    private $rooms;

    /**
     * @ORM\Column(type="text")
     */
    private $signature;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReservationEquipement", mappedBy="reservation", cascade={"persist"})
     * @Assert\Valid()
     */
    private $reservationEquipements;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->reservationEquipements = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param null|string $comment
     * @return Reservation
     */
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     * @return Reservation
     */
    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     * @return Reservation
     */
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
            $room->setReservation($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->rooms->contains($room)) {
            $this->rooms->removeElement($room);
            // set the owning side to null (unless already changed)
            if ($room->getReservation() === $this) {
                $room->setReservation(null);
            }
        }

        return $this;
    }


    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return Collection|ReservationEquipement[]
     */
    public function getReservationEquipements(): Collection
    {
        return $this->reservationEquipements;
    }


    /**
     * @param ReservationEquipement $reservationEquipement
     * @return mixed
     */
    public function addReservationEquipement(ReservationEquipement $reservationEquipement): self
    {
        if (!$this->reservationEquipements->contains($reservationEquipement)) {
            $this->reservationEquipements[] = $reservationEquipement;
            $reservationEquipement->setReservation($this);
        }

        return $this;
    }

    public function removeReservationEquipement(ReservationEquipement $reservationEquipement): self
    {
        if ($this->reservationEquipements->contains($reservationEquipement)) {
            $this->reservationEquipements->removeElement($reservationEquipement);
            // set the owning side to null (unless already changed)
            if ($reservationEquipement->getReservation() === $this) {
                $reservationEquipement->setReservation(null);
            }
        }
      
        return $this;
    }
}
