<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SendMediaController extends Controller
{

    protected $apiUrl;
    protected $accessToken;
    protected $instanceId;

    public function __construct()
    {
        $this->apiUrl = env('WHATSAPP_API_URL');
        $this->accessToken = env('WHATSAPP_ACCESS_TOKEN');
        $this->instanceId = env('WHATSAPP_INSTANCE_ID');
    }

    public function index()
    {
            Http::timeout(60)->post("{$this->apiUrl}/send", [
            'number' => '18653216348',
            'type' => 'text',
            'message' => 'from me ',
            'media_url' => 'https://dl1s.co/writable/uploads/1702308215_b295fe81df451a520c0d.png',
            'instance_id' => $this->instanceId,
            'access_token' => $this->accessToken,

        ]);


        return response()->json(['message' => 'okay ! :)'], 200);

    }
}
