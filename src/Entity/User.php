<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

// https://symfony.com/doc/current/reference/constraints/UniqueEntity.html
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups ({"user_show","user_list","user_edit" })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     * @Assert\NotBlank
     * @Assert\Email
     * @groups ({"user_show","user_list","user_edit" })
     */
    private $email;

    /**
     * @ORM\Column(type="json" )
     * @Assert\NotBlank
     * @groups ({"user_show","user_list","user_edit" })
     */
    private $roles = [""];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @groups ({"user_list","user_edit" })
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank
     * @groups ({"user_show","user_list","user_edit" })
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank
     * @groups ({"user_show","user_list","user_edit" })
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank
     * @groups ({"user_show","user_list","user_edit" })
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity=Store::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $store;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getFirstName ( ) . ' ' . $this -> getLastName ( );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //  $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(Store $store): self
    {
        // set the owning side of the relation if necessary
        if ($store->getUser() !== $this) {
            $store->setUser($this);
        }

        $this->store = $store;

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
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }
}
