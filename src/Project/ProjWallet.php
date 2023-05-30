<?php

namespace App\Project;

class ProjWallet
{
    public int $balance;

    /**
     * method constructing ProjWallet object
     */
    public function __construct()
    {
        $this->balance = 0;
    }

    /**
     * method setting balance
     */
    public function setBalance(int $amount): void
    {
        $this->balance = $amount;

    }

    /**
     * method adding balance to balance
     */
    public function addBalance(int $amount): void
    {
        $this->balance = $this->balance + $amount;

    }

    /**
     * method withdrawing balance from balance
     */
    public function withdrawBalance(int $amount): void
    {
        $this->balance = $this->balance - $amount;

    }

    /**
     * method getting balance
     */
    public function getBalance(): int
    {
        return $this->balance;
    }
}
