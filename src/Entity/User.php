<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=190)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=190)
     */
    private $password;


    /**
     * @ORM\OneToOne(targetEntity=Store::class, mappedBy="Owner", cascade={"persist", "remove"})
     */
    private $Store;

    /**
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $streetname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $streetNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="sender", orphanRemoval=true)
     */
    private $SentMessages;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="Reciever", orphanRemoval=true)
     */
    private $RecievedMessages;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="Customer")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=Quotation::class, mappedBy="Customer")
     */
    private $quotations;

    /**
     * @ORM\OneToMany(targetEntity=Request::class, mappedBy="customer")
     */
    private $requests;

    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     */
    private $Profile_picture;

    public function __construct()
    {
        $this->SentMessages = new ArrayCollection();
        $this->RecievedMessages = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->quotations = new ArrayCollection();
        $this->requests = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'email' =>$this->getEmail(),
            'firstname' =>$this->getFirstname(),
            'familyname' =>$this->getName(),
            'adresse' => [
                'street_number' =>$this->getStreetNumber(),
                'street_name' =>$this->getStreetname(),
                'postal_code' =>$this->getPostalCode(),
                'city' =>$this->getCity(),
            ],
            'phone_number'=>$this->getPhoneNumber(),
            'store' =>$this->getStore()->toArray()

        ];
    }

    public function getStore(): ?Store
    {
        return $this->Store;
    }

    public function setStore(?Store $Store): self
    {
        // unset the owning side of the relation if necessary
        if ($Store === null && $this->Store !== null) {
            $this->Store->setOwner(null);
        }

        // set the owning side of the relation if necessary
        if ($Store !== null && $Store->getOwner() !== $this) {
            $Store->setOwner($this);
        }

        $this->Store = $Store;

        return $this;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getStreetname(): ?string
    {
        return $this->streetname;
    }

    public function setStreetname(?string $streetname): self
    {
        $this->streetname = $streetname;

        return $this;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): self
    {
        $this->postalCode = $postalCode;

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

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getSentMessages(): Collection
    {
        return $this->SentMessages;
    }

    public function addSentMessage(Message $sentMessage): self
    {
        if (!$this->SentMessages->contains($sentMessage)) {
            $this->SentMessages[] = $sentMessage;
            $sentMessage->setSender($this);
        }

        return $this;
    }

    public function removeSentMessage(Message $sentMessage): self
    {
        if ($this->SentMessages->removeElement($sentMessage)) {
            // set the owning side to null (unless already changed)
            if ($sentMessage->getSender() === $this) {
                $sentMessage->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getRecievedMessages(): Collection
    {
        return $this->RecievedMessages;
    }

    public function addRecievedMessage(Message $recievedMessage): self
    {
        if (!$this->RecievedMessages->contains($recievedMessage)) {
            $this->RecievedMessages[] = $recievedMessage;
            $recievedMessage->setReciever($this);
        }

        return $this;
    }

    public function removeRecievedMessage(Message $recievedMessage): self
    {
        if ($this->RecievedMessages->removeElement($recievedMessage)) {
            // set the owning side to null (unless already changed)
            if ($recievedMessage->getReciever() === $this) {
                $recievedMessage->setReciever(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Quotation[]
     */
    public function getQuotations(): Collection
    {
        return $this->quotations;
    }

    public function addQuotation(Quotation $quotation): self
    {
        if (!$this->quotations->contains($quotation)) {
            $this->quotations[] = $quotation;
            $quotation->setCustomer($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): self
    {
        if ($this->quotations->removeElement($quotation)) {
            // set the owning side to null (unless already changed)
            if ($quotation->getCustomer() === $this) {
                $quotation->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Request[]
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests[] = $request;
            $request->setCustomer($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getCustomer() === $this) {
                $request->setCustomer(null);
            }
        }

        return $this;
    }

    public function getProfilePicture(): ?Picture
    {
        return $this->Profile_picture;
    }

    public function setProfilePicture(?Picture $Profile_picture): self
    {
        $this->Profile_picture = $Profile_picture;

        return $this;
    }
}
