<?php

namespace App\Card;

class Card
{
    protected string|null $type;
    protected int|null $value;

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

    /**
     * @return array<string,int|string|null>
     */
    public function getCard(): array
    {
        $res = [];

        $res = [
            "type" => $this->type,
            "value" => $this->value
        ];

        return $res;
    }

    public function getCardValue(): ?int
    {
        return $this->value;
    }
}
