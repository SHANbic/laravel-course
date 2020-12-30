<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomePageIsDisplayingText()
    {
        $response = $this->get('/');

        $response->assertSeeText('Hell of a World');
    }

    public function testContactPageIsDisplayingText()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('contact page');
    }
}
