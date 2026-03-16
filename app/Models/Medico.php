<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Medico extends Model
{
    use HasFactory;

    public static function conexao($sql) {


        $tns = "
        (DESCRIPTION =
            (ADDRESS_LIST =
              (ADDRESS = (PROTOCOL = TCP)(HOST = oda-scan.hdls.home)(PORT = 1521))
            )
            (CONNECT_DATA =
              (SERVICE_NAME = MVHTML5)
            )
          )
               ";
        $db_username = "dbadw";
        $db_password = "dbadw";
        try{
            $conn = new PDO("oci:dbname=".$tns. ';charset=UTF8',$db_username,$db_password);

        }catch(PDOException $e){
            echo ($e->getMessage());
        }


            $stmt = $conn->query($sql);

            if($stmt){

                $row =$stmt->fetchAll(PDO::FETCH_ASSOC);

                $lista = $row;

            }else{
                $lista = null;
            }

            Return $lista;


    }


    public static function getAll(){

        $sql= "SELECT CD_PRESTADOR AS value, DS_CODIGO_CONSELHO|| ' - ' || NM_PRESTADOR AS text, CD_PRESTADOR AS id, NM_PRESTADOR AS name, DS_EMAIL AS email  from prestador WHERE CD_TIP_PRESTA IN (8,3,37) and tp_situacao = 'A' ORDER BY NM_PRESTADOR";

        $retorno = Medico::conexao($sql);

        Return $retorno;
    }


    public static function getConvenios(){

        $sql= "SELECT NM_CONVENIO AS value, NM_CONVENIO AS text  from CONVENIO WHERE SN_ATIVO = 'S' ORDER BY NM_CONVENIO ASC";

        $retorno = Medico::conexao($sql);

        Return $retorno;
    }

}
