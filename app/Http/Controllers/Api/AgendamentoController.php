<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agendamento;
use Illuminate\Support\Facades\Log;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {





        if( strpos($request->cd_prestador, ',') ){


            $str = $request->cd_prestador;
            $find = array('[',']');
            $replace = '';

            $prestador = str_replace($find, $replace, $str);

        }else{

            $tipo = Agendamento::getTipo($request->cd_prestador);



            if( $request->cd_prestador == 'null' || $tipo[0]['CD_TIP_PRESTA'] != 8){


                $res = Agendamento::getLista1();
                $qtd = Agendamento::getAll1();


                $data['lista'] = $res;
                $data['totais'] = $qtd;

                return response()->json($data, 200);



            }


            $prestador = $request->cd_prestador;

        }


        $res = Agendamento::getLista($prestador);
        $qtd = Agendamento::getAll($prestador);


        $data['lista'] = $res;
        $data['totais'] = $qtd;

        return response()->json($data, 200);

    }


    public function paciente(Request $request)
    {


        $res = Agendamento::getPaciente($request->cpf);


        $data['paciente'] = $res;


        return response()->json($data, 200);

    }

    public function especialidades(Request $request)
    {

        $search = strtoupper($request->search);

        $res = Agendamento::getEspecialidades($search);


        $data = $res;


        return response()->json($data, 200);

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
    public function show($id)
    {
        $res = Agendamento::getById($id);

        $data['lista'] = $res;


        return response()->json($data, 200);
    }

    public function getByAviso($id, $cpf)
    {
        $res = Agendamento::getByIdandCpf($id, $cpf);

        $data['lista'] = $res;

        if(!$res){
            return response()->json($data = ['errors' => ['Nao existe registro para esse aviso']], 401);
        }

        return response()->json($data, 200);
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

    public function getHistoricos(Request $request){

        $res = Agendamento::getHistoricos($request->cd_aviso);

        if(!count($res)){

            $res = '[{"CD_REGISTRO_CONTATO":"",
                "CD_REGISTRO_VINCULADO":"",
                "DT_CONTATO":"",
                "HR_CONTATO":"",
                "CD_USUARIO":"",
                "DS_ASSUNTO":"",
                "DS_CONTATO":"",
                "TP_ACAO":"AC",
                "CD_PACIENTE":"",
                "NM_PACIENTE":""}]';


        }


        return response()->json($res, 200);

    }
}
