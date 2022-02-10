
<?php
class Index_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function ImageBackgroundRemove()
    {
        $image = '/test/ass.jpg';
        var_dump($image); exit;
        $img = imagecreatefromstring($image); //or whatever loading function you need
        $white = imagecolorallocate($img, 255, 255, 255);
        imagecolortransparent($img, $white);
        // imagepng($img, $output_file_name);
    }
}