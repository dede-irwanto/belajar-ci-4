<?php

namespace App\Database;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class MyTests extends CIUnitTestCase
{
        use DatabaseTestTrait;

        public function setUp(): void
        {
                parent::setUp();
        }

        public function tearDown(): void
        {
                parent::tearDown();
        }

        public function testLihatData()
        {
                $criteria = [
                        'name'  => 'dede',
                ];
                $this->assert$this->seeInDatabase("factories", $criteria);
        }
}
