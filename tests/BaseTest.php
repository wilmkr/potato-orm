<?php

namespace Wilson\tests;

use Mockery;
use Wilson\Source\Base;
use PHPUnit_Framework_TestCase;
use Wilson\Source\Examples\User;

class BaseTest extends PHPUnit_Framework_TestCase
{
    public function testGetTableName()
    {
        $table = User::getTableName();

        $this->assertEquals("users", $table);
    }

    public function testFind()
    {
        $mock = Mockery::mock('Wilson\Source\Examples\User');
        $mock->shouldReceive('find')->with(1)->andReturn(new static);
    }

    public function testSave()
    {
        $mock = Mockery::mock('Wilson\Source\Examples\User');
        $mock->shouldReceive('save')->once()->andReturn('1');
    }

    public function testMakeUpdateSQL()
    {
        $user = new User();
        $user->id = "1";
        $user->name = "Nick Gray";

        $expected = "UPDATE users SET name = 'Nick Gray' WHERE id = 1";
        $actual = $user->makeUpdateSQL();

        $this->assertEquals($expected, $actual);
    }

    public function testDestroy()
    {
        $mock = Mockery::mock('Wilson\Source\Examples\User');
        $mock->shouldReceive('save')->once()->with('1')->andReturn('1');
    }
}