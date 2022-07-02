<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Models\Historic;
use \App\Models\Balance;

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

Route::post('/login', function (Request $request) {
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        $authUser = Auth::user();
        $success['token'] =  $authUser->createToken('Chat')->plainTextToken;
        $success['name'] =  $authUser->name;

        $response = [
            'success' => true,
            'data'    => $success,
            'message' => 'Usuário logado com sucesso',
        ];
        return response()->json($response, 200);
    }
    else{
        $response = [
            'success' => false,
            'data'    => 'Erro',
            'message' => 'Usuário não logado',
        ];
        return response()->json($response, 401);
    }
});
Route::post('/login',
    'App\Http\Controllers\API\AuthenticationController@login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/historic',
        function (Request $request) {
            try {
                return [
                    'success' => true,
                    'data' => \App\Models\Historic::all(),
                    'message' => 'Consulta realizada com sucesso.',
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'data' => [],
                    'message' => $e->getMessage(),
                ];
            }
        }
    );
});

Route::post('/transfer',
    function (Request $request) {
        try {
            $request['user_id'] = Auth::user()->id;
            $transfer = \App\Models\Balance::transferapi($request->all());

            return [
                'success' => true,
                'data' => $transfer,
                'message' => 'Armazenamento realizado com sucesso.',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'data' => [],
                'message' => $e->getMessage(),
            ];
        }
    }
);
Route::get('/historic/{historic}',
    function (Historic $historic) {
        try {
            return [
                'success' => true,
                'data' => $historic,
                'message' => 'Consulta realizada com sucesso.',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'data' => [],
                'message' => $e->getMessage(),
            ];
        }
    }
);
Route::get('/clienteListarMensagem', function () {

    $responseLogin = Http::post('http://127.0.0.1:8001/api/login',
        ['email' => 'marcos@teste.com',
            'password' => '12345678']);

    $token = $responseLogin->collect('data')->get('token');


    $respostaMessages = Http::withToken($token)
        ->get('http://127.0.0.1:8001/api/message')->json();

    dd($responseLogin->json() , $respostaMessages);
});
