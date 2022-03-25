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
        $X = 120;
        $X2 = 120;
        $X3 = 120;
        $Y = 140;
        $tamanho = 60;

        if ($ass2 != 0 && $ass3 == 0) {
            $qntsAss = 2;
        }
        if ($ass2 != 0 && $ass3 != 0) {
            $qntsAss = 3;
        }

        $move = intval($_POST['AssMove']);

        // --------- SCRIPT do Banco de Dados --------- //
        $assinaturas = $this->db->select('
            SELECT
                sequencia,
                caminho
            FROM
                assinaturas a
            WHERE
                a.sequencia = :ass', array(":ass" => $ass));

        if ($qntsAss > 1) {
            $assinaturas2 = $this->db->select('
                SELECT
                    sequencia,
                    caminho
                FROM
                    assinaturas a
                WHERE
                    a.sequencia = :ass', array(":ass" => $ass2));

            $assinaturas3 = $this->db->select('
                SELECT
                    sequencia,
                    caminho
                FROM
                    assinaturas a
                WHERE
                    a.sequencia = :ass', array(":ass" => $ass3));
        }

        $participante = $this->db->select('SELECT
                *
            FROM
                participante p
            WHERE
                p.cpf = :cpf', array(":cpf" => $cpf));

        if ($participante != null) {
            $nome = utf8_decode($participante[0]->nome);
        }

        $InfoTopCertificado = $this->db->select("
            SELECT
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
                pe.sequencia_participante,
                pe.evento
            FROM
                participante_evento pe
            JOIN participante p ON
                p.sequencia = pe.sequencia_participante
            JOIN evento e ON
                pe.evento = e.sequencia
            WHERE
                p.cpf = :cpf
            ", array(":cpf" => $cpf));

        $seqEvento = $InfoTopCertificado[0]->seqEvento;

        // --------- Variáveis do Formulário ----- //
        if ($email == null
            || $nome == null
            || $cpf == null
            || $ass == 0) {
            exit;
        } else {

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
            if ($qntsAss > 1) {
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
            /*if ($ass2 != 0) {
                $X = 20;
                $X2 = 210;
                $Y2 = 140;
                $dados2 = [
                    "posicaoX" => $X2,
                    "posicaoY" => $Y2,
                    "tamanho" => $tamanho,
                    "evento" => $InfoTopCertificado[0]->seqEvento
                ];

                $insereInfoBD2 = $this->db->insert("asscertificado.posicaotamanho", $dados2);
            }
            if ($ass3 != 0) {
                $X = 20;
                $X3 = 120;
                $Y3 = 140;
                $dados3 = [
                    "posicaoX" => $X3,
                    "posicaoY" => $Y3,
                    "tamanho" => $tamanho,
                    "evento" => $InfoTopCertificado[0]->seqEvento
                ];

                $insereInfoBD3 = $this->db->insert("asscertificado.posicaotamanho", $dados3);
            }

            $dados = [
                "posicaoX" => $X,
                "posicaoY" => $Y,
                "tamanho" => $tamanho,
                "evento" => $InfoTopCertificado[0]->seqEvento
            ];

            $insereInfoBD = $this->db->insert("asscertificado.posicaotamanho", $dados);*/

            $buscaInfoBD = $this->db->select("
                SELECT
                    p.sequencia seqPT,
                    p.posicaoX,
                    p.posicaoY,
                    p.tamanho,
                    e.sequencia seqEvento,
                    e.nome,
                    e.descricao,
                    e.ch,
                    e.dataentrada,
                    e.datafinal,
                    p2.sequencia,
                    p2.nome,
                    p2.cpf
                FROM
                    posicaotamanho p
                JOIN evento e ON
                    e.sequencia = p.evento
                JOIN participante_evento pe ON
                    pe.evento = e.sequencia
                JOIN participante p2 ON
                    pe.sequencia_participante = p2.sequencia
                WHERE
                    p2.cpf = :cpf
            ", array(":cpf" => $cpf));

            $X = $buscaInfoBD[2]->posicaoX;
            $X2 = $buscaInfoBD[1]->posicaoX;
            $X3 = $buscaInfoBD[0]->posicaoX;
            $Y = $buscaInfoBD[2]->posicaoY;
            $Y2 = $buscaInfoBD[1]->posicaoY;
            $Y3 = $buscaInfoBD[0]->posicaoY;
            $tamanho = $buscaInfoBD[2]->tamanho;
            $tamanho2 = $buscaInfoBD[1]->tamanho;
            $tamanho3 = $buscaInfoBD[0]->tamanho;

            /*$dados = [
                "posicaoX" => $X,
                "posicaoY" => $Y,
                "tamanho" => $tamanho,
                "evento" => $InfoTopCertificado[0]->seqEvento
            ];

            $insereInfoBD = $this->db->update("asscertificado.posicaotamanho", $dados, "evento='$seqEvento'");*/

            $pdf->Image($printAss, $X, $Y, $tamanho);
            if ($qntsAss > 1) {
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
                "posicaoX2" => $X2,
                "posicaoX3" => $X3,
                "posicaoY" => $Y,
                "posicaoY2" => $Y2,
                "posicaoY3" => $Y3,
                "move" => $move,
                "qntAss" => $qntsAss,
                "aluno" => $participante,
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
        $msg = array("codigo" => 0, "texto" => "Falha ao salvar.");

        Session::destroy();

        echo json_encode($msg);
    }
}