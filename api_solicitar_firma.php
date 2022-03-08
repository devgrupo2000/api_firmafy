<?php
    include 'Firmafy.php';
    $api = new firmafy();

    $firmantes = array();
    // Firmante 1
    $firmantes[] = array(
        'role'     => 'PERSONA FÍSICA', // PERSONA FÍSICA | PERSONA JURÍDICA
        'nombre'   => 'Jhon Smith',
        'nif'      => '12345678A',
        'cargo'    => 'Gerente',
        'email'    => 'jhon@email.com',
        'telefono' => '111111111',
        'empresa'  => '',
        'cif'      => ''
    );
    //Firmante 2
    $firmantes[] = array(
        'role'     => 'PERSONA FÍSICA', // PERSONA FÍSICA | PERSONA JURÍDICA
        'nombre'   => 'Susan Miller',
        'nif'      => '12345678A',
        'cargo'    => 'Gerente',
        'email'    => 'susan@email.com',
        'telefono' => '111111111',
        'empresa'  => '',
        'cif'      => ''
    );
    

    $data = array(
        'action'  => 'request',
        'id_show' => '0000000000000000000',//id cliente
        'template_name' => 'Plantilla 001',
        'signer' => json_encode($firmantes),
        'pdf' => curl_file_create(__DIR__.'/Documento.pdf','application/pdf','Documento.pdf')
    );

    $new_plan = $api -> setData($data) -> send();
    $new_plan = json_decode($new_plan);

    echo 'Error: '.$new_plan -> error;
    echo '<br>';
    echo 'Message: '.$new_plan -> message;
    echo '<br>';
    echo 'CSV: '.$new_plan -> data;
?>
