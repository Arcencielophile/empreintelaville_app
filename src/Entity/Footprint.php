<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 */
class Footprint
{
    /**
     * @var int The entity Id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The footprint name
     *
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @var string The footprint description
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string The country name
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    protected $country;

    /**
     * @var string The city name
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    protected $city;

    /**
     * @var string The zip code
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    protected $zipCode;

    /**
     * @var string The address
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    protected $address;

    /**
     * @var decimal The footprint latitude location
     *
     * @ORM\Column(type="decimal", scale=8, nullable=true)
     */
    protected $latitude;

    /**
     * @var decimal The footpring longitude location
     *
     * @ORM\Column(type="decimal", scale=8, nullable=true)
     */
    protected $longitude;

    /**
     * @var \DateTimeInterface The footprint creation date
     *
     * @ORM\Column(type="datetime_immutable")
     */
    protected $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="Thing", inversedBy="footprints")
     * @ORM\JoinTable(name="footprint_thing")
     */
    protected $things;

    /**
     * @ORM\ManyToOne(targetEntity="FootprintMethod", inversedBy="footprints")
     */
    protected $method;

    /**
     * @ORM\OneToMany(targetEntity="FootprintMedia", mappedBy="footprint", cascade={"persist"})
     */
    protected $media;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->things = new \Doctrine\Common\Collections\ArrayCollection();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Footprint
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Footprint
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return Footprint
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return Footprint
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipCode.
     *
     * @param string $zipCode
     *
     * @return Footprint
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode.
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set address.
     *
     * @param string $address
     *
     * @return Footprint
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set latitude.
     *
     * @param string $latitude
     *
     * @return Footprint
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param string $longitude
     *
     * @return Footprint
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set createdAt.
     *
     * @param datetime_immutable $createdAt
     *
     * @return Footprint
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return datetime_immutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add thing.
     *
     * @param \App\Entity\Thing $thing
     *
     * @return Footprint
     */
    public function addThing(\App\Entity\Thing $thing)
    {
        $this->things[] = $thing;

        return $this;
    }

    /**
     * Remove thing.
     *
     * @param \App\Entity\Thing $thing
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeThing(\App\Entity\Thing $thing)
    {
        return $this->things->removeElement($thing);
    }

    /**
     * Get things.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThings()
    {
        return $this->things;
    }

    /**
     * Set method.
     *
     * @param \App\Entity\FootprintMethod|null $method
     *
     * @return Footprint
     */
    public function setMethod(\App\Entity\FootprintMethod $method = null)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method.
     *
     * @return \App\Entity\FootprintMethod|null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Add medium.
     *
     * @param \App\Entity\FootprintMedia $medium
     *
     * @return Footprint
     */
    public function addMedia(\App\Entity\FootprintMedia $medium)
    {
        $this->media[] = $medium;

        return $this;
    }

    /**
     * Remove medium.
     *
     * @param \App\Entity\FootprintMedia $medium
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMedia(\App\Entity\FootprintMedia $medium)
    {
        return $this->media->removeElement($medium);
    }

    /**
     * Get media.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedia()
    {
        return $this->media;
    }
}
