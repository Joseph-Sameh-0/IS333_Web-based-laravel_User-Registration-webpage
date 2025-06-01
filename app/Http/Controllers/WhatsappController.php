<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller{
    
    private $apiKeys = [
        "a6a34bf089mshda317112704a8adp1cd899jsnea75dc0992e4",
        "bd4af4fed3msh5cce71bee29321bp143febjsn8784978f97b7",
        "ac473eab33mshb82011782bcc4aap15c9b3jsn3a63b12de4df",
        "78718d2a7dmsh7dcfbae259c0f70p1df2dfjsndeea78167fcf",
        "7934d542a9msh1d255f41af26346p13e040jsn517da03aedf4",
        "2dcec1e78bmsh0528a4942ec9f47p164759jsn8702f3508936",
        "af6cb4360amsh9d91a988e4f7df2p11513djsn844b31521070",
        "f3f7834093mshfff0341a646e910p114b1cjsnb3709cf7e570",
    ];

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