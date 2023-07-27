<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $cardholderName;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $numberCard;

    // /**
    //  * @ORM\Column(type="date")
    //  */
    // private $expirationDate;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $secretCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    // /**
    //  * 
    //  * @ORM\Column(type="datetime")
    //  */
    // private $createdAt;

    // public function __construct()
    // {
    //     $this->createdAt = new \DateTime;
        
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardholderName(): ?string
    {
        return $this->cardholderName;
    }

    public function setCardholderName(string $cardholderName): self
    {
        $this->cardholderName = $cardholderName;

        return $this;
    }

    public function getNumberCard(): ?string
    {
        return $this->numberCard;
    }

    public function setNumberCard(string $numberCard): self
    {
        $this->numberCard = $numberCard;

        return $this;
    }

    // public function getExpirationDate(): ?\DateTimeInterface
    // {
    //     return $this->expirationDate;
    // }

    // public function setExpirationDate(\DateTimeInterface $expirationDate): self
    // {
    //     $this->expirationDate = $expirationDate;

    //     return $this;
    // }

    public function getSecretCode(): ?string
    {
        return $this->secretCode;
    }

    public function setSecretCode(string $secretCode): self
    {
        $this->secretCode = $secretCode;

        return $this;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    // public function getCreatedAt(): ?\DateTimeInterface
    // {
    //     return $this->createdAt;
    // }

    // public function setCreatedAt(\DateTimeInterface $createdAt): self
    // {
    //     $this->createdAt = $createdAt;

    //     return $this;
    // }

	
}
