<?php

session_start();

if ($_POST) {

    require_once('Util.php');
    require_once('Kohonen.php');
    require_once('Kmeans.php');

    $redesNeurais = unserialize($_SESSION['redeTreinada']);
    echo json_encode($redesNeurais->iniciarClassificaoLetra(Util::getLetraClassificacao($_POST['letra'], $_POST['tipo'])));
}