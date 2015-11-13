<?php

namespace Wilson\tests;

use Mockery;
use Wilson\Source\Base;
use PHPUnit_Framework_TestCase;
use Wilson\Source\Examples\User;

class BaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that the right table name can be constructed from the class name
     */
    public function testGetTableName()
    {
        $table = User::getTableName();

        $this->assertEquals("users", $table);
    }

    /**
     * Test that the find() method can actually find a record in the database
     */
    public function testFind()
    {
        $mock = Mockery::mock('Wilson\Source\Examples\User');
        $mock->shouldReceive('find')->with(1)->andReturn(new static);
    }

    /**
     * Test that the save() method can actually save or update a record in the database table
     */
    public function testSave()
    {
        $mock = Mockery::mock('Wilson\Source\Examples\User');
        $mock->shouldReceive('save')->once()->andReturn('1');
    }

    /**
     * Test that the correct update SQL can be dynamically generated when updating a record
     */
    public function testMakeUpdateSQL()
    {
        $user = new User();
        $user->id = "1";
        $user->name = "Nick Gray";

        $expected = "UPDATE users SET name = 'Nick Gray' WHERE id = 1";
        $actual = $user->makeUpdateSQL();

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test that the destroy() method can actually delete a record from the database table
     */
    public function testDestroy()
    {
        $mock = Mockery::mock('Wilson\Source\Examples\User');
        $mock->shouldReceive('save')->once()->with('1')->andReturn('1');
    }
}