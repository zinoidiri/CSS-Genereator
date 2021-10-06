<?php

//creation d'une fonction scan et sa recursive, pour mettre toutes les images .png dans un tableau 


function my_scandir($dir_name, &$array_png){

   if (is_dir($dir_name) && $dir_open = opendir($dir_name)) {

       while (($images = readdir($dir_open)) !== false) {
          
            if (($images != '.' && $images != '..') && (preg_match('#.png#', $images))) {
               $array_png[] = $dir_name . '/' . $images;
               var_dump($array_png);
           }
       }
       closedir($dir_open);
       
   } else {
       echo "Le dossier n'existe pas.\n";
   }
       
       return $array_png;
}

//my_scandir('images', $array_png);
 


function my_scandir_recursive($dir_name, &$array_png) {
    if(is_dir($dir_name) && $dir_open = opendir($dir_name)) {
        while (($images = readdir($dir_open)) !== false) {

            if($images !== '.' && $images !== '..') {

                if(preg_match('#.png#', $images)) {
                    $array_png[] = $dir_name . '/' . $images;
                }

                my_scandir_recursive($dir_name . '/' . $images, $array_png);
            }
            
		}
		var_dump($array_png);
        closedir($dir_open);
        
    }
}

my_scandir_recursive('images', $array_png);

//créer 

function create_image($array_png)
{
    global $array_png;
    $height_P = 0;
    $width_P = 0;
   
    foreach ($array_png as $value) {
        $img_width = imagesx(imagecreatefrompng($value));
        $width_P = $width_P + ($img_width);

        $img_height = imagesy(imagecreatefrompng($value));
        if ($img_height > $height_P) {
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
   
    imagepng($img,"mon_image.png");
    imagedestroy($img);
}

create_image($array_png);


function css_file($array_png) {
    
    $file = fopen('style.css', 'w+');

    static $increment = 1;
    $hauteur_min = 0;

    foreach ($array_png as $value) {
        $hauteur = imagesy(imagecreatefrompng($value));
        $largeur = imagesx(imagecreatefrompng($value));
        fwrite(
            $file, ".images" . $increment ."
            {
             background: url('mon_image.png');
             display: inline-block;
             background-repeat: no-repeat;
             background-position: " . $hauteur_min . "px 0px;
             width: " . $largeur . "px;
             height: " . $hauteur . "px;  
            }\n"
        );
        $increment += 1;
        $hauteur_min -= $largeur;
    }
}

css_file($array_png);