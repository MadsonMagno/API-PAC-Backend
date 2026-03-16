<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anexos;

class Solicitacoes extends Model
{
    use HasFactory;

    protected $table = 'solicitacoes';
    protected $guarded = ['id'];

    public function anexos(){

        return $this->hasMany(Anexos::class,  'solicitacao_id', 'id');
    }


}
