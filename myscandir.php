<?php

 function my_scandir($dir_name){

    if (is_dir($dir_name) && $dir_open = opendir($dir_name)) {

        while (($images = readdir($dir_open)) !== false) {
           
             if (($images != '.' && $images != '..') && (preg_match('#.png#', $images))) {
                $array_png[] = $dir_name . '/' . $images;
                
            }
        }
       
        closedir($dir_open);
        
    } else {
        echo "Le dossier n'existe pas.\n";
    }
    var_dump($array_png);
        return $array_png;
        
 }
 
 my_scandir('images');

function my_scandir_recursive($dir_name) {
    if(is_dir($dir_name) && $dir_open = opendir($dir_name)) {
        while (($images = readdir($dir_open)) !== false) {

            if($images !== '.' && $images !== '..') {

                if(preg_match('#.png#', $images)) {
                    $array_png[] = $dir_name . '/' . $images;
                }

                my_scandir_recursive($dir_name . '/' . $images, $array_png);
            }
            
        }var_dump($array_png);
        closedir($dir_open);
        
    }
}

my_scandir_recursive('images');