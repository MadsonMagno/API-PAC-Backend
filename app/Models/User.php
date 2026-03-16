<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PDO;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function login($usuario, $senha){

        $sql= "SELECT FNC_MV2000_HMVPEP('$usuario','$senha') AS VALIDA FROM DUAL";

        $retorno = User::conexao($sql);

        Return $retorno;

    }

    public static function login2($usuario, $senha){

        $retorno = [];

        $log = Auth::attempt(['email' => $usuario, 'password' =>  $senha]);


        if($log){

            $user = User::where('email', $usuario)->first();
            $retorno['VALIDA'] = true;
            $retorno['USER'] = $user;
            Return $retorno;
        }else{

            $retorno['VALIDA'] = false;
            Return $retorno;
        }



    }


    public static function getUser($usuario){

        //$sql= "SELECT * from DBASGU.USUARIOS WHERE CD_USUARIO = '$usuario'";
         $sql= "SELECT USU.*, PRE.* from DBASGU.USUARIOS USU LEFT JOIN PRESTADOR PRE ON USU.CD_PRESTADOR = PRE.CD_PRESTADOR  WHERE USU.CD_USUARIO = '$usuario'";

        $retorno = User::conexao($sql);

        Return $retorno;

    }

    public static function getEspecialidade($cd_prestador){

        $sql = "select * from vdic_especialidade_prestador where SN_ESPECIALIDADE_PRINCIPAL = 'S' AND CODIGO_PRESTADOR = '$cd_prestador'";

        $retorno = User::conexao($sql);

        return $retorno;

    }




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
            $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);

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
}
