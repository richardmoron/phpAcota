<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    include_once (dirname(dirname(__FILE__))."/modules/parametros/dao/pa_areas.dao.php");
    include_once (dirname(dirname(__FILE__))."/modules/parametros/dao/pa_parametros.dao.php");
    include_once (dirname(dirname(__FILE__))."/modules/encuestas/dao/ec_empresas.dao.php");
    
    //--
    function loadCbx_Area($new = "",$todos = false){
        $strhtml = '<select id="cbx_area'.$new.'" name="cbx_area'.$new.'" style="width: 250px;"  >';
        if($todos)
            $strhtml .= "<option value='0'>TODO</option>";

        $pa_areasDAO = new pa_areasDAO();
        $arraylist = $pa_areasDAO->selectByCriteria_pa_areas(array(), 0);
        $iterator = $arraylist->getIterator();
        while($iterator->valid()) {
            $areaTO = $iterator->current();
            $strhtml .= "<option value='".$areaTO->getArea_id()."'>".$areaTO->getNombre_area()."</option>";
            $iterator->next();
        }
        $strhtml .= "</select>";
        return $strhtml;
    }
    
    function loadCbx_Parametros($new = "",$todos = false, $entidad){
        $strhtml = '<select id="cbx_parametro'.$new.'" name="cbx_parametro'.$new.'" style="width: 250px;"  >';
        if($todos)
            $strhtml .= "<option value='0'>TODO</option>";

        $pa_parametrosDAO = new pa_parametrosDAO();
        $criterio = array();
        $criterio["entidad"] = $entidad;
        $arraylist = $pa_parametrosDAO->selectByCriteria_pa_parametros($criterio, 0);
        $iterator = $arraylist->getIterator();
        while($iterator->valid()) {
            $pa_parametrosTO = $iterator->current();
            $strhtml .= "<option value='".$pa_parametrosTO->getParametro_id()."'>".$pa_parametrosTO->getValor()."</option>";
            $iterator->next();
        }
        $strhtml .= "</select>";
        return $strhtml;
    }
    
    function loadCbx_EmpresasEncuestas($new = "",$todos = false){
        $strhtml = '<select id="cbx_empresas'.$new.'" name="cbx_empresas'.$new.'" style="width: 250px;"  >';
        if($todos)
            $strhtml .= "<option value='0'>TODO</option>";

        $ec_empresasDAO = new ec_empresasDAO();
        $criterio = array();
        $arraylist = $ec_empresasDAO->selectByCriteria_ec_empresas($criterio, 0);
        $iterator = $arraylist->getIterator();
        while($iterator->valid()) {
            $ec_empresasTO = $iterator->current();
            $strhtml .= "<option value='".$ec_empresasTO->getEmpresa_id()."'>".$ec_empresasTO->getNombre()."</option>";
            $iterator->next();
        }
        $strhtml .= "</select>";
        return $strhtml;
    }
?>