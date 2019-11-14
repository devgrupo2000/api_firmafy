<?php

/*
	Ejemplo de cómo obtener el valor de id_show dado el cif/nif
*/

    include 'Firmafy.php';
    $api = new firmafy();

    $data = array(
        'action'  => 'Consultar_Cliente_Nif',
        'cif' => '99999999', // cif / nif
    );
    $new_plan = $api -> setData($data) -> send();
    $new_plan = json_decode($new_plan);
    $id_show = $new_plan->data->id_show;

    echo $id_show;
?>
