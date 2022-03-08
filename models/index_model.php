<?php

class Index_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ImageBackgroundRemove()
    {
        $file = $_FILES['IMGFile'];
        $img = $file['tmp_name'];
        var_dump($img);
    }

    public function GeraCertificado()
    {
        $cpf = $_POST['cpf']; // Esta variável é usada para buscar as informações no banco de dados para o certificado
        $email = $_POST['email']; // Esta variável é usada para buscar as informações no banco de dados para o certificado
        $msg = "";

        $result = $this->db->select("
            SELECT
                nome,
                email,
                cpf
            FROM
                alunos a
            WHERE
                email = :email
                AND cpf = :cpf",
            array(
                ":cpf" => $cpf,
                ":email" => $email
            ));

        if ($result) {
            Session::init();
            Session::set('nome', $result[0]->nome);
            Session::set('email', $result[0]->email);
            Session::set('cpf', $result[0]->cpf);
            Session::set('logado', true);
            $msg = array("codigo" => 1, "texto" => "OK");
        } else {
            $msg = array("codigo" => 0, "texto" => "Falha ao tentar prosseguir.");
        }
        echo json_encode($msg);
    }
}