<?php

namespace Wilson\tests;

use Mockery;
use stdClass;
use Wilson\Source\Base;
use Wilson\Source\Stubs\Car;
use Wilson\Source\Stubs\User;
use PHPUnit_Framework_TestCase;

class BaseTest extends PHPUnit_Framework_TestCase
{
    public $userMock;

    public function setUp()
    {
        $this->userMock = Mockery::mock('Wilson\Source\Stubs\User');
    }

    public function tearDown()
    {
        Mockery::close();
    }

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
        $object = Mockery::mock('Wilson\Source\Stubs\User');

        $object->id = 1;
        $object->result = [
            "id" => 1,
            "name" => "Don Simon",
            "email" => "don.simon@yahoo.com",
            "password" => "12345"
        ];

        $this->userMock->shouldReceive('find')->with(1)->andReturn($object);

        $this->assertEquals($object, $this->userMock->find(1));
    }

    /**
     * Test that the save() method can actually save or update a record in the database table
     */
    public function testSave()
    {
        $this->userMock->name = "Wilson Omokoro";
        $this->userMock->email = "baba@bbv.com";
        $this->userMock->password = "12345";

        $this->userMock->shouldReceive('save')->andReturn(1);

        $this->assertEquals(1, $this->userMock->save());
    }

    /**
     * Test that the correct update SQL can be dynamically generated when updating a record
     */
    public function testMakeUpdateSQL()
    {
        $query = "UPDATE users SET name = 'Nick Gray' WHERE id = 1";

        $this->userMock->id = "1";
        $this->userMock->name = "Nick Gray";

        $this->userMock->shouldReceive('makeUpdateSQL')->andReturn($query);

        $this->assertEquals($query, $this->userMock->makeUpdateSQL());
    }

    /**
     * Test that the destroy() method can actually delete a record from the database table
     */
    public function testDestroy()
    {
        $this->userMock->id = "1";

        $this->userMock->shouldReceive('destroy')->andReturn(1);

        $this->assertEquals(1, $this->userMock->destroy(1));
    }
}