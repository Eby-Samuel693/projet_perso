<?php

use MinichatProjet\Classes\DB;
require_once $_SERVER["DOCUMENT_ROOT"] . '/Modele/Entity/pic.php';


/**
 * Creat a random string for the files names.
 * @param String $nameRan
 * @return string
 */
function getRandomName(String $nameRan): string {
    $infos = pathinfo($nameRan);
    try {
        $bytes = random_bytes(15);
    }
    catch (Exception $e) {
        $bytes = openssl_random_pseudo_bytes(15);
    }
    return bin2hex($bytes) . '.' . $infos['extension'];
}

if (isset($_FILES["img"]) && $_FILES["img"]["error"] === 0) {

    $allowedMimeType = ['text/plain', 'image/jpeg', 'image/jpeg'];
    if(in_array($_FILES['img']['type'], $allowedMimeType)) {

        $maxSize = 8 * 4096 * 4096; // = 8 mo
        if((int)$_FILES['img']['size'] <= $maxSize) {

            $tmp_name = $_FILES['img']["tmp_name"];
            $name = $_FILES["img"]["name"];
            $name = getRandomName($name);
            move_uploaded_file($tmp_name, '../pic/' . $name);

            $request = DB::connectDB()->prepare("INSERT INTO pic (img) VALUES ( :img)");
            $request->execute(array($name));

            header('location: ../galerie.php');
        }
        else {
            echo ' le fichier  est trop volumineux';
        }
    }
    else {
        echo 'une erreur est survenue :o';
    }
}

