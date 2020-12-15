<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StoreRepository::class)
 */
class Store
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="Store", cascade={"persist", "remove"})
     */
    private $Owner;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone_number;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="Store", orphanRemoval=true)
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=Quotation::class, mappedBy="Store", orphanRemoval=true)
     */
    private $quotations;

    /**
     * @ORM\OneToMany(targetEntity=Request::class, mappedBy="Store", orphanRemoval=true)
     */
    private $requests;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="Store")
     */
    private $Pictures;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $StreetNUMBER;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->quotations = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->Pictures = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->Owner;
    }

    public function setOwner(?User $Owner): self
    {
        $this->Owner = $Owner;

        return $this;
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

    public function getStreetName(): ?string
    {
        return $this->street_name;
    }

    public function setStreetName(string $street_name): self
    {
        $this->street_name = $street_name;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
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
        return $this->phone_number;
    }

    public function setPhoneNumber(int $phone_number): self
    {
        $this->phone_number = $phone_number;

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
            $quotation->setStore($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): self
    {
        if ($this->quotations->removeElement($quotation)) {
            // set the owning side to null (unless already changed)
            if ($quotation->getStore() === $this) {
                $quotation->setStore(null);
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
            $request->setStore($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getStore() === $this) {
                $request->setStore(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->Pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->Pictures->contains($picture)) {
            $this->Pictures[] = $picture;
            $picture->setStore($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->Pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getStore() === $this) {
                $picture->setStore(null);
            }
        }

        return $this;
    }

    public function getStreetNUMBER(): ?int
    {
        return $this->StreetNUMBER;
    }

    public function setStreetNUMBER(int $StreetNUMBER): self
    {
        $this->StreetNUMBER = $StreetNUMBER;

        return $this;
    }

    public function toArray() : Array{
        return [
            'name'=>$this.$this->getName()

        ];
    }

    
}
