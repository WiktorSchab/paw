<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $geo_width = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $geo_lenght = null;

    /**
     * @var Collection<int, Forecast>
     */
    #[ORM\OneToMany(targetEntity: Forecast::class, mappedBy: 'location')]
    private Collection $forecasts;

    public function __construct()
    {
        $this->forecasts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getGeoWidth(): ?string
    {
        return $this->geo_width;
    }

    public function setGeoWidth(string $geo_width): static
    {
        $this->geo_width = $geo_width;

        return $this;
    }

    public function getGeoLenght(): ?string
    {
        return $this->geo_lenght;
    }

    public function setGeoLenght(string $geo_lenght): static
    {
        $this->geo_lenght = $geo_lenght;

        return $this;
    }

    /**
     * @return Collection<int, Forecast>
     */
    public function getForecasts(): Collection
    {
        return $this->forecasts;
    }

    public function addForecast(Forecast $forecast): static
    {
        if (!$this->forecasts->contains($forecast)) {
            $this->forecasts->add($forecast);
            $forecast->setLocation($this);
        }

        return $this;
    }

    public function removeForecast(Forecast $forecast): static
    {
        if ($this->forecasts->removeElement($forecast)) {
            // set the owning side to null (unless already changed)
            if ($forecast->getLocation() === $this) {
                $forecast->setLocation(null);
            }
        }

        return $this;
    }
}
