<?php

namespace App\Entity;

class Security
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $isActive;

    /**
     * @var Enclosure
     */
    private $enclosure;

    public function __construct(string $name, bool $isActive, Enclosure $enclosure)
    {

        $this->name = $name;
        $this->isActive = $isActive;
        $this->enclosure = $enclosure;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }
}
