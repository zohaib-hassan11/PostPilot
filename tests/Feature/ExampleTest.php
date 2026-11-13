<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_home_redirects_to_the_dashboard(): void
    {
        // "/" is not a page in this app: it sends you to the Mixpost dashboard (login first if needed).
        $this->get('/')->assertRedirect('/mixpost');
    }
}
