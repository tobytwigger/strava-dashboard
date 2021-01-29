<?php

namespace App\Http\Controllers;

use App\Models\StravaToken;
use App\Support\Strava\Strava;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StravaController extends Controller
{

    public function index()
    {
        return view('connect');
    }

    public function login(Request $request, Strava $strava)
    {
        $state = null;

        $request->session()->put('state', $state = Str::random(40));

        return new RedirectResponse(
            $strava->redirectUrl(
                (int) config('strava.client_id'),
                route('strava.callback'),
                $state
            )
        );
    }

    public function callback(Request $request, Strava $strava)
    {
        $token = $strava->exchangeCode(
            (int) config('strava.client_id'),
            config('strava.client_secret'),
            $request->input('code')
        );

        $savedToken = StravaToken::makeFromStravaToken($token);

        $savedToken->save();

        return redirect()->route('home');
    }

}
