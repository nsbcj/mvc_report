<?php

namespace App\Card;

class Card
{
    protected $type;
    protected $value;

    public function __construct()
    {
        $this->type = null;
        $this->value = null;
    }

    public function setCard(
        string $type,
        int $value,
    ): void {
        $this->type = $type;
        $this->value = $value;
    }

    public function getCard(): object
    {
        return [
            "type" => $this->type,
            "value" => $this->value
        ];
    }
}
