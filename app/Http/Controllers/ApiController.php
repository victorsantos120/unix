<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Historic;
use Illuminate\Support\Facades\Auth;
use DB;

class ApiController extends Controller
{
    public function login (Request $request) {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken($authUser)->plainTextToken;
            $success['username'] =  $authUser->name;
      
            $response = [
                'success' => true,
                'data'    => $success,
                'message' => 'User logged successfully',
            ];
    
            return response()->json($response, 200);
        }
    
        $response = [
            'success' => false,
            'data'    => 'Error',
            'message' => 'User not authenticated',
        ];
        
        return response()->json($response, 401);
    }

    public function post(Request $request,  User $user) {
        $request->validate([
            'sender' => ['required', 'string'],
            'value' => ['required', 'numeric']
        ]);
        $form = $request->all();

        $sender = $user->getSender($request->sender);
        $value = $request->value;
        
        if (!$sender)
            return redirect()
                ->back()
                ->with('error', 'Usuário informado não foi encontrado!');

        DB::beginTransaction();

        /**********************************************
        * Atualiza o saldo do recebedor
        **********************************************/
        $senderBalance = $sender->balance()->firstOrCreate([]);
        $totalBeforeSender = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format($value, 2, '.', '');
        $transferSender = $senderBalance->save();

        $historicSender = $sender->historics()->create([
            'type' => 'I', 
            'amount' => $value, 
            'total_before' => $totalBeforeSender, 
            'total_after' => $senderBalance->amount, 
            'date' => date('Ymd'),
            'user_id_transaction' => auth()->user()->id
        ]);

        if ($transferSender && $historicSender) {
            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao transferir'
            ];
            return response()->json($response, 200);
        } else {
            DB::rollback();

            $response = [
                'success' => false,
                'data'    => 'Error',
                'message' => 'Internal Server Error' ,
            ];
            return response()->json($response, 500);
        }
    }

    public function get(Request $request) {
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
}
