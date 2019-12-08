<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Tracker\Vendor\Laravel\Models\Session;
use PragmaRX\Tracker\Vendor\Laravel\Models\User;
use PragmaRX\Tracker\Vendor\Laravel\Models\Device;
use PragmaRX\Tracker\Vendor\Laravel\Models\Language;
use PragmaRX\Tracker\Vendor\Laravel\Models\Agent;
use PragmaRX\Tracker\Vendor\Laravel\Models\Referer;
use PragmaRX\Tracker\Vendor\Laravel\Models\GeoIp;
use Tracker;
use PragmaRX\Tracker\Vendor\Laravel\Support\Session as Session2;

use Carbon\Carbon;
use App\Settings;
// Son gelen kayıtlar için
use App\Reg_application;
use App\Cities;

class dashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
         return Session::with('user', 'device', 'language', 'Referer', 'agent', 'geoIp')->orderBy('updated_at', 'DESC')->paginate(15);

    }
    public function apiPageviews(Session2 $session)
    {
        return response()->json([
            'data'=>Tracker::pageViews($session->getMinutes())
        ]);
    }

    public function lastusers()
    {
        return Reg_application::with('city')->orderBy('id', 'DESC')->paginate(5);
    }

    public function statscountall()
    {
        return Session::distinct()->count('client_ip');
        // whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])->
    }
    public function statscountday()
    {
        return Session::whereBetween('created_at', [Carbon::now()->subDays(1), Carbon::now()])->distinct()->count('client_ip');
        // whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])->
    }
    public function statscountweek()
    {
        return Session::whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])->distinct()->count('client_ip');
        // whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])->
    }
    public function statscountrecent()
    {
        return Session::whereBetween('created_at', [Carbon::now()->subHours(6), Carbon::now()])->distinct()->count('client_ip');
        // whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])->
    }
    public function allusers()
    {
       return User::all();

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sessions()
    {
        $sessions= Tracker::sessions(60 * 24);
        $sayi=count($sessions);
        $session1='{"data":[';
        $sayac=0;
        $now = time();
        foreach ($sessions as $session) {
            $sayac++;
            $session1.="{";

            if($session->user!="") {
                $session1 .= '"username":"'.$session->user->username.'",';
            }
            else
            {
                $session1 .='"username":"'."null".",";
            }
            $session1 .='"device":"'.$session->device->kind."-".$session->device->platform.'",';
            $session1 .='"agent":"'.$session->agent->browser.'",';
            $session1 .='"country":"'.$session->geoIp->country_name."-".$session->client_ip.'",';
            $session1 .='"language":"'.$session->language->preference.'",';
            //$session1 .='"created":"'.$session->created_at.'",';
            $difference = $now - strtotime($session->updated_at);
            $minutes = floor($difference / 60);
            $session1 .='"updated":"'.$minutes.' dakika"';

            if($sayac==10 || $sayac==$sayi) {
            $session1 .="}";
            break;
            }
            else
            {
             $session1 .="},";
            }
        }

        $session1 .="]}";

        return $session1;

    }

    public function show()
    {
        //return Tracker::onlineUsers();
        $sessions = Tracker::sessions(60 * 24);

        return count($sessions);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
