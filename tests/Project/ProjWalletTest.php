<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class in ProjPlayer.
 */
class ProjWalletTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateProjGameNoArguments()
    {
        $wallet = new ProjWallet();
        $this->assertInstanceOf("\App\Project\ProjWallet", $wallet);
    }

    /**
     * Test set balance
     */
    public function testSetAndGetBalanceProjWallet()
    {
        $wallet = new ProjWallet();
        $wallet->setBalance(100);

        $this->assertEquals(100, $wallet->getBalance());
    }

    /**
     * Test set and withdraw balance
     */
    public function testSetAndWithdrawBalanceProjWallet()
    {
        $wallet = new ProjWallet();
        $wallet->setBalance(100);

        $wallet->withdrawBalance(10);

        $this->assertEquals(90, $wallet->getBalance());
    }

    /**
     * Test set and add balance
     */
    public function testSetAndAddBalanceProjWallet()
    {
        $wallet = new ProjWallet();
        $wallet->setBalance(100);

        $wallet->addBalance(10);

        $this->assertEquals(110, $wallet->getBalance());
    }
}
