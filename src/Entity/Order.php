<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\Blameable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups ({"order_list", "order_show"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", scale="2", nullable=true)
     * @groups ({"order_list", "order_show"})
     */
    private $orderPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @groups ({"order_list", "order_show"})
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity=Orderline::class, mappedBy="orderCode", orphanRemoval=true)
     * @groups ({"order_list", "order_show"})
     */
    private $orderlines;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="orders")
     * @groups ({"order_list", "order_show"})
     */
    private $store;

    public function __construct()
    {
        $this->orderlines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderPrice(): ?float
    {
        return $this->orderPrice;
    }

    public function setOrderPrice(?float $orderPrice): self
    {
        $this->orderPrice = $orderPrice;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, Orderline>
     */
    public function getOrderlines(): Collection
    {
        return $this->orderlines;
    }

    public function addOrderline(Orderline $orderline): self
    {
        if (!$this->orderlines->contains($orderline)) {
            $this->orderlines[] = $orderline;
            $orderline->setOrderCode($this);
        }

        return $this;
    }

    public function removeOrderline(Orderline $orderline): self
    {
        if ($this->orderlines->removeElement($orderline)) {
            // set the owning side to null (unless already changed)
            if ($orderline->getOrderCode() === $this) {
                $orderline->setOrderCode(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

}
