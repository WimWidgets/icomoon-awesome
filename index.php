<?php

namespace Widgets\Icomoon;

require_once __DIR__.'/autoloader.php';

$feedback = '';
if (isset($_FILES['css'])) {
    try {
        $converter = new Converter();
        $converter->setRootPath(__DIR__);
        $zip = $converter->convert('css');
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename="'.basename($zip).'"');
        echo file_get_contents($zip);
        exit;
    } catch (\RuntimeException $e) {
        $feedback = $e->getMessage();
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="msapplication-config" content="none">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    </head>
    <body>
        <?php
            if (!empty($feedback)) {
                echo '<p>'.$feedback.'</p>';
            }
        ?>
        <form method="post" enctype="multipart/form-data">
            <label for="zip">Icomoon style.css</label><br>
            <input type="file" name="css" id="css"><br>
            <button type="submit">Convert</button>
        </form>
    </body>
</html>