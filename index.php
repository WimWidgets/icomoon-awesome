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
        <title>Icomoon Awesome</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .form-control {
                max-width: 290px;
            }
            input[type="file"] {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1>Icomoon Awesome</h1>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="zip">Icomoon style.css</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-file-archive-o" aria-hidden="true"></span></span>
                                <div class="form-control">
                                    <input type="file" name="css" id="css">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit"><span class="fa fa-refresh" aria-hidden="true"></span> Convert</button>
                    </form>
                    <?php
                    if (!empty($feedback)) {
                        echo '<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> '.$feedback.'</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#css').on('change', function() {
                    var file = $(this).val().split('\\').pop();
                    $(this).next().html(file);
                });
            });
        </script>
    </body>
</html>