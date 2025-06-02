<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WhatsAppValidationTest extends TestCase {

    public function test_return_valid_for_a_valid_whatsapp_number() : void {

        $response = $this->postJson('/check-whatsapp',['phone_number'=> '+201205563356']);

        $response->assertStatus(200);
    }

    public function test_it_returns_error_for_missing_phone_number() : void {

        $response = $this->postJson('/check-whatsapp', []);

        $response->assertStatus(422); // laravel returns 422 for validation errors!
        $response->assertJsonValidationErrors('phone_number');
    }
    
    public function test_return_invalid_for_an_invalid_whatsapp_number() : void {

        $response = $this->postJson('/check-whatsapp',['phone_number'=> '+20128347789']);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'invalid' ]);
    }

}

