<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/calculateClicked', function(Request $request) {

    $num1 = $request->input('num1');
    $num2 = $request->input('num2');
    $operation = $request->input('operation');
    $myIP = '';

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

    return $result;
});
