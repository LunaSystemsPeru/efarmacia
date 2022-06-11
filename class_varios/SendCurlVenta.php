<?php


class SendCurlVenta
{
    private $id_tido;
    private $id_venta;
    private $periodo;
    private $ruta;

    /**
     * SendCurlVenta constructor.
     */
    public function __construct()
    {
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $rutabase= dirname(dirname($url)) . DIRECTORY_SEPARATOR;
        $this->ruta = $rutabase;
    }

    /**
     * @return mixed
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @param mixed $periodo
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    /**
     * @param mixed $id_tido
     */
    public function setIdTido($id_tido)
    {
        $this->id_tido = $id_tido;
    }

    /**
     * @param mixed $id_venta
     */
    public function setIdVenta($id_venta)
    {
        $this->id_venta = $id_venta;
    }

    function enviar_json() {
        //$this->llenar_venta();
        $post = [
            'id_venta' => $this->id_venta,
            'periodo'=>$this->periodo,
            'id_empresa' => $_SESSION["id_empresa"],
        ];

        $archivo = "factura";
        if ($this->id_tido == 3) {
            $archivo = "factura";
        }
        if ($this->id_tido == 2) {
            $archivo = "boleta";
        }
        $ruta = $this->ruta . "greenter/generates/" . $archivo . ".php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($ch);
        curl_close($ch);

        //echo $ruta;

        return $respuesta;
    }

    function generar_pdf() {
        $post = [
            'id_venta' => $this->id_venta,
        ];

        $archivo = "";
        if ($this->id_tido == 2 || $this->id_tido == 1) {
            $archivo = "documento_venta";
        }

        $ruta = $this->ruta . "reports/" . $archivo . ".php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($ch);
        curl_close($ch);

        return $respuesta;
    }
}