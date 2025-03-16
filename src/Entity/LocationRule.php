<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class LocationRule extends Rule
{
    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    protected ?float $latitude = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    protected ?float $longitude = null;

    /**
     * Радиус в километрах
     */
    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    protected ?float $radius = null;

    #[ORM\ManyToMany(targetEntity: Country::class)]
    #[ORM\JoinTable(name: 'app_location_rule_country')]
    private Collection $countries;

    #[ORM\ManyToMany(targetEntity: Region::class)]
    #[ORM\JoinTable(name: 'app_location_rule_region')]
    private Collection $regions;

    #[ORM\ManyToMany(targetEntity: City::class)]
    #[ORM\JoinTable(name: 'app_location_rule_city')]
    private Collection $cities;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
        $this->regions = new ArrayCollection();
        $this->cities = new ArrayCollection();
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getRadius(): ?float
    {
        return $this->radius;
    }

    public function setRadius(?float $radius): static
    {
        $this->radius = $radius;

        return $this;
    }

    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function addCountry(Country $country): static
    {
        if (!$this->countries->contains($country)) {
            $this->countries->add($country);
        }
        return $this;
    }

    public function removeCountry(Country $country): static
    {
        if ($this->countries->contains($country)) {
            $this->countries->removeElement($country);
        }
        return $this;
    }

    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): static
    {
        if (!$this->regions->contains($region)) {
            $this->regions->add($region);
        }
        return $this;
    }

    public function removeRegion(Region $region): static
    {
        if ($this->regions->contains($region)) {
            $this->regions->removeElement($region);
        }
        return $this;
    }

    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): static
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
        }
        return $this;
    }

    public function removeCity(City $city): static
    {
        if ($this->cities->contains($city)) {
            $this->cities->removeElement($city);
        }
        return $this;
    }
}