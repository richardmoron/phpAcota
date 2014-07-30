<?php
include_once (dirname(dirname(dirname(dirname(__FILE__))))."\cnx\connection.php");
include_once (dirname(dirname(dirname(dirname(__FILE__))))."\lib\logs.php");

function writeExcel($filename,$PreparedStatement){
    $connection = Connection::getinstance()->getConn();
    $ResultSet = odbc_exec($connection, $PreparedStatement);
    logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
    //start the object
     ob_start();
    // start the file
    xlsBOF();
    // these will be used for keeping things in order.
    $col = 0;
    $row = 0;
    // This tells us that we are on the first row
    $first = true;
    while( $qrow = odbc_fetch_array( $ResultSet ) ){
        // Ok we are on the first row
        // lets make some headers of sorts
        if( $first ){
            foreach( $qrow as $k => $v ){
                // take the key and make label
                // make it uppper case and replace _ with ' '
                xlsWriteLabel( $row, $col, strtoupper( ereg_replace( "_" , " " , $k ) ) );
                $col++;
            }
            // prepare for the first real data row
            $col = 0;
            $row++;
            $first = false;
        }
        // go through the data
        foreach( $qrow as $k => $v ){
            // write it out
            if(is_numeric($v) || is_double($v) || is_float($v) || is_int($v) || is_integer($v))
                xlsWriteNumber( $row, $col, $v );
            else
                xlsWriteLabel( $row, $col, $v );
            $col++;
        }
        // reset col and goto next row
        $col = 0;
        $row++;
    }
    xlsEOF();
    //write the contents of the object to a file
    if($row>0)
        file_put_contents($filename.".xls", ob_get_clean());
}
function generateExcel($PreparedStatement){
    $connection = Connection::getinstance()->getConn();
    $ResultSet = odbc_exec($connection, $PreparedStatement);
    logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
    //start the object
     ob_start();
    // start the file
    xlsBOF();
    // these will be used for keeping things in order.
    $col = 0;
    $row = 0;
    // This tells us that we are on the first row
    $first = true;
    while( $qrow = odbc_fetch_array( $ResultSet ) ){
        // Ok we are on the first row
        // lets make some headers of sorts
        if( $first ){
            foreach( $qrow as $k => $v ){
                // take the key and make label
                // make it uppper case and replace _ with ' '
                xlsWriteLabel( $row, $col, strtoupper( ereg_replace( "_" , " " , $k ) ) );
                $col++;
            }
            // prepare for the first real data row
            $col = 0;
            $row++;
            $first = false;
        }
        // go through the data
        foreach( $qrow as $k => $v ){
            // write it out
            if(is_numeric($v) || is_double($v) || is_float($v) || is_int($v) || is_integer($v))
                xlsWriteNumber( $row, $col, $v );
            else
                xlsWriteLabel( $row, $col, $v );
            $col++;
        }
        // reset col and goto next row
        $col = 0;
        $row++;
    }
    xlsEOF();
    //write the contents of the object to a file
    if($row>0)
        return ob_get_clean();
    else
        return "";
}
// This one makes the beginning of the xls file
function xlsBOF() {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    return;
}

// This one makes the end of the xls file
function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
    return;
}

// this will write text in the cell you specify
function xlsWriteLabel($Row, $Col, $Value ) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
    return;
}
function xlsWriteNumber($Row, $Col, $Value) {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}
?>