<?php

class Gerador_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
        Session::init();
        Auth::autentica();
    }

    public function arrumaPosicao()
    {
        $X = intval($_POST['posicaoX']);
        $X2 = intval($_POST['posicaoX2']);
        $X3 = intval($_POST['posicaoX3']);
        $Y = intval($_POST['posicaoY']);
        $Y2 = intval($_POST['posicaoY2']);
        $Y3 = intval($_POST['posicaoY3']);
        $move = intval($_POST['assinaturaSelecionada']);
        $tamanho = intval($_POST['tamanho']);
        $tamanho2 = intval($_POST['tamanho2']);
        $tamanho3 = intval($_POST['tamanho3']);

        // Validações das assinaturas
        if (isset($_POST['selectAss1'])) {
            $select1 = intval($_POST['selectAss1']);
            if (!isset($_POST['selectAss2']) && !isset($_POST['selectAss3'])) {
                if ($X == 0) {
                    $X = 120;
                    $Y = 140;
                    $tamanho = 60;
                }
                echo json_encode([
                    "posicaoX" => $X,
                    "posicaoY" => $Y,
                    "tamanho" => $tamanho,
                    "move" => $move,
                    "select1" => $select1
                ]);
            }
            if (isset($_POST['selectAss2']) && !isset($_POST['selectAss3'])) {
                $select2 = intval($_POST['selectAss2']);
                if ($X == 0 || $X2 == 0 || empty($X2)) {
                    $X = 20;
                    $X2 = 210;
                    $Y = 140;
                    $Y2 = 140;
                    $tamanho = 60;
                    $tamanho2 = 60;
                } else if ($move == 1) {
                    $X = intval($_POST['posicaoX']);
                    $Y = intval($_POST['posicaoY']);
                    $tamanho = intval($_POST['tamanho1']);
                    // var_dump("ta aqui primeiro");
                } else if ($move == 2) {
                    $X2 = intval($_POST['posicaoX2']);
                    $Y2 = intval($_POST['posicaoY2']);
                    $tamanho2 = intval($_POST['tamanho1']);
                    // var_dump("ta aqui");
                }
                echo json_encode([
                    "posicaoX" => $X,
                    "posicaoX2" => $X2,
                    "posicaoY" => $Y,
                    "posicaoY2" => $Y2,
                    "tamanho" => $tamanho,
                    "tamanho2" => $tamanho2,
                    "move" => $move,
                    "select1" => $select1,
                    "select2" => $select2
                ]);
            }
            if (isset($_POST['selectAss2']) && isset($_POST['selectAss3'])) {
                $select2 = intval($_POST['selectAss2']);
                $select3 = intval($_POST['selectAss3']);
                if ($X == 0 || $X2 == 0 || $X3 == 0 || empty($X2) || empty($X3)) {
                    $X = 20;
                    $X2 = 120;
                    $X3 = 210;
                    $Y = 140;
                    $Y2 = 140;
                    $Y3 = 140;
                    $tamanho = 60;
                    $tamanho2 = 60;
                    $tamanho3 = 60;
                    //var_dump("ta aqui"); exit;
                }
                if ($move == 1) {
                    $X = intval($_POST['posicaoX']);
                    $Y = intval($_POST['posicaoY']);
                    $tamanho = intval($_POST['tamanho1']);
                }
                if ($move == 2) {
                    $X2 = intval($_POST['posicaoX2']);
                    $Y2 = intval($_POST['posicaoY2']);
                    $tamanho2 = intval($_POST['tamanho1']);
                }
                if ($move == 3) {
                    $X3 = intval($_POST['posicaoX3']);
                    $Y3 = intval($_POST['posicaoY3']);
                    $tamanho3 = intval($_POST['tamanho1']);
                }
                echo json_encode([
                    "posicaoX" => $X,
                    "posicaoX2" => $X2,
                    "posicaoX3" => $X3,
                    "posicaoY" => $Y,
                    "posicaoY2" => $Y2,
                    "posicaoY3" => $Y3,
                    "tamanho" => $tamanho,
                    "tamanho2" => $tamanho2,
                    "tamanho3" => $tamanho3,
                    "move" => $move,
                    "select1" => $select1,
                    "select2" => $select2,
                    "select3" => $select3
                ]);
            }
        } else {
            exit;
        }
    }

    public function gerador()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        require('util/fpdf/alphapdf.php');
        require('util/PHPMailer/class.phpmailer.php');

        // --------- Variáveis para gerar o certificado corretamente --------- //

        // $email = $_SESSION['email'];
        $nome = $_SESSION['nome'];
        $cpf = $_SESSION['cpf'];
        $X = intval($_POST['posicaoX']);
        $Y = intval($_POST['posicaoY']);
        $move = intval($_POST['move']);
        $tamanho = intval($_POST['tamanho']);
        $select1 = intval($_POST['select1']);
        $select2 = 0;
        $select3 = 0;
        $qntsAss = 1;

        if (isset($_POST['select2'])) {
            $select2 = intval($_POST['select2']);
            $qntsAss = 2;
            if (isset($_POST['select3'])) {
                $select3 = intval($_POST['select3']);
                $qntsAss = 3;
            }
        }

        // --------- SCRIPT do Banco de Dados --------- //
        $participante = $this->db->select(
            'SELECT
                *
            FROM
                participante p
            WHERE
                p.cpf = :cpf', array(":cpf" => $cpf));

        if ($participante != null) {
            $nome = utf8_decode($participante[0]->nome);
        }

        $assinaturas = $this->db->select(
            'SELECT
                *
            FROM
                assinaturas a
            WHERE
                a.sequencia = :ass
        ', array(":ass" => $select1));

        if ($select2 != 0) {
            $assinaturas2 = $this->db->select(
                'SELECT
                    *
                FROM
                    assinaturas a
                WHERE
                    a.sequencia = :ass
            ', array(":ass" => $select2));
        }

        if ($select3 != 0) {
            $assinaturas3 = $this->db->select(
                'SELECT
                    *
                FROM
                    assinaturas a
                WHERE
                    a.sequencia = :ass
            ', array(":ass" => $select3));
        }

        $InfoTopCertificado = $this->db->select(
            "SELECT
                p.sequencia seqParticipante,
                p.nome participante,
                p.email,
                p.cpf,
                e.sequencia seqEvento,
                e.nome nome_evento,
                DATE_FORMAT(e.dataentrada, '%d/%m/%Y') AS dataentrada,
                DATE_FORMAT(e.datafinal, '%d/%m/%Y') AS datafinal,
                e.ch,
                e.descricao,
                d.participantes,
                d.eventos
            FROM
                documentos d
            JOIN participante p ON
                p.sequencia = d.participantes
            JOIN evento e ON
                d.eventos = e.sequencia
            WHERE
                p.cpf = :cpf
            ", array(":cpf" => $cpf));

        // --------- Variáveis que podem vir de um banco de dados por exemplo ----- //
        $infoTop = "A Universidade de Marília - UNIMAR, nos termos do artigo 111, parágrafo 1°\ndo seu Regimento Geral, certifica que";
        $curso = utf8_decode($InfoTopCertificado[0]->nome_evento);
        $data = utf8_decode(" " . $InfoTopCertificado[0]->dataentrada . " a " . $InfoTopCertificado[0]->datafinal);
        $carga_h = " com carga horária total de " . $InfoTopCertificado[0]->ch . " horas";
        $descricao = $InfoTopCertificado[0]->descricao;
        $texto1 = utf8_decode($infoTop);
        $texto2 = utf8_decode("participou como ouvinte do\n ");
        $texto3 = utf8_decode("de " . $data . ", promovido pelo(a) " . $descricao . $carga_h . ".");

        // --------- Teste de assinaturas --------- //
        $printAss = $assinaturas[0]->caminho;
        if ($qntsAss == 2) {
            $printAss2 = $assinaturas2[0]->caminho;
        }
        if ($qntsAss == 3) {
            $printAss2 = $assinaturas2[0]->caminho;
            $printAss3 = $assinaturas3[0]->caminho;
        }

        $pdf = new AlphaPDF();

        // Orientação Londing Page ///
        $pdf->AddPage('C');

        $pdf->SetLineWidth(1.5);

        // desenha a imagem do certificado
        $pdf->Image('public/images/certificado.jpg', 0, 0, 295);

        // --------- Insere a assinatura no certificado (Se houver mais de uma assinatura, será mudado as posições) --------- //

        $pdf->Image($printAss, $X, $Y, $tamanho);
        if ($qntsAss == 2) {
            $X2 = $_POST['posicaoX2'];
            $Y2 = $_POST['posicaoY2'];
            $tamanho2 = $_POST['tamanho2'];
            $pdf->Image($printAss2, $X2, $Y2, $tamanho);
        }
        if ($qntsAss == 3) {
            $X2 = $_POST['posicaoX2'];
            $X3 = $_POST['posicaoX3'];
            $Y2 = $_POST['posicaoY2'];
            $Y3 = $_POST['posicaoY3'];
            $tamanho2 = $_POST['tamanho2'];
            $tamanho3 = $_POST['tamanho3'];
            $pdf->Image($printAss2, $X2, $Y2, $tamanho2);
            $pdf->Image($printAss3, $X3, $Y3, $tamanho3);
        }

        // opacidade total
        $pdf->SetAlpha(1);

        $pdf->SetFont('Arial', '', 14); // Tipo de fonte e tamanho
        $pdf->SetXY(16, 56); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(265, 7, $texto1, '', 'C', 0); // Tamanho width e height e posição

        // Mostrar o nome
        $pdf->SetFont('Arial', 'B', 14); // Tipo de fonte e tamanho
        $pdf->SetXY(22, 71); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(255, 14, $nome, '', 'C', 0); // Tamanho width e height e posição

        // Mostrar o corpo
        $pdf->SetFont('Arial', '', 14); // Tipo de fonte e tamanho
        $pdf->SetXY(17, 85); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(265, 10, $texto2, '', 'C', 0); // Tamanho width e height e posição

        // Mostra o curso
        $pdf->SetFont('Arial', 'B', 14); // Tipo de fonte e tamanho
        $pdf->SetXY(17, 98); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(265, 10, $curso, '', 'C', 0); // Tamanho width e height e posição

        // Mostrar o corpo
        $pdf->SetFont('Arial', '', 14); // Tipo de fonte e tamanho
        $pdf->SetXY(16, 109.5); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(265, 8, $texto3, '', 'C', 0); // Tamanho width e height e posição

        // gera o certificado e manda pro javascript
        $pdfdoc = $pdf->Output('', 'S');

        echo json_encode([
            "posicaoX" => $X,
            "posicaoY" => $Y,
            "tamanho" => $tamanho,
            "move" => $move,
            "qntAss" => $qntsAss,
            "aluno" => $participante,
            "arquivo" => "data:application/pdf;base64," . base64_encode($pdfdoc)
        ]);
    }

    public function selectAssinatura()
    {
        $sql = $this->db->select(
            "SELECT
                *
            FROM
                assinaturas a");
        echo json_encode($sql);
    }

    public function savePosition()
    {
        $dados = json_decode(file_get_contents('php://input'));
        $participantes = $dados->aluno;
        $assinatura1 = $dados->Ass;
        $assinatura2 = $dados->Ass2;
        $assinatura3 = $dados->Ass3;
        $tamanho = $dados->tamanho;

        $sql = $this->db->select(
            "SELECT
                COUNT(p.sequencia) numPositions
            FROM
                posicaotamanho p
            JOIN documentos d ON
                p.documento = d.sequencia
            WHERE
                d.participantes = :seq",
                array(":seq" => $participantes[0]->sequencia)
        );
        $sql2 = $this->db->select(
            "SELECT
                sequencia
            FROM
                documentos d
            WHERE
                d.participantes = :seq",
                array(":seq" => $participantes[0]->sequencia)
        );

        $msg = array("codigo" => 0, "texto" => "Não foi possível salvar");

        $dados = array(
            [
                "posicaoX" => $assinatura1[0],
                "posicaoY" => $assinatura1[1],
                "tamanho" => $tamanho[0],
                "documento" => $sql2[0]->sequencia
            ],
            [
                "posicaoX" => $assinatura2[0],
                "posicaoY" => $assinatura2[1],
                "tamanho" => $tamanho[1],
                "documento" => $sql2[0]->sequencia
            ],
            [
                "posicaoX" => $assinatura3[0],
                "posicaoY" => $assinatura3[1],
                "tamanho" => $tamanho[2],
                "documento" => $sql2[0]->sequencia
            ]
        );
        // var_dump($dados[2]); exit;

        if ($sql[0]->numPositions <= 3) {

            if ($assinatura2[0] == null && $assinatura3[0] == null) {
                $result = $this->db->insert("asscertificado.posicaotamanho", $dados[0]);
                $msg = array("codigo" => 1, "texto" => "Salvo com sucesso");
            } else if ($assinatura2[0] != null && $assinatura3[0] == null) {
                $result = $this->db->insert("asscertificado.posicaotamanho", $dados[0]);
                $result = $this->db->insert("asscertificado.posicaotamanho", $dados[1]);
                $msg = array("codigo" => 1, "texto" => "Salvo com sucesso");
            } else if ($assinatura2[0] != null && $assinatura3[0] != null) {
                $result = $this->db->insert("asscertificado.posicaotamanho", $dados[0]);
                $result = $this->db->insert("asscertificado.posicaotamanho", $dados[1]);
                $result = $this->db->insert("asscertificado.posicaotamanho", $dados[2]);
                $msg = array("codigo" => 1, "texto" => "Salvo com sucesso");
            }
        }

        Session::destroy();
        
        echo json_encode($msg);
    }
}