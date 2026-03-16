<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Agendamento extends Model
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


    public static function getAll($prestador){

        $sql= "SELECT *  from VDIC_DH_WORKFLOW_TOT_PRESTADOR WHERE CD_PRESTADOR in ($prestador)";

        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }

    public static function getAll1(){

        $sql= "SELECT *  from VDIC_DH_WORKFLOW_TOT_PRESTADOR";

        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }


    public static function getTipo($prestador){

        $sql= "SELECT cd_tip_presta  from prestador where cd_prestador = $prestador";

        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }


    public static function getLista($prestador){

        $sql= "SELECT *  from VDIC_DH_WORKFLOW_LISTA_PREST WHERE CD_PRESTADOR in ($prestador)";

        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }

    public static function getLista1(){

        $sql= "SELECT *  from VDIC_DH_WORKFLOW_LISTA_PREST";

        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }

    public static function getPaciente($cpf){

        $sql= "SELECT p.*, (SELECT convenio.nm_convenio FROM carteira inner join convenio ON carteira.cd_convenio = convenio.cd_convenio WHERE carteira.cd_paciente = p.cd_paciente ORDER BY carteira.dt_validade desc FETCH FIRST 1 ROWS ONLY) AS convenio   from paciente p WHERE p.NR_CPF = $cpf";

        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }

    public static function getById($cd_aviso){

        $sql= "SELECT *  from VDIC_DH_WORKFLOW_LISTA_PREST WHERE CD_AVISO_CIRURGIA = $cd_aviso";

        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }

    public static function getByIdandCpf($cd_aviso, $cpf){

        $sql= "SELECT *  from VDIC_DH_WORKFLOW_LISTA_PREST_2 WHERE CD_AVISO_CIRURGIA = $cd_aviso AND NR_CPF = $cpf";

        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }

    public static function getHistoricos($aviso){


        $sql= "SELECT *  from registro_contato WHERE CD_REGISTRO_VINCULADO = $aviso ORDER BY DT_CONTATO DESC";

        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }

    public static function getEspecialidades($search){



        if(!$search){

            $sql= "select cd_especialid, ds_especialid from especialid where sn_ativo = 'S' and cd_especialid not in (0,61,73,75,76,78,70) order by ds_especialid asc";
        }else{

            $sql= "select cd_especialid, ds_especialid from especialid where sn_ativo = 'S' and  ds_especialid like '%" . $search . "%' ";
        }


        $retorno = Agendamento::conexao($sql);

        Return $retorno;
    }

}
