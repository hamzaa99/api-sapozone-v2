<?php

namespace App\Entity;

use App\Repository\QuotationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuotationRepository::class)
 */
class Quotation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="quotations")
     */
    private $Customer;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="quotations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Store;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $detail;

    /**
     * @ORM\Column(type="integer")
     */
    private $leadtime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?User
    {
        return $this->Customer;
    }

    public function setCustomer(?User $Customer): self
    {
        $this->Customer = $Customer;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->Store;
    }

    public function setStore(?Store $Store): self
    {
        $this->Store = $Store;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getLeadtime(): ?int
    {
        return $this->leadtime;
    }

    public function setLeadtime(int $leadtime): self
    {
        $this->leadtime = $leadtime;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
