<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isArestaurant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAshop;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restauration")
     */
    private $restauration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Delivery")
     * @ORM\JoinColumn(nullable=false)
     */
    private $delivery;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Survey", mappedBy="restaurant")
     */
    private $surveys;

    public function __construct()
    {
        $this->surveys = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

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

    public function getIsashop(): ?bool
    {
        return $this->isAshop;
    }

    public function setIsashop(bool $isAshop): self
    {
        $this->isAshop = $isAshop;

        return $this;
    }

    public function getIsArestaurant(): ?bool
    {
        return $this->isArestaurant;
    }

    public function setIsArestaurant(bool $isArestaurant): self
    {
        $this->isArestaurant = $isArestaurant;

        return $this;
    }

    public function getRestauration(): ?Restauration
    {
        return $this->restauration;
    }

    public function setRestauration(?Restauration $restauration): self
    {
        $this->restauration = $restauration;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return Collection|Survey[]
     */
    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    public function addSurvey(Survey $survey): self
    {
        if (!$this->surveys->contains($survey)) {
            $this->surveys[] = $survey;
            $survey->setRestaurant($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): self
    {
        if ($this->surveys->contains($survey)) {
            $this->surveys->removeElement($survey);
            // set the owning side to null (unless already changed)
            if ($survey->getRestaurant() === $this) {
                $survey->setRestaurant(null);
            }
        }

        return $this;
    }
}
