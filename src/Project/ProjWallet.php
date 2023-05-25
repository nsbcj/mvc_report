<?php

namespace App\Project;

class ProjWallet
{
    public int $balance;

    public function __construct()
    {
        $this->balance = 0;
    }

    public function setBalance(int $amount): void
    {
        $this->balance = $this->balance + $amount;

    }

    public function withdrawBalance(int $amount): void
    {
        $this->balance = $this->balance - $amount;

    }

    public function getBalance(): int
    {
        return $this->balance;
    }
}
