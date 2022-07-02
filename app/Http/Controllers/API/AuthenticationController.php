<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email,
                          'password' => $request->password])){
  
            $authUser = Auth::user();
            $success['token'] =  $authUser->
                                  createToken('Chat')->plainTextToken;
  
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
    }
 
}
