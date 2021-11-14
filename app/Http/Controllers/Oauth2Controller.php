<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\GoogleApi;

class OAuth2Controller extends Controller
{
    public function receiveToken(Request $request)
    {
        $authCode = trim($request->get('code'));

        $client = (new GoogleApi())->getClient();

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Check to see if there was an error.
        if (array_key_exists('error', $accessToken)) {
            throw new \Exception(join(', ', $accessToken));
        }

        $client->setAccessToken($accessToken);
        $request->session()->put('gToken', $accessToken);
    }
}

