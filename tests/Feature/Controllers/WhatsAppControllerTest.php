<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\WhatsAppController;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class WhatsAppControllerTest extends TestCase
{
    public function test_returns_validation_error_if_phone_number_is_missing()
    {
        $request = Request::create('/check', 'POST', []);

        $controller = new WhatsAppController();

        try {
            $controller->check($request);

            // If no exception is thrown, fail the test
            $this->fail('ValidationException expected');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Get the validator instance
            $validator = $e->validator;

            // Check that 'phone_number' is among the failed rules
            $this->assertArrayHasKey('phone_number', $validator->failed());

            // Optional: Check the actual error message
            $messages = $validator->errors()->messages();
            $this->assertArrayHasKey('phone_number', $messages);
        }
    }


    public function test_returns_valid_status_when_api_returns_valid()
    {
        // Fake HTTP response
        Http::fake([
            '*' => Http::response(['status' => 'valid'], 200),
        ]);

        $request = Request::create('/check', 'POST', [
            'phone_number' => '+201205563356'
        ]);

        $controller = new WhatsAppController();

        $response = $controller->check($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['status' => 'valid'], $response->getData(true));
    }


    public function test_returns_invalid_status_when_api_returns_invalid()
    {
        // Fake HTTP response
        Http::fake([
            '*' => Http::response(['status' => 'invalid'], 200),
        ]);

        $request = Request::create('/check', 'POST', [
            'phone_number' => '+20128347789'
        ]);

        $controller = new WhatsAppController();

        $response = $controller->check($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['status' => 'invalid'], $response->getData(true));
    }


    public function test_returns_error_status_when_all_apis_fail()
    {
        // Fake all API calls to fail
        Http::fake([
            '*' => Http::response('Server Error', 500),
        ]);

        $request = Request::create('/check', 'POST', [
            'phone_number' => '+20123456789'
        ]);

        $controller = new WhatsAppController();

        $response = $controller->check($request);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals([
            'status' => 'error',
            'message' => 'All API keys exhausted or failed.'
        ], $response->getData(true));
    }
}
