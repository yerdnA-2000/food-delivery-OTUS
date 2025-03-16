<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TimeRule extends Rule
{
    #[ORM\Column(type: Types::TIME_MUTABLE)]
    protected ?DateTime $startTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?DateTime $endTime = null;

    public function getStartTime(): ?DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(?DateTime $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?DateTime
    {
        return $this->endTime;
    }

    public function setEndTime(?DateTime $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }
}