<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Vous devez renseigner un nom pour enregistrer votre réservation")
     *
     *
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     *
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Vous ne pouvez mettre que des chiffres")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message = "Votre adresse est invalide")
     */
    private $mailAddress;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="customer")
     */
    private $reservations;


    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->reservations = new ArrayCollection();
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
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Customer
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param null|string $firstName
     * @return Customer
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param null|string $phoneNumber
     * @return Customer
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMailAddress(): ?string
    {
        return $this->mailAddress;
    }

    /**
     * @param null|string $mailAddress
     * @return Customer
     */
    public function setMailAddress(?string $mailAddress): self
    {
        $this->mailAddress = $mailAddress;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    /**
     * @param Reservation $reservation
     * @return Customer
     */
    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setCustomer($this);
        }

        return $this;
    }

    /**
     * @param Reservation $reservation
     * @return Customer
     */
    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getCustomer() === $this) {
                $reservation->setCustomer(null);
            }
        }

        return $this;
    }
}
