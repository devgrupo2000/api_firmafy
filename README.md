
![alt text](https://firmafy.com/wp-content/uploads/2019/10/logo_con_fondo.PNG "Logo Firmafy")
# API Firmafy

### ¡Nuevas funciones!
  - [Obtener_Ruta_Documento](https://github.com/devgrupo2000/api_firmafy/blob/master/api_obtener_ruta_documento.php): Podrá obtener la ruta del documento original firmado y de la auditoría
  - [Solicitar_Firma](https://github.com/devgrupo2000/api_firmafy/blob/master/api_solicitar_firma.php): Poder enviar los firmantes para un documento cuya plantilla ha sido previamente creada

### Instalacion
API Firmafy requiere [PHP](https://www.php.net/releases/7_2_0.php) v7.2+ para ejecutarse.

Instala las dependencias:

```sh
$ apt-get install php-curl
```
Asegúrate usando `phpinfo()` que la extensión `curl` quedó correctamente instalada
![alt text](https://firmafy.com/wp-content/uploads/2019/10/curl.PNG "curl habilitado")

##### Configuración de credenciales y uso del servicio
Una vez hecho esto, para iniciar a usar la API, deben configurarse las credenciales del servicio en el archivo `Firmafy.php`
```php
        $this -> _user = 'USUARIO app.firmafy.com';
        $this -> _password = 'CLAVE app.firmafy.com';
```

##### Ejemplo solicitar firma
 Para poder enviar la información de los firmantes junto al documento, primero debes conocer cual es tu `id_show` (id cliente). Puedes hacerlo de la siguiente manera:
 ```php
 <?php
    include 'Firmafy.php';
    $api = new firmafy();

    $data = array(
        'action'  => 'Consultar_Cliente_Nif',
        'cif' => '99999999', // cif / nif
    );
    $new_plan = $api -> setData($data) -> send();
    $new_plan = json_decode($new_plan);
    $id_show = $new_plan->data->id_show; // En este punto ya conoceríamos el valor de id_show
    echo $id_show; // Si queremos, podemos mostrarlo para comprobar cual es
?>
 ``` 
 
 Una vez se conozcas el valor de `id_show`, puedes proceder a enviar la información de los firmantes junto al documento indicando la plantilla a usar. 
 
```php
<?php
    include 'Firmafy.php';
    $api = new firmafy();

    $firmantes = array();
    // Firmante 1
    $firmantes[] = array(
        'role'     => 'PERSONA FÍSICA', // PERSONA FÍSICA | PERSONA JURÍDICA
        'nombre'   => 'Jhon Smith',
        'nif'      => '12345678A',
        'cargo'    => 'Gerente',        // Administrador | Responsable | Gerente
        'email'    => 'jhon@email.com',
        'telefono' => '111111111',
        'empresa'  => '',
        'cif'      => '',
        'type_notifications' => 'email'
    );
    //Firmante 2
    $firmantes[] = array(
        'role'     => 'PERSONA FÍSICA', // PERSONA FÍSICA | PERSONA JURÍDICA
        'nombre'   => 'Susan Miller',
        'nif'      => '12345678A',
        'cargo'    => 'Gerente',        // Administrador | Responsable | Gerente
        'email'    => 'susan@email.com',
        'telefono' => '111111111',
        'empresa'  => '',
        'cif'      => '',
        'type_notifications' => 'sms'
    );
    
    $data = array(
        'action'  => 'Consultar_Cliente_Nif',
        'cif' => '99999999', // cif / nif
    );
    $new_plan = $api -> setData($data) -> send();
    $new_plan = json_decode($new_plan);
    $id_show = $new_plan->data->id_show;

    $data = array(
        'action'  => 'Solicitar_Firma',
        'id_show' =>  $id_show,           //id cliente, es decir, el id_show obtenido previamente
        'template_name' => 'Plantilla 001',
        'template_session'=> false,
        'fecha_vencimiento' => (Si no se indica este parámetro no tiene caducidad) **el formato es: Y-m-d H:i:s
        'signer' => json_encode($firmantes),
        'pdf' => curl_file_create(__DIR__.'/Documento.pdf','application/pdf','Documento.pdf') 
        ** en caso de enviar en base_64 ** sustituir 'pdf' por 'pdf_base64'
    );

    $new_plan = $api -> setData($data) -> send();
    $new_plan = json_decode($new_plan);
?>
```
