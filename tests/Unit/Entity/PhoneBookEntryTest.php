<?php

namespace App\Tests\Unit\Entity;

use App\Entity\PhoneBookEntry;
use PHPUnit\Framework\TestCase;

class PhoneBookEntryTest extends TestCase
{
    /**
     * @test
     */
    public function TestThatWeCanGetName()
    {
        $phoneBookEntry = new PhoneBookEntry();

        $phoneBookEntry->setName('Bob');

        $this->assertEquals($phoneBookEntry->getName(), 'Bob');
    }

    /**
     * @test
     */
    public function TestThatWeCanGetPhoneNumber()
    {
        $phoneBookEntry = new PhoneBookEntry();

        $phoneBookEntry->setPhoneNumber('86313155465');

        $this->assertEquals($phoneBookEntry->getPhoneNumber(), '86313155465');
    }

}