<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class Request
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="requests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="requests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Store;

    /**
     * @ORM\Column(type="text")
     */
    private $Detail;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $max_price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $max_lead_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

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

    public function getDetail(): ?string
    {
        return $this->Detail;
    }

    public function setDetail(string $Detail): self
    {
        $this->Detail = $Detail;

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->max_price;
    }

    public function setMaxPrice(?int $max_price): self
    {
        $this->max_price = $max_price;

        return $this;
    }

    public function getMaxLeadTime(): ?int
    {
        return $this->max_lead_time;
    }

    public function setMaxLeadTime(?int $max_lead_time): self
    {
        $this->max_lead_time = $max_lead_time;

        return $this;
    }
}
