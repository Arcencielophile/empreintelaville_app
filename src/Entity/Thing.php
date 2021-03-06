<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 */
class Thing
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
     * @var string The thing name
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Footprint", mappedBy="things")
     */
    protected $footprints;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->footprints = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * To string
     */
    public function __toString()
    {
        return $this->getName();
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
     * Set name.
     *
     * @param string $name
     *
     * @return Thing
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add footprint.
     *
     * @param \App\Entity\Thing $footprint
     *
     * @return Thing
     */
    public function addFootprint(\App\Entity\Thing $footprint)
    {
        $this->footprints[] = $footprint;

        return $this;
    }

    /**
     * Remove footprint.
     *
     * @param \App\Entity\Thing $footprint
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFootprint(\App\Entity\Thing $footprint)
    {
        return $this->footprints->removeElement($footprint);
    }

    /**
     * Get footprints.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFootprints()
    {
        return $this->footprints;
    }
}
