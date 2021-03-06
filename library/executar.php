<?php

session_start();

if ($_POST) {

    require_once('Util.php');

    unset($_SESSION['redeTreinada']);

    if ($_POST['algoritmo'] == 'kohonen') {
        require_once('Kohonen.php');
        $redesNeurais = new Kohonen($_POST);
    } else {
        require_once('Kmeans.php');
        $redesNeurais = new Kmeans($_POST);
    }

    $redesNeurais->iniciarTreinamento(Util::getLetrasTreinamento($_POST['tipo']));

    $_SESSION['redeTreinada'] = serialize($redesNeurais);

    echo json_encode($redesNeurais->iniciarClassificaoExemplos(Util::getLetrasTreinamento($_POST['tipo'])));
}