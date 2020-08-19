<?php

function dataCleaning ($data) {

    require_once('cleanSpecialCharacters.php');

    $data=trim($data);
    $data=strip_tags($data);
    $data=htmlspecialchars($data);
    $data=strtolower($data);
    $data=cleanSpecialCharacters($data);

    return $data;
}