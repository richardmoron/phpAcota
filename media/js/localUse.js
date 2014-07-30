/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function readonly(form,field,state){
    document.forms[form].elements[field].readOnly=state;
}
function disableField(form,field,state){
    document.forms[form].elements[field].disabled=state;
}
function hide(elem){
    document.getElementById(elem).style.visibility = "hidden";
    document.getElementById(elem).style.height = "0px";
}
function Solo_Numerico(variable){
    Numer=parseInt(variable);
    if (isNaN(Numer)){
        return "";
    }
    return Numer;
}
function ValNumero(Control){
    Control.value=Solo_Numerico(Control.value);
}
function checkDec(el){
 var ex = /^[0-9]+\.?[0-9]*$/;
 if(ex.test(el.value)==false){
   el.value = el.value.substring(0,el.value.length - 1);
  }
}

function trim (myString){
    return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}
function enter(event){
    if(event.keyCode == 13){
        xajax_searchfields(xajax.getFormValues('formulario'),0);
    }
}
function callFileBrowser(elem, vhttp){
    txt_imput = elem;
    http = vhttp;
    objNewWindow = window.open("../../../../lib/filebrowser.php","file","width=480px,height=600px,status=no,resizable=no,scrollbars=yes");
    if(!objNewWindow.opener){ objNewWindow.opener = this.window; }
}
function truncPath(elem){
    if(http == true)
        xajax_path2URL(elem.path+'/'+elem.file,txt_imput,http);
    else
        xajax_path2URL(elem.file,txt_imput,http);
}
function getSelectedValueFromSelect(elem){
    var e = document.getElementById(elem);
    return e.options[e.selectedIndex].value;
}
//--
 function callLovUsuarios(elem_id, elem_name,search){
    nombre = document.forms[0].elements[elem_name].value;
    lov = "http://"+window.location.hostname+"/php/modules/parametros/www/php/pa_usuarios_lov.php";
    loadUsuarios(window.showModalDialog(lov, window,'dialogWidth:480px;dialogHeight:600px;status:no;resizable:no'),elem_id,elem_name,search);
}
function loadUsuarios(elem,elem_id,elem_name){
    document.forms[0].elements[elem_id].value = elem.field_id;
    document.forms[0].elements[elem_name].value = elem.field_name;
}
 function callLovGeneric(elem_id, elem_name, lov_url, search){
    nombre = document.forms[0].elements[elem_name].value;
    lov = "http://"+window.location.hostname+lov_url;//"/php/modules/parametros/www/php/pa_usuarios_lov.php";
    loadDataLovGeneric(window.showModalDialog(lov, window,'dialogWidth:480px;dialogHeight:600px;status:no;resizable:no'),elem_id,elem_name,search);
    if(search){
        dispatchPostLov();
    }
}
function loadDataLovGeneric(elem,elem_id,elem_name,search){
    if(elem != null){
        document.forms[0].elements[elem_id].value = elem.field_id;
        document.forms[0].elements[elem_name].value = elem.field_name;
    }
}

function terminateLov(field_id,field_name){
    var o = new Object();
    o.field_id = field_id;
    o.field_name = field_name;
    window.returnValue = o;
    window.close();
}
//--
function number_format (number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}