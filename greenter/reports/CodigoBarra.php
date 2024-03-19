<?php

use Com\Tecnick\Barcode\Barcode;

require_once '../vendor/autoload.php';

class codigoBarra
{
    private $data;
    private $name;

    /**
     * codigoBarra constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function generate()
    {
        $barcode = new Barcode();

        $bobj = $barcode->getBarcodeObj(
            "C39",            // Tipo de Barcode o Qr
            $this->data,    // Datos
            0,            // Width
            -100,            // Height
            'black',        // Color del codigo
            array(0, 0, 0, 0)    // Padding
        );

        $imageData = $bobj->getPngData(); // Obtenemos el resultado en formato PNG

        file_put_contents('temp/' . $this->name . '.png', $imageData); // Guardamos el resultado
    }
}