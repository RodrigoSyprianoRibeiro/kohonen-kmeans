<?php

if ($_POST) {

    require_once('Util.php');

    echo json_encode(Util::gerarLetraAleatoria($_POST['tipo']));
}