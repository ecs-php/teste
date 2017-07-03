<?php
require_once '../vendor/autoload.php';

$app = new Silex\Application();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$app->get('/list', function() use($app) {
    $connect = mysql_connect('localhost','root','') or print(mysql_error());
    mysql_select_db('db_serasa',$connect) or print(mysql_error());
    $return = '';  
    $data = null;
    $sql = "SELECT DATE_FORMAT(cnsmr_birth,'%d/%m/%Y') cnsmr_birth_f, c.* FROM consumer c";
        if($result = mysql_query($sql,$connect)){
            while($consulta = mysql_fetch_array($result)){
                $return['c_id'] =  utf8_encode($consulta['cnsmr_id']);  
                $return['c_cpf'] =  utf8_encode($consulta['cnsmr_cpf']); 
                $return['c_name'] =  utf8_encode($consulta['cnsmr_name']); 
                $return['c_birth_f'] =  utf8_encode($consulta['cnsmr_birth_f']); 
                $return['c_cphone'] =  utf8_encode($consulta['cnsmr_cphone']); 
                $data[] = $return;  
            }
        }
         
        return json_encode($data);
});


$app->get('/list/{id}', function($id) use($app) {
    $connect = mysql_connect('localhost','root','') or print(mysql_error());
    mysql_select_db('db_serasa',$connect) or print(mysql_error());
    $return = '';  
    $data[0] = '';
    $sql = "SELECT c.* FROM consumer c where c.cnsmr_id = ".$id;
        if($result = mysql_query($sql,$connect)){            
            while($consulta = mysql_fetch_array($result)){
                $return['c_id'] =  utf8_encode($consulta['cnsmr_id']);  
                $return['c_cpf'] =  utf8_encode($consulta['cnsmr_cpf']); 
                $return['c_name'] =  utf8_encode($consulta['cnsmr_name']); 
                $return['c_birth'] =  utf8_encode($consulta['cnsmr_birth']); 
                $return['c_cphone'] =  utf8_encode($consulta['cnsmr_cphone']); 
                $data[0] = $return;  
            }
        }
         
        return json_encode($data);
});

$app->post('/save', function(Request $request) use($app){
    $connect = mysql_connect('localhost','root','') or print(mysql_error());
    mysql_select_db('db_serasa',$connect) or print(mysql_error());

    $c_name = $request->get('c_name');
    $c_cpf = $request->get('c_cpf');
    $c_birth = $request->get('c_birth');
    $c_cphone = $request->get('c_cphone');

    $return = '';
    $return['result'] = '';
    $return['message'] = '';

    if(empty($c_name) || empty($c_cpf) || empty($c_birth) || empty($c_cphone)){
        $return['result'] = 'error';
        $return['message'] = 'Alguns campos não foram preenchidos, favor verificar o formulário!';
    }

    $sql = " insert into consumer(cnsmr_name,
                             cnsmr_cpf,
                             cnsmr_cphone,
                             cnsmr_birth,
                             cnsmr_date_register) 
                     values ('".utf8_decode($c_name)."',
                             '".$c_cpf."',
                             '".utf8_decode($c_cphone)."',
                             '".utf8_decode($c_birth)."',
                             SYSDATE() )";
       ;
       
        if($result = mysql_query($sql,$connect)){
            $return['result'] = 'success';
            $return['message'] = 'Cadastro realizado com sucesso!';
        }else{
            $return['result'] = 'error';
            $return['message'] = 'Erro ao realizar operação!';
        }
        return json_encode($return);
});

$app->post('/save/{id}', function(Request $request,$id) use($app){
    $connect = mysql_connect('localhost','root','') or print(mysql_error());
    mysql_select_db('db_serasa',$connect) or print(mysql_error());

    $c_name = $request->get('c_name');
    $c_cpf = $request->get('c_cpf');
    $c_birth = $request->get('c_birth');
    $c_cphone = $request->get('c_cphone');

    $return = '';
    $return['result'] = '';
    $return['message'] = '';

    if(empty($c_name) || empty($c_cpf) || empty($c_birth) || empty($c_cphone)){
        $return['result'] = 'error';
        $return['message'] = 'Alguns campos não foram preenchidos, favor verificar o formulário!';
    }

    $sql = " update consumer set cnsmr_name = '".utf8_decode($c_name)."',
                             cnsmr_cpf = '".$c_cpf."',
                             cnsmr_cphone = '".utf8_decode($c_cphone)."',
                             cnsmr_birth = '".utf8_decode($c_birth)."',
                             cnsmr_date_change =  SYSDATE()
                             WHERE cnsmr_id = ".$id;
       
        if($result = mysql_query($sql,$connect)){
            $return['result'] = 'success';
            $return['message'] = 'Cadastro realizado com sucesso!';
        }else{
            $return['result'] = 'error';
            $return['message'] = 'Erro ao realizar operação!';
        }
        return json_encode($return);
});

$app->delete('/delete/{id}', function($id) use($app) {
    $connect = mysql_connect('localhost','root','') or print(mysql_error());
    mysql_select_db('db_serasa',$connect) or print(mysql_error());
    $sql = "DELETE FROM consumer where cnsmr_id = ".$id;
    mysql_query($sql,$connect);
    if($result = mysql_query($sql,$connect)){
        $return['message'] = 'Registro excluído com sucesso!';
    }else{
        $return['message'] = 'Erro ao realizar operação!';
    }
    return json_encode($return);
});


$app->run();
?>