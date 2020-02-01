<?php

namespace Wjjunior\FlightTicket\Models;

interface CargoInterface
{
    public function getId(): string;
    public function setId(string $id): Cargo;
    public function getDescription(): string;
    public function setDescription($description): Cargo;
    public function getPrice(): float;
    public function setPrice(float $price): Cargo;
    public function getWeight(): float;
    public function setWeight(float $weight): Cargo;
    public function getType(): string;
    public function setType(string $type): Cargo;
}
