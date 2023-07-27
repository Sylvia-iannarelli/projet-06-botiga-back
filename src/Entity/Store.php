<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StoreRepository::class)
 */
class Store
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"store_list", "product_list", "product_store_list", "product_category_list", "order_list", "order_show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Groups({"store_list"})
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     * @Groups({"store_list", "product_list", "product_store_list", "product_category_list", "order_list", "order_show"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"store_list"})
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     * @Groups({"store_list"})
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     * @Groups({"store_list"})
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"store_list"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"store_list"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"store_list"})
     */
    private $schedules;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"store_list"})
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"store_list"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="store", orphanRemoval=true)
     * @Groups({"product_store_list"})
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="store", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"store_list"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="store")
     */
    private $orders;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSchedules(): ?string
    {
        return $this->schedules;
    }

    public function setSchedules(?string $schedules): self
    {
        $this->schedules = $schedules;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setStore($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getStore() === $this) {
                $product->setStore(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setStore($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getStore() === $this) {
                $order->setStore(null);
            }
        }

        return $this;
    }
}
