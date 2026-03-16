<?php

namespace App\Mail;

use App\Models\Solicitacoes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendSolicitacao extends Mailable
{
    use Queueable, SerializesModels;

    public $dados;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Solicitacoes $dados)
    {
        $this->dados = $dados;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        // foreach ($this->dados->anexos as $key => $value) {
        //     $this->attach(public_path("/storage/".$value->arquivo));
        //  }


        return $this->from('pac@hdls.com.br')
                ->markdown('emails.Solicitacao')
                ->subject('Solicitação de Autorização de Cirurgia - PAC')
                ->with([
                    'dados'     => $this->dados
                ]);
    }


}
