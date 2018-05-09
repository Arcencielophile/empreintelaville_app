<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Footprint
{
    private $id;

    protected $title;

    protected $description;

    protected $country;

    protected $city;

    protected $zipCode;

    protected $address;

    protected $latitude;

    protected $longitude;

    protected $createdAt;

    protected $things;

    protected $method;

    protected $media;

    public function __construct()
    {
        $this->things = new \Doctrine\Common\Collections\ArrayCollection();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function addThing(\App\Entity\Thing $thing): self
    {
        $this->things[] = $thing;

        return $this;
    }

    public function removeThing(\App\Entity\Thing $thing): boolean
    {
        return $this->things->removeElement($thing);
    }

    public function getThings()
    {
        return $this->things;
    }

    public function setMethod(\App\Entity\FootprintMethod $method = null): self
    {
        $this->method = $method;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function addMedia(\App\Entity\FootprintMedia $medium): self
    {
        $this->media[] = $medium;

        return $this;
    }

    public function removeMedia(\App\Entity\FootprintMedia $medium): boolean
    {
        return $this->media->removeElement($medium);
    }

    public function getMedia()
    {
        return $this->media;
    }
}
