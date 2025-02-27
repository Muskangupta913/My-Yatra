<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Models\CarCity;
use Illuminate\Support\Facades\Log;

class CarApiService
{
    protected $baseUrl;
    protected $apiToken;
    protected $clientId;
    protected $username;
    protected $password;
}

