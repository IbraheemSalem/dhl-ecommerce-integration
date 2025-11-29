<?php

namespace Ibraheem\DhlEcommerceIntegration\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Ibraheem\DhlEcommerceIntegration\Domain\Entities\Merchant;

class AdminController extends Controller
{
    public function index()
    {
        return view('dhl::admin.index');
    }

    public function settings()
    {
        return view('dhl::admin.settings', [
            'config' => [
                'account' => config('dhl.account_number'),
                'webhook_secret' => config('dhl.webhook_secret'),
            ],
        ]);
    }

    public function saveSettings(Request $request)
    {
        $data = $request->validate([
            'account' => 'required|string',
            'webhook_secret' => 'required|string',
        ]);

        $path = config_path('dhl.php');
        $configContents = file_get_contents($path);
        $configContents = preg_replace(
            [
                "/'account_number' => .*?,/",
                "/'webhook_secret' => .*?,/",
            ],
            [
                "'account_number' => '{$data['account']}',",
                "'webhook_secret' => '{$data['webhook_secret']}',",
            ],
            $configContents
        );
        file_put_contents($path, $configContents);

        return back()->with('success', 'Settings saved.');
    }

    public function merchants()
    {
        return view('dhl::admin.merchants', [
            'merchants' => Merchant::all(),
        ]);
    }

    public function addMerchant(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'account_number' => 'required|string',
        ]);

        Merchant::create($data);

        return back()->with('success', 'Merchant added successfully.');
    }

    public function logs()
    {
        $logs = DB::table('dhl_logs')->latest()->paginate(50);

        return view('dhl::admin.logs', compact('logs'));
    }
}
