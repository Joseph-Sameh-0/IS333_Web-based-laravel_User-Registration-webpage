<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller{

    private array $apiKeys;

    public function __construct()
    {
        $this->apiKeys = $this->getApiKeys();
    }

    private function getApiKeys()
    {
        $keys = env('WHATSAPP_API_KEYS');

        if (empty($keys)) {
            return [];
        }

        return array_map('trim', explode(',', $keys));
    }

    public function check(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string'
        ]);

        $phoneNumber = $request->input('phone_number');


        foreach ($this->apiKeys as $key) {
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'X-RapidAPI-Key' => $key,
                    'X-RapidAPI-Host' => 'whatsapp-number-validator3.p.rapidapi.com',
                ])->post('https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItWithToken', [
                    'phone_number' => $phoneNumber
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return response()->json([
                        'status' => $data['status'] ?? 'unknown'
                    ]);
                }

            } catch (\Exception $e) {
                continue;
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'All API keys exhausted or failed.'
        ], 500);
    }
}
