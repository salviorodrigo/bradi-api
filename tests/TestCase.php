<?php

namespace BradiNfeApi\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Shared test subject used by Pest closures (e.g. $this->sut).
     */
    public mixed $sut;
}
