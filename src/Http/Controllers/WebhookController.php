<?php

namespace Ibraheem\DhlEcommerceIntegration\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ibraheem\DhlEcommerceIntegration\Contracts\DhlWebhookInterface;
use Ibraheem\DhlEcommerceIntegration\Support\Logger;

class WebhookController extends Controller
{
    public function handle(Request $request, DhlWebhookInterface $service)
    {
        $signature = $request->header('X-DHL-Signature');
        $payload = $request->getContent();

        if (!$signature || !$service->verifySignature($payload, $signature)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = json_decode($payload, true);
        $service->handle($data);

        return response()->json(['status' => 'received']);
    }
}
