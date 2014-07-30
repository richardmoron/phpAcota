<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css">
            #container{background-color: #F3F3F3;border: 2px solid #DAE4E9;margin: 15px;padding: 10px;font-family: Verdana, Arial;font-size: 16pt;text-align: center;padding-top: 30px;}
            #tittle{padding-top: 15px;text-align: center;width: 100%;height: 40px;font-weight: normal;font-size: 15pt;margin-bottom: 20px;color: #FFFFFF;background-color: #444444;}
        </style>
        <script type="text/javascript">
                window.onload = function () { Clear(); }
                function Clear() {            
                    var Backlen=history.length;
                    if (Backlen > 0) history.go(-Backlen);

                    if(window.history.forward(1) != null)
                        window.history.forward(1);
                }
        </script>
    </head>
    <body onload="Clear();">
        <div id="container">
            <div id="tittle">TERMINO DE CONFIDENCIALIDAD</div>
            <textarea id="termino_confidencialiad" style="width: 90%;height: 90%;"></textarea>
            <div>
                <input type="button" value="ACEPTAR Y CONTINUAR"/>
            </div>
        </div>
    </body>
</html>