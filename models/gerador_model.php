<?php

class Gerador_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
        Session::init();
        Auth::autentica();
    }

    public function gerador()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        require('util/fpdf/alphapdf.php');
        require('util/PHPMailer/class.phpmailer.php');

        // --------- Variáveis para gerar o certificado corretamente --------- //

        $email = $_SESSION['email'];
        $nome = $_SESSION['nome'];
        $cpf = $_SESSION['cpf'];
        $ass = intval($_POST['selectAss1']);
        $ass2 = intval($_POST['selectAss2']);
        $ass3 = intval($_POST['selectAss3']);
        $qntsAss = 1;
        $printAss = "";
        $printAss2 = "";
        $printAss3 = "";

        $move = intval($_POST['AssMove']);

        $X = intval($_POST['posicaoX']);
        $X2 = 0;
        $X3 = 0;
        $Y = intval($_POST['posicaoY']);
        $Y2 = 0;
        $Y3 = 0;
        $T = intval($_POST['tamanho']);
        if ($T == 0) {
            $T = 60;
        }

        // --------- SCRIPT do Banco de Dados --------- //

        $alunos = $this->db->select('SELECT
                *
            FROM
                alunos a
            WHERE
                a.cpf = :cpf', array(":cpf" => $cpf));

        if ($alunos != null) {
            $nome = utf8_decode($alunos[0]->nome);
        }

        $posicaotamanho = $this->db->select('SELECT
                *
            FROM
                posicaotamanho p
            JOIN assinaturas a ON
                p.assinatura = a.sequencia
            WHERE
                p.assinatura = :ass', array(":ass" => $ass));

        $assinaturas = $this->db->select('
            SELECT
                sequencia,
                caminho
            FROM
                assinaturas a
            WHERE
                a.sequencia = :ass', array(":ass" => $ass));

        $assinaturas2 = $this->db->select('
            SELECT
                sequencia,
                caminho caminho2
            FROM
                assinaturas a
            WHERE
                a.sequencia = :ass', array(":ass" => $ass2));

        $assinaturas3 = $this->db->select('
            SELECT
                sequencia,
                caminho caminho3
            FROM
                assinaturas a
            WHERE
                a.sequencia = :ass', array(":ass" => $ass3));

        $InfoTopCertificado = $this->db->select("
            SELECT
                e.sequencia,
                e.nome evento,
                e.ch,
                DATE_FORMAT(e.dataentrada, '%d/%m/%Y') AS dataentrada,
                DATE_FORMAT(e.datafinal, '%d/%m/%Y') AS datafinal,
                e.descricao
            FROM
                evento e
            JOIN alunos a ON
                e.aluno = a.cpf
            WHERE
                e.aluno = :cpf", array(":cpf" => $cpf));

        // --------- Variáveis do Formulário ----- //
        if ($email == null
            || $nome == null
            || $cpf == null
            || $ass == 0) {
            exit;
        } else {

            // --------- Variáveis que podem vir de um banco de dados por exemplo ----- //
            $infoTop = "A Universidade de Marília - UNIMAR, nos termos do artigo 111, parágrafo 1°\ndo seu Regimento Geral, certifica que";
            $curso = utf8_decode($InfoTopCertificado[0]->evento);
            $data = utf8_decode(" " . $InfoTopCertificado[0]->dataentrada . " a " . $InfoTopCertificado[0]->datafinal);
            $carga_h = " com carga horária total de " . $InfoTopCertificado[0]->ch . " horas";
            $descricao = $InfoTopCertificado[0]->descricao;
            $texto1 = utf8_decode($infoTop);
            $texto2 = utf8_decode("participou como ouvinte do\n ");
            $texto3 = utf8_decode("de " . $data . ", promovido pelo(a) " . $descricao . $carga_h . ".");

            // --------- Teste de assinaturas --------- //
            $printAss = $assinaturas[0]->caminho;
            $printAss2 = $assinaturas2[0]->caminho2;
            $printAss3 = $assinaturas3[0]->caminho3;

            $pdf = new AlphaPDF();

            // Orientação Londing Page ///
            $pdf->AddPage('C');

            $pdf->SetLineWidth(1.5);

            // desenha a imagem do certificado
            $pdf->Image('public/images/certificado.jpg', 0, 0, 295);

            // --------- Insere a assinatura no certificado (Se houver mais de uma assinatura, será mudado as posições) --------- //
            if ($ass2 == 0 && $ass3 == 0) {
                // ------ Movimentação Individual ------
                $X = intval($_POST['posicaoX']);
                $pdf->Image($printAss, $X, $Y, $T);
            } else {
                $X = 20;
                $Y = 140;
            }
            if ($ass2 != 0) {
                $qntsAss += 1;
                $X2 = 210;
                $Y2 = 140;
                // ------ Movimentação Individual ------
                if ($move == 1) {
                    $X = intval($_POST['posicaoX']);
                    $Y = intval($_POST['posicaoY']);
                }
                if ($move == 2) {
                    $X2 = intval($_POST['posicaoX2']);
                    $Y2 = intval($_POST['posicaoY2']);
                }

                $pdf->Image($printAss, $X, $Y, $T);
                $pdf->Image($printAss2, $X2, $Y2, $T);
            }
            if ($ass2 != 0 && $ass3 != 0) {
                $X3 = 120;
                $Y3 = 140;
                $qntsAss += 1;
                // ------ Movimentação Individual ------
                if ($move == 3) {
                    $X3 = intval($_POST['posicaoX3']);
                    $Y3 = intval($_POST['posicaoY3']);
                }
                $pdf->Image($printAss3, $X3, $Y3, $T);
            }
            if ($ass3 != 0 && $ass2 == 0) {
                $X3 = 210;
                $Y3 = 140;
                $qntsAss += 1;
                // ------ Movimentação Individual ------
                if ($move == 1) {
                    $X = intval($_POST['posicaoX']);
                    $Y = intval($_POST['posicaoY']);
                }
                if ($move == 3) {
                    $X3 = intval($_POST['posicaoX3']);
                    $Y3 = intval($_POST['posicaoY3']);
                }
                $pdf->Image($printAss, $X, $Y, $T);
                $pdf->Image($printAss3, $X3, $Y3, $T);
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
                "posicaoX2" => $X2,
                "posicaoX3" => $X3,
                "posicaoY" => $Y,
                "posicaoY2" => $Y2,
                "posicaoY3" => $Y3,
                "move" => $move,
                "tamanho" => $T,
                "qntAss" => $qntsAss,
                "aluno" => $alunos,
                "arquivo" => "data:application/pdf;base64," . base64_encode($pdfdoc)
            ]);
        }
    }

    public function selectAssinatura()
    {
        $sql = $this->db->select("
            SELECT
                *
            FROM
                assinaturas a");
        echo json_encode($sql);
    }

    public function savePosition()
    {
        $posicoes = json_decode(file_get_contents('php://input'));
        $Ass = $posicoes->Ass;
        $Ass2 = $posicoes->Ass2;
        $Ass3 = $posicoes->Ass3;
        $aluno = $posicoes->aluno;
        $tamanho = $posicoes->tamanho;

        $sql = $this->db->select('SELECT
                p.sequencia,
                p.posicaoX,
                p.posicaoY,
                p.tamanho,
                a.sequencia as assinatura,
                a.nomeassinatura,
                a2.nome,
                a2.email,
                a2.cpf
            FROM
                posicaotamanho p
            JOIN assinaturas a ON
                p.assinatura = a.sequencia
            JOIN alunos a2 ON
                p.aluno = a2.sequencia
            WHERE
                a2.cpf = :ass', array(":ass" => $aluno[0]->cpf));

        $dados = [
            'aluno' => $aluno[0]->sequencia,
            'posicaoX' => $Ass[0],
            'posicaoY' => $Ass[1],
            'tamanho' => $tamanho[0]
        ];
        $aluno = $aluno[0]->sequencia;
        $msg = array("codigo" => 0, "texto" => "Falha ao salvar.");

//        if ($aluno == null) {
////            $result = $this->db->insert("asscertificado.posicaotamanho", $dados);
//            $msg = array("codigo" => 1, "texto" => "Adicionado com sucesso.");
//        } else {
////            $result = $this->db->update("asscertificado.posicaotamanho", $dados, "aluno='$aluno'");
//            $msg = array("codigo" => 1, "texto" => "Atualizado com sucesso.");
//        }

        Session::destroy();

        echo json_encode($msg);
    }
}