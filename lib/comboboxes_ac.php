<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    include_once (dirname(dirname(__FILE__))."/modules/sapasc/dao/ac_grupos_socios.dao.php");
    
    //--
    function loadCbx_GruposSocios($new = "",$todos = false){
        $strhtml = '<select id="cbx_grupos_socios'.$new.'" name="cbx_grupos_socios'.$new.'" style="width: 250px;"  >';
        if($todos)
            $strhtml .= "<option value='0'>TODO</option>";

        $ac_grupos_sociosDAO = new ac_grupos_sociosDAO();
        $arraylist = $ac_grupos_sociosDAO->selectByCriteria_ac_grupos_socios(array(), -1);
        $iterator = $arraylist->getIterator();
        while($iterator->valid()) {
            $$ac_grupos_sociosTO = $iterator->current();
            $strhtml .= "<option value='".$$ac_grupos_sociosTO->getGrupo_id()."'>".$$ac_grupos_sociosTO->getNombre_grupo()."</option>";
            $iterator->next();
        }
        $strhtml .= "</select>";
        return $strhtml;
    }
?>