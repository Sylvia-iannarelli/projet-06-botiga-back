<?php

namespace App\Entity;

use App\Repository\OrderlineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=OrderlineRepository::class)
 */
class Orderline
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups ({"order_list", "order_show"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @groups ({"order_list", "order_show"})
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderlines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderCode;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="orderlines")
     * @ORM\JoinColumn(nullable=false)
     * @groups ({"order_list", "order_show"})
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrderCode(): ?Order
    {
        return $this->orderCode;
    }

    public function setOrderCode(?Order $orderCode): self
    {
        $this->orderCode = $orderCode;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
