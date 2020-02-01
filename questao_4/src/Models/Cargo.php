<?php

namespace Wjjunior\FlightTicket\Models;

use Wjjunior\FlightTicket\Models\CargoInterface;

class Cargo implements CargoInterface
{

    private $id;
    private $description;
    private $price;
    private $weight;
    private $type;

    public function __construct(string $description, float $price, float $weight, string $type)
    {
        $this->id = uniqid();
        $this->description = $description;
        $this->price = $price;
        $this->weight = $weight;
        $this->weight = $weight;
        $this->type = $type;
    }

    /**
     * Get the value of id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(string $id): Cargo
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description): Cargo
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice(float $price): Cargo
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of weight
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * Set the value of weight
     *
     * @return  self
     */
    public function setWeight(float $weight): Cargo
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType(string $type): Cargo
    {
        $this->type = $type;

        return $this;
    }
}
