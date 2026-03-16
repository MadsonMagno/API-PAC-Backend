@component('mail::message')
<p style="text-align: center; font-size: 20px; font-weight: bold">
Solicitação de Autorização de Cirurgia
</p>

Segue abaixo os dados da solicitação de autorização de cirurgia.


## Nome do Paciente
{{$dados->paciente}}

## CPF do Paciente
{{$dados->cpf}}

## RG do Paciente
{{$dados->rg}}

## Telefone do Paciente
{{$dados->telefone}}

## Convênio
{{$dados->convenio}}

## Número da Carteirinha do Paciente
{{$dados->carteirinha}}

## Data/Hora da Solicitação
{{  date_format( $dados->created_at, 'd/m/Y H:i:s') }}

## Email do Remetente
{{$dados->email}}






@endcomponent
