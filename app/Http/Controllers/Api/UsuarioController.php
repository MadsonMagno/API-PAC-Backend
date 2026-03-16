<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class UsuarioController extends Controller
{
    //

    public function usuarios(Request $request)
    {


        $res = User::all();

        $data['lista'] = $res;


        return response()->json($data, 200);

    }

    public function usuario($id)
    {


        $res = User::find($id);
        $pres = DB::table('users_prestadores')->where('user_id', $res->id)->get();

        $data['lista'] = $res;
        $data['prestadores'] = $pres;


        return response()->json($data, 200);

    }

    public function medicos(Request $request)
    {


        $res = Medico::getAll();


        $data['lista'] = $res;


        return response()->json($data, 200);

    }

    public function convenios(Request $request)
    {


        $res = Medico::getConvenios();


        $data['lista'] = $res;


        return response()->json($data, 200);

    }

    public function create_user(Request $request)
    {


        if($request->id > 0){

            $user =  User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->cpf = $request->cpf;
            $user->telefone = $request->telefone;
            $user->save();


            DB::table('users_prestadores')->where('user_id', $user->id)->delete();

            $codigos = explode(',', $request->medicos);

            foreach ($codigos as $key => $value) {
                DB::table('users_prestadores')->insert(['user_id'=> $user->id, 'prestador_id' => $value]);
            }


            //$data['lista'] = $res;
            $data['lista'] = 'Usuario Atualizado';


            return response()->json($data, 200);



        }else{

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->cpf = $request->cpf;
            $user->telefone = $request->telefone;
            $user->password = bcrypt($request->senha);
            $user->save();

            $codigos = explode(',', $request->medicos);

            foreach ($codigos as $key => $value) {
                DB::table('users_prestadores')->insert(['user_id'=> $user->id, 'prestador_id' => $value]);
            }


            //$data['lista'] = $res;
            $data['lista'] = 'Usuario Criado';


            return response()->json($data, 200);


        }



    }

    public function alterar_senha(Request $request)
    {


        $user =  User::find($request->id);
        $user->password = bcrypt($request->senha);
        $user->save();



    }


}
