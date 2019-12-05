<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cl_caja_diaria
 *
 * @author luis
 */

include 'cl_conectar.php';

class cl_caja_diaria
{
    private $id_empresa;
    private $fecha;
    private $m_sistema;
    private $m_apertura;
    private $m_cierre;
    private $venta_dia;
    private $venta_cobro;
    private $venta_anulacion;
    private $otros_ingresos;
    private $compra_egreso;
    private $gastos_varios;

    /**
     * cl_caja_diaria constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdEmpresa()
    {
        return $this->id_empresa;
    }

    /**
     * @param mixed $id_empresa
     */
    public function setIdEmpresa($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getMSistema()
    {
        return $this->m_sistema;
    }

    /**
     * @param mixed $m_sistema
     */
    public function setMSistema($m_sistema)
    {
        $this->m_sistema = $m_sistema;
    }

    /**
     * @return mixed
     */
    public function getMApertura()
    {
        return $this->m_apertura;
    }

    /**
     * @param mixed $m_apertura
     */
    public function setMApertura($m_apertura)
    {
        $this->m_apertura = $m_apertura;
    }

    /**
     * @return mixed
     */
    public function getMCierre()
    {
        return $this->m_cierre;
    }

    /**
     * @param mixed $m_cierre
     */
    public function setMCierre($m_cierre)
    {
        $this->m_cierre = $m_cierre;
    }

    /**
     * @return mixed
     */
    public function getVentaDia()
    {
        return $this->venta_dia;
    }

    /**
     * @param mixed $venta_dia
     */
    public function setVentaDia($venta_dia)
    {
        $this->venta_dia = $venta_dia;
    }

    /**
     * @return mixed
     */
    public function getVentaCobro()
    {
        return $this->venta_cobro;
    }

    /**
     * @param mixed $venta_cobro
     */
    public function setVentaCobro($venta_cobro)
    {
        $this->venta_cobro = $venta_cobro;
    }

    /**
     * @return mixed
     */
    public function getVentaAnulacion()
    {
        return $this->venta_anulacion;
    }

    /**
     * @param mixed $venta_anulacion
     */
    public function setVentaAnulacion($venta_anulacion)
    {
        $this->venta_anulacion = $venta_anulacion;
    }

    /**
     * @return mixed
     */
    public function getOtrosIngresos()
    {
        return $this->otros_ingresos;
    }

    /**
     * @param mixed $otros_ingresos
     */
    public function setOtrosIngresos($otros_ingresos)
    {
        $this->otros_ingresos = $otros_ingresos;
    }

    /**
     * @return mixed
     */
    public function getCompraEgreso()
    {
        return $this->compra_egreso;
    }

    /**
     * @param mixed $compra_egreso
     */
    public function setCompraEgreso($compra_egreso)
    {
        $this->compra_egreso = $compra_egreso;
    }

    /**
     * @return mixed
     */
    public function getGastosVarios()
    {
        return $this->gastos_varios;
    }

    /**
     * @param mixed $gastos_varios
     */
    public function setGastosVarios($gastos_varios)
    {
        $this->gastos_varios = $gastos_varios;
    }

    public function obtener_datos()
    {
        $existe = false;
        global $conn;
        $query = "select * from caja_diaria where id_empresa = '" . $this->id_empresa . "' and fecha = '" . $this->fecha . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->venta_dia = $fila['venta_dia'];
                $this->venta_cobro = $fila['venta_cobro'];
                $this->venta_anulacion = $fila['venta_devolucion'];
                $this->otros_ingresos = $fila['otros_ingresos'];
                $this->compra_egreso = $fila['compra_egreso'];
                $this->gastos_varios = $fila['gastos_varios'];
                $this->m_sistema = $fila['m_sistema'];
                $this->m_apertura = $fila['m_apertura'];
                $this->m_cierre = $fila['m_cierre'];
            }
        }
        return $existe;
    }

    function insertar()
    {
        $grabado = false;
        global $conn;
        $query = "insert into caja_diaria values ('" . $this->id_empresa . "', '" . $this->fecha . "', '0', '0', '0', '0', '0', '0', '0', '" . $this->m_apertura . "', '0')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in caja_diaria: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_caja_mensual($mes)
    {
        global $conn;
        $query = "select * from caja_diaria "
            . "where id_empresa = '" . $this->id_empresa . "' and concat(year(fecha), LPAD(month(fecha), 2, 0)) = '" . $mes . "' "
            . "order by fecha asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }


}
