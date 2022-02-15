<?php

class Index_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ImageBackgroundRemove()
    {
        $im = imagecreatefromjpeg('test/ass_test.jpg');
        imagecolortransparent($im);
        imagefilledrectangle($im, 200, 115, 300, 137);

        imagealphablending($im, false);
        imagesavealpha($im, true);

        header ('Content-Type: image/png');

        imagepng($im);

        $save = "public/images/ass_copy.png";

        imagepng($im, $save);
        imagedestroy($im);
    }

    public function getDados()
    {
        $aluno = $this->db->select(
            "SELECT
                    sequencia,
                    nome,
                    email,
                    cpf
                FROM
                    alunos a"
        );
        echo json_encode($aluno);
    }
}