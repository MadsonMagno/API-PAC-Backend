<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return "Index";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

		$usuario = strtoupper($request->usuario);

		$res = User::Login( $usuario, $request->password);


        if ($res[0]['VALIDA'] == 'SENHA INVALIDA' || $res[0]['VALIDA'] == 'USUARIO NAO CADASTRADO' ) {
            return response()->json($data = ['errors' => ['Usuario nao cadastrado ou Senha Invalida']], 404);
        }else{

            $usu = User::getUser($request->usuario);
            $tipo = 'Adm';
            $especialidades = 'Todas';


            if ($usu[0]['CD_TIP_PRESTA'] == 8) {
                $tipo = 'Médico';
                $especialidades = User::getEspecialidade($usu[0]['CD_PRESTADOR'])[0];
            }

            $usuario = [
                'email' => $usu[0]['CD_USUARIO'],
                'username' => $usu[0]['NM_USUARIO'],
                'password' => '',
                'bio' => '',
                'cd_prestador' => $usu[0]['CD_PRESTADOR'],
                'perfil' => $tipo,
                'token' => $res[0]['VALIDA'],
                'especialidades' => $especialidades
            ];

            return response($usuario, 200);
        }



    }


    public function login2(Request $request)
    {
        $res = User::Login2( $request->usuario, $request->password);




        if ($res['VALIDA']) {

            //dd($res['USER']);
            $prestadores = DB::table('users_prestadores')->where('user_id', $res['USER']->id)->select('prestador_id')->get()->toArray();

            $prest = [];

            foreach ($prestadores as $key => $value) {
                $prest[] = $value->prestador_id;
            }



            $usuario = [
                'email' => $res['USER']->name,
                'id' => $res['USER']->id,
                'username' => $res['USER']->email,
                'password' => '',
                'bio' => '',
                'cd_prestador' => $prest, //[3038,3016,2114,3849],
                'perfil' => 'Secretária',
                'token' => $res['USER']->password
            ];

            return response($usuario, 200);

        }else{

            return response()->json($data = ['errors' => ['Usuario nao cadastrado ou Senha Invalida']], 404);


        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
