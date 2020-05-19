<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_application_is_online()
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_create_empty_pdv_collection()
    {
        $this->assertDatabaseMissing('pdvs', [
            'trandingName' => 'ze'
        ]);
    }


}
