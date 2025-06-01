<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WhatsAppValidationTest extends TestCase {
    public function test_return_valid_for_valid_whatsapp() : void {

        $response = $this->postJson('/check-whatsapp',['phone_number'=> '+201205563356']);
        $response->assertStatus(200);
    }

}

