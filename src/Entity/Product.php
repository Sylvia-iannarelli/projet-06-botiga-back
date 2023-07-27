<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product_list", "product_store_list", "product_category_list", "order_list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"product_list", "product_store_list", "product_category_list", "order_list"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product_list", "product_store_list", "product_category_list"})
     */
    private $description;

    /**
     * @ORM\Column(type="float", scale="2")
     * @Groups({"product_list", "product_store_list", "product_category_list", "order_list"})
     */
    private $price;

    /**
     * @ORM\Column(type="json")
     * @Groups({"product_list", "product_store_list", "product_category_list"})
     */
    private $vatRate;

    /**
     * @ORM\Column(type="json")
     * @Groups({"product_list", "product_store_list", "product_category_list"})
     */
    private $unitOfMeasurement;

    /**
     * @ORM\Column(type="float", scale="2")
     * @Groups({"product_list", "product_store_list", "product_category_list"})
     */
    private $pricePerUnit;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"product_list", "product_store_list", "product_category_list"})
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"product_list", "product_store_list", "product_category_list"})
     */
    private $picture;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"product_list", "product_store_list", "product_category_list"})
     */
    private $heartLike;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"product_list", "product_category_list", "order_list", "order_show"})
     */
    private $store;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"product_list", "product_store_list"})
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Orderline::class, mappedBy="product")
     */
    private $orderlines;

    public function __construct()
    {
        $this->orderlines = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVatRate(): ?string
    {
        return $this->vatRate;
    }

    public function setVatRate(string $vatRate): self
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    public function getUnitOfMeasurement(): ?string
    {
        return $this->unitOfMeasurement;
    }

    public function setUnitOfMeasurement(string $unitOfMeasurement): self
    {
        $this->unitOfMeasurement = $unitOfMeasurement;

        return $this;
    }

    public function getPricePerUnit(): ?float
    {
        return $this->pricePerUnit;
    }

    public function setPricePerUnit(float $pricePerUnit): self
    {
        $this->pricePerUnit = $pricePerUnit;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getHeartLike(): ?int
    {
        return $this->heartLike;
    }

    public function setHeartLike(?int $heartLike): self
    {
        $this->heartLike = $heartLike;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $orderline->setProduct($this);
        }

        return $this;
    }

    public function removeOrderline(Orderline $orderline): self
    {
        if ($this->orderlines->removeElement($orderline)) {
            // set the owning side to null (unless already changed)
            if ($orderline->getProduct() === $this) {
                $orderline->setProduct(null);
            }
        }

        return $this;
    }
}
