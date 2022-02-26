<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $log = array();

    $log = DB::table('table1')->get();

    $alert = false;
    $time = '';
    if(count($log) > 0){
        $time = date('H:i:s', strtotime($log[count($log) - 1]->time));
    }

    if(count($log)%20 == 0 && count($log) != 0){
        $alert = true;
    }

    return view('welcome', ['log' => $log, 'alert' => $alert, 'time' => $time]);
});

Route::post('/calculateClicked', function(Request $request) {

    $num1 = $request->input('num1');
    $num2 = $request->input('num2');
    $operation = $request->input('operation');
    $alert = $request->input('alert');
    $time = $request->input('time');
    $myIP = '';

     if($alert){
        $seconds = strtotime(date('H:i:s')) - strtotime($time);
        $days    = floor($seconds / 86400);
        $hours   = floor(($seconds - ($days * 86400)) / 3600);
        $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

        if($minutes < 2){
            return redirect('/')->with('message', 'Wait for 2 minutes for further requests');
        }
     }

    $result = 0;

    if($operation == '+'){

        $result = $num1 + $num2;
    }else if($operation == '-'){

        $result = $num1 - $num2;

    }else if($operation == '/'){

        if($num2 == 0){
            $result = 'INF';
        }else{
            $result = $num1 / $num2;
        }

    }else{

        $result = $num1 * $num2;

    }

    $myIP = request()->ip();

    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    $myIP = $ip;
                }
            }
        }
    }
    
    DB::table('table1')->insert([
        'num1' => $num1,
        'num2' => $num2,
        'operation' => $operation,
        'result' => $result,
        'ip' => $myIP
    ]);

    return redirect('/')->with('result', $result);
});
