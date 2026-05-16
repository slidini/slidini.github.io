<?php
require_once __DIR__ . '/autoload.php';

session_start();

if (isset($_SESSION['sessionInput'])) {
    $input = $_SESSION['sessionInput'];
}else{
    $input = '';
}

if (isset($_SESSION['sessionItype'])) {
    $iType = $_SESSION['sessionItype'];
}else{
    $iType = '';
}

if (isset($_SESSION['sessionOtype'])) {
    $oType = $_SESSION['sessionOtype'];
}else{
    $oType = '';
}

$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iType = $_POST['input-types'];
    $oType = $_POST['output-types'];
    $input = $_POST['inputText'];
    $_SESSION['sessionInput'] = $input;
    $_SESSION['sessionItype'] = $iType;
    $_SESSION['sessionOtype'] = $oType;

    $serializer = new \App\Serializer();
    $iArray = $serializer->deserialize($input, $iType);
    $output = $serializer->serialize($iArray, $oType);
}

require_once __DIR__ . '/templates/layout.php';