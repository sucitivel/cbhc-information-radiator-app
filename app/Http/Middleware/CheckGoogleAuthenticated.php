<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Library\GoogleApi;

class CheckGoogleAuthenticated
{
    private $exceptions = [
        '/oauth2',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->session()->put('gToken',
        [
            "access_token" => "ya29.a0ARrdaM-Tk9tuIF12s1gb1sXPhv2SRuB_ig3-GPCW8aL5PfVi5Vdu_BMFtjvGToDDanyruy6GWnBWiZLccV9pVoXFatGEyWGWgH5TFIRrcq5cRGOLwT3zmDO6-ERb_RbpTSu5AL8PQ59JvIhNCvLTPOAKpdi6",
            "expires_in" => 3599,
            "refresh_token" => "1//0d_5ZEm22zz-pCgYIARAAGA0SNwF-L9Ir3_GwdNmvTybJNo4DPRw2RJXU0GEm0GM0tV7JZk275xcquOCeL5Rr--KR78MYylaWkIQ",
            "scope" => "https://www.googleapis.com/auth/spreadsheets.readonly",
            "token_type" => "Bearer",
            "created" => 1636923846,
        ]);

        if (isset($_SERVER['REDIRECT_URL']) && in_array($_SERVER['REDIRECT_URL'], $this->exceptions)) {
            return $next($request);
        }

        $client = (new GoogleApi)->getClient();

        if ($request->session()->has('gToken')) {
            $accessToken = $request->session()->get('gToken');
            $client->setAccessToken($accessToken);
        }

        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                return redirect($authUrl);
            }
            // Save the token to a file.
            $request->session()->put('gToken', $client->getAccessToken());
        }

        $request->merge(['gClient' => $client]);
        return $next($request);
    }
}
