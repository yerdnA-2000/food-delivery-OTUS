<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: self::TABLE_NAME)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: Types::STRING)]
#[ORM\DiscriminatorMap([
    'time' => TimeRule::class,
    'date_time' => DateTimeRule::class,
    'location' => LocationRule::class,
    'device' => DeviceRule::class,
])]
abstract class Rule
{
    public const TABLE_NAME = 'app_rule';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id = null;

    #[ORM\ManyToOne(targetEntity: RedirectRule::class, inversedBy: 'rules')]
    #[ORM\JoinColumn(name: 'redirectRule', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    protected ?RedirectRule $redirectRule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRedirectRule(): ?RedirectRule
    {
        return $this->redirectRule;
    }

    public function setRedirectRule(?RedirectRule $redirectRule): static
    {
        $this->redirectRule = $redirectRule;

        return $this;
    }
}