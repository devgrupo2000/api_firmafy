<?php

    include 'Firmafy.php';
    $api = new firmafy();
    $data = array(
        'action'  => 'obtener_ruta_documento',
        'csv' => '99999999', //csv
    );
    $document_path = $api -> setData($data) -> send();
    $document_path = json_decode($document_path);

    $url_documento_firmado = $document_path->data->url_documento_firmado;
    $url_documento_auditoria = $document_path->data->url_documento_auditoria;