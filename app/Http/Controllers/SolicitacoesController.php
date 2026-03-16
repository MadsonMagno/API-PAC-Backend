<?php

namespace App\Http\Controllers;

use App\Mail\SendConfirmacao;
use App\Mail\SendSolicitacao;
use App\Models\Solicitacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SolicitacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // Log::info($request);


        $solic = Solicitacoes::create([
            'paciente' => $request->name,
            'usuario' => $request->username,
            'convenio' => $request->convenio,
            'email' => $request->email,
            'rg' => $request->rg,
            'telefone' => $request->telefone,
            'carteirinha' => $request->carteirinha,
            'cpf' => $request->cpf,
            'status' => 'Solicitação Recebida',
        ]);


        //Upload dos Arquivos
        for ($i=0; $i < count($request->file('files')); $i++) {
            $upload = $request->file('files')[$i]->store('public');
            // Storage::copy($upload, str_replace('public/','arquivos/', $upload));
            $solic->anexos()->create([
                'arquivo' => str_replace('public/','', $upload)
            ]);
        }


        if($request->hasFile('files1')){
            for ($i=0; $i < count($request->file('files1')); $i++) {
                $upload = $request->file('files1')[$i]->store('public');
                // Storage::copy($upload, str_replace('public/','arquivos/', $upload));
                $solic->anexos()->create([
                    'arquivo' => str_replace('public/','', $upload)
                ]);
            }
        }

        for ($i=0; $i < count($request->file('files2')); $i++) {
            $upload = $request->file('files2')[$i]->store('public');
            // Storage::copy($upload, str_replace('public/','arquivos/', $upload));
            $solic->anexos()->create([
                'arquivo' => str_replace('public/','', $upload)
            ]);
        }


        for ($i=0; $i < count($request->file('files3')); $i++) {
            $upload = $request->file('files3')[$i]->store('public');
            // Storage::copy($upload, str_replace('public/','arquivos/', $upload));
            $solic->anexos()->create([
                'arquivo' => str_replace('public/','', $upload)
            ]);
        }

        if($request->hasFile('files4')){
        for ($i=0; $i < count($request->file('files4')); $i++) {
            $upload = $request->file('files4')[$i]->store('public');
            // Storage::copy($upload, str_replace('public/','arquivos/', $upload));
            $solic->anexos()->create([
                'arquivo' => str_replace('public/','', $upload)
            ]);
        }
        }

        $solicitacao = Solicitacoes::where('id', $solic->id)->with('anexos')->first();

         Mail::to('cirurgias.eletivas@hospitaldaher.com.br')
         ->send(new SendSolicitacao($solicitacao));

        Mail::to($request->email)
        ->send(new SendConfirmacao($solicitacao));


         return response()->json(['Mensagem' => 'Sucesso'], 200);
        // return response()->json($data, 200);

    }

    public function solicitacao(Request $request)
    {


        $res = Solicitacoes::where('usuario', $request->username)->with('anexos')->get();

        $data['lista'] = $res;


        return response()->json($data, 200);

    }

    public function pesquisa_solicitacao(Request $request)
    {


        $res = Solicitacoes::whereDate('created_at', $request->data)->with('anexos')->get();

        $data['lista'] = $res;


        return response()->json($data, 200);

    }


    public function getConvenios(){





    }


}
