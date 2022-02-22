<?php

class Index_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ImageBackgroundRemove()
    {
        $img = json_decode(file_get_contents('php://input'));
        $cmdResult = shell_exec($img);
        $result = json_decode($cmdResult);
        print_r($result);

        //if ($result) {
        //    Session::init();
        //    Session::set('nome');
        //    Session::set('email');
        //    Session::set('cpf');
        //    Session::set('entrou', true);
        //    echo "OK";
        //} else {
        //    echo "Dados Incorretos.";
        //}
    }

    public function GeraCertificado()
    {
        $dados = json_decode(file_get_contents('php://input'));
        var_dump($dados);
    }
}