<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class DateTimeRule extends Rule
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected ?DateTime $startDateTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected ?DateTime $endDateTime = null;

    public function getStartDateTime(): ?DateTime
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(?DateTime $startDateTime): static
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): ?DateTime
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?DateTime $endDateTime): static
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }
}