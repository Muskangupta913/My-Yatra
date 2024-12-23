<?php


namespace App\Http\Controllers;

use App\Services\BusApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BusController extends Controller
{
    protected $busApiService;

    public function __construct(BusApiService $busApiService)
    {
        $this->busApiService = $busApiService;
    }

    public function index()
    {
        return view('bus');
    }

    public function showSeatLayout(Request $request)
    {
        return view('seat-layout');
    }

    public function searchBuses(Request $request)
    {
        $request->validate([
            'source_city' => 'required|string',
            'source_code' => 'required|string',
            'destination_city' => 'required|string',
            'destination_code' => 'required|string',
            'depart_date' => 'required|date_format:Y-m-d',
        ]);

        $payload = json_encode([
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910",
            'source_city' => trim($request->source_city),
            'source_code' => (int) trim($request->source_code),
            'destination_city' => trim($request->destination_city),
            'destination_code' => (int) trim($request->destination_code),
            'depart_date' => Carbon::createFromFormat('Y-m-d', $request->depart_date)->format('Y-m-d'),
        ], JSON_UNESCAPED_SLASHES);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',
            ])->withBody($payload, 'application/json')
              ->post('https://bus.srdvtest.com/v5/rest/Search');

            $data = $response->json();

            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage'] ?? 'An unknown error occurred'
                ]);
            }

            $traceId = $data['Result']['TraceId'] ?? $data['TraceId'] ?? null;

            if (!empty($data['Result']['BusResults'])) {
                return response()->json([
                    'status' => true,
                    'traceId' => $traceId,
                    'data' => $data['Result']['BusResults'],
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'No buses found for the selected route and date.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while searching for buses.'
            ], 500);
        }
    }

    public function getSeatLayout(Request $request)
    {
        $request->validate([
            'TraceId' => 'required|string',
            'ResultIndex' => 'required|string',
        ]);

        $payload = json_encode([
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910",
            "TraceId" => $request->TraceId,
            "ResultIndex" => $request->ResultIndex,
        ], JSON_UNESCAPED_SLASHES);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',
            ])->withBody($payload, 'application/json')
              ->post('https://bus.srdvtest.com/v5/rest/GetSeatLayOut');

            $data = $response->json();

            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage'] ?? 'Error fetching seat layout',
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => $data['Result'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching seat layout.',
            ], 500);
        }
    }
}
