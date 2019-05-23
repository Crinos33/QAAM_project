<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SurveyRepository")
 */
class Survey
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ownFood;

    /**
     * @ORM\Column(type="integer")
     */
    private $procurementType_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $restaurant_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnFood(): ?bool
    {
        return $this->ownFood;
    }

    public function setOwnFood(bool $ownFood): self
    {
        $this->ownFood = $ownFood;

        return $this;
    }

    public function getProcurementTypeId(): ?int
    {
        return $this->procurementType_id;
    }

    public function setProcurementTypeId(int $procurementType_id): self
    {
        $this->procurementType_id = $procurementType_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getRestaurantId(): ?int
    {
        return $this->restaurant_id;
    }

    public function setRestaurantId(int $restaurant_id): self
    {
        $this->restaurant_id = $restaurant_id;

        return $this;
    }
}
