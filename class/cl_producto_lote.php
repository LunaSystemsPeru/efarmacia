<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cl_producto_lote
 *
 * @author luis
 */
class cl_producto_lote {

    private $id_producto;
    private $id_empresa;
    private $lote;
    private $vencimiento;
    private $ctotal;
    private $cactual;
    private $fecha_ingreso;

    function __construct() {
        
    }

    function getId_producto() {
        return $this->id_producto;
    }

    function getId_empresa() {
        return $this->id_empresa;
    }

    function getLote() {
        return $this->lote;
    }

    function getVencimiento() {
        return $this->vencimiento;
    }

    function getCtotal() {
        return $this->ctotal;
    }

    function getCactual() {
        return $this->cactual;
    }

    function getFecha_ingreso() {
        return $this->fecha_ingreso;
    }

    function setId_producto($id_producto) {
        $this->id_producto = $id_producto;
    }

    function setId_empresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

    function setLote($lote) {
        $this->lote = $lote;
    }

    function setVencimiento($vencimiento) {
        $this->vencimiento = $vencimiento;
    }

    function setCtotal($ctotal) {
        $this->ctotal = $ctotal;
    }

    function setCactual($cactual) {
        $this->cactual = $cactual;
    }

    function setFecha_ingreso($fecha_ingreso) {
        $this->fecha_ingreso = $fecha_ingreso;
    }

}
