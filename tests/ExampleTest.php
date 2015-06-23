<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */

    protected $baseUrl = "http://dev.eusalud-5.1/";

    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Nuestras Clínicas');
    }
}
