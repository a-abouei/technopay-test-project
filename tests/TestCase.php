<?php

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;
use Mockery\MockInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;


//    public function setUp(): void
//    {
//        parent::setUp();
//
//        $this->seed();
//    }

    /**
     * HELPER
     *
     * @param $class
     * @param $method
     * @param null $expectedReturn
     * @param null $expectedException
     * @return void
     */
    protected function mockClass($class, $method, $expectedReturn = null, $expectedException = null): void
    {
        if (isset($expectedException)){
            $this->instance(
                $class,
                Mockery::mock($class, function (MockInterface $mock) use ($expectedException, $method) {
                    $mock->shouldReceive($method)
                        ->once()
                        ->andThrow($expectedException);
                })
            );
        }
        if (isset($expectedReturn)){
            $this->instance(
                $class,
                Mockery::mock($class, function (MockInterface $mock) use ($expectedReturn, $method) {
                    $mock->shouldReceive($method)
                        ->once()
                        ->andReturn($expectedReturn);
                })
            );
        }
    }
}
