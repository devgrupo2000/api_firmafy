<?php
    include 'Firmafy.php';
    $api = new firmafy();

    $data = array(
        'action'  => 'Consultar_Cliente_Nif',
        'cif' => '99999999', // cif / nif
    );
    echo $new_plan = $api -> setData($data) -> send();
    $new_plan = json_decode($new_plan);
   
?>
