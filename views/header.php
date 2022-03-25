<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->title; ?></title>

    <link rel="sortcut icon" href="<?= URL; ?>public/images/iconPage.jpg" type="image/jpg"/>

    <!-- Bootstrap -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.1/mdb.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= URL; ?>public/MDB/css/mdb.min.css"/>
    <link rel="stylesheet" href="<?= URL; ?>public/fontawesome/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"/>
    <link rel="stylesheet" href="<?= URL; ?>public/css/main.css"/>

    <!-- CSS --->

    <?php
    if (isset($this->css)) {
        foreach ($this->css as $css) {
            echo '<link rel="stylesheet" href="' . URL . 'views/' . $css . '"/>';
        }
    }
    ?>

</head>
<body style="background-color: #005BAA">
<div class="text-center">
    <img src="https://oficial.unimar.br/wp-content/themes/unimarpresencial/images/logo.svg" width="150" height="50">
</div>
<div style="
    margin-left: 40px;
    margin-right: 40px;
    padding-left: 12px;
    background-color: white;
    border-radius: 8px">