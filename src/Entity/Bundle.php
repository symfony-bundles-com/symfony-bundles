<?php

namespace App\Entity;

class Bundle
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $package;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPackage(): string
    {
        return $this->package;
    }

    /**
     * @param string $package
     */
    public function setPackage(string $package)
    {
        $this->package = $package;
    }
}