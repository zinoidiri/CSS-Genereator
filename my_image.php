<?php

function create_image($array_png)
{
    global $array_png;
    $height_P = 0;
    $width_P = 0;
    foreach ($array_png as $value) {
        $img_width = imagesx(imagecreatefrompng($value));
        $width_P = $width_P + ($img_width);

        $img_height = imagesy(imagecreatefrompng($value));
        if ($img_height > $height_total) {
            $height_P = ($img_height);
        }
    }
    $width = 0;
    $height = 0;
    $img = imagecreatetruecolor($width_P, $height_P);
    $background = imagecolorallocatealpha($img, 255, 255, 255, 127);
    imagefill($img, 0, 0, $background);
    imagealphablending($img, false);
    imagesavealpha($img, true);
    foreach ($array_png as $value) {
        $image = imagecreatefrompng($value);
        $largeur = imagesx($image);
        $hauteur = imagesy($image);
        imagecopy($img, $image, $width, 0, 0, 0, $largeur, $hauteur);
        $width = $width + ($largeur);


    }
    imagepng($img,".png");
    imagedestroy($img);
}

create_image($array_png);