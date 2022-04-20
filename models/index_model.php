<?php

class Index_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ImageBackgroundRemove()
    {
        // Faz a busca da imagem e o nível de contraste
        $file = $_FILES['IMGFile'];
        $img = $file['tmp_name'];
        $recebe_contrast = $_POST['contrast'];

        // Manda a imagem renomeada para outra pasta e ativa o script em Python
        fopen('public/images/contrast.txt', 'w');
        rename($img, 'public/images/assinatura.jpeg');
        file_put_contents('public/images/contrast.txt', $recebe_contrast);
        $command = escapeshellcmd('python views/index/script.py');
        shell_exec($command);

        // transforma a imagem sem fundo em base64
        header('Content-type:image/png');
        $searchIMG = 'public/images/assinatura.png';
        $type = pathinfo($searchIMG, PATHINFO_EXTENSION);
        $data = file_get_contents($searchIMG);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        echo json_encode($base64);
    }

    public function selectEvento() {
        $sql = $this->db->select(
            "SELECT
                sequencia,
                nome
            FROM
                evento"
        );
        echo json_encode($sql);
    }

    public function saveImage()
    {
        $name = $_POST['nomeImage'];
        $searchIMG = 'public/images/assinatura.png';
        rename($searchIMG, 'public/images/' . $name . '.png');
        $caminhoIMG = 'public/images/' . $name . '.png';

        $dados = [
            'nomeassinatura' => strtoupper($name),
            'caminho' => $caminhoIMG
        ];

        $sql = $this->db->select("
            SELECT
                *
            FROM
                assinaturas a
            WHERE
                caminho = :caminho
        ", array(":caminho" => $caminhoIMG));

        $msg = array("codigo" => 0, "texto" => "Falha ao tentar salvar.");
        if ($name) {
            $result = $this->db->insert('asscertificado.assinaturas', $dados);
            $msg = array("codigo" => 1, "texto" => "Salvo com sucesso.");
        }

        echo json_encode($msg);
    }

    public function GeraCertificado()
    {
        $cpf = $_POST['cpf']; // Esta variável é usada para buscar as informações no banco de dados para o certificado
        $email = $_POST['email']; // Esta variável é usada para buscar as informações no banco de dados para o certificado
        $msg = array("codigo" => 0, "texto" => "Falha ao tentar prosseguir.");
        $evento = $_POST['selectEvento'];

        $eventos = $this->db->select(
            "SELECT
                *
            FROM
                evento e
            WHERE
                e.sequencia = :seq"
            ,array(":seq" => $evento)
        );

        $participante = $this->db->select(
            "SELECT
                sequencia,
                nome,
                email,
                cpf
            FROM
                participante p
            WHERE
                email = :email
                AND cpf = :cpf",
            array(
                ":cpf" => $cpf,
                ":email" => $email
            ));
        $participaEvento = $this->db->select(
            "SELECT
                *
            FROM
                documentos d
            WHERE
                d.participantes = :seq"
            ,array(":seq" => $participante[0]->sequencia)
        );

        if ($participaEvento) {
            Session::init();
            Session::set('nome', $participante[0]->nome);
            Session::set('email', $participante[0]->email);
            Session::set('cpf', $participante[0]->cpf);
            Session::set('logado', true);
            $msg = array("codigo" => 1, "texto" => "OK");
        } else {
            $dados = [
                "participantes" => $participante[0]->sequencia,
                "eventos" => $eventos[0]->sequencia
            ];
            $result = $this->db->insert("asscertificado.documentos", $dados);
            if ($result) {
                Session::init();
                Session::set('nome', $participante[0]->nome);
                Session::set('email', $participante[0]->email);
                Session::set('cpf', $participante[0]->cpf);
                Session::set('logado', true);
                $msg = array("codigo" => 1, "texto" => "OK");
            }
        }
        echo json_encode($msg);
    }
}