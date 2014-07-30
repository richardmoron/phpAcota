<?php
//deshabilitar errores de depreciado
error_reporting(0);
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of parsedate
 *
 * @author RichardO
 */
class parsedate {

    public static function changeDateFormat($stDate,$stFormatFrom,$stFormatTo){
      // When PHP 5.3.0 becomes available to me
      //$date = date_parse_from_format($stFormatFrom,$stDate);
      //For now I use the function above
      $date = self::dateParseFromFormat($stFormatFrom,$stDate);
	  $hour = 0;
	  $minute = 0;
	  $second = 0;
	  if(isset($date['hour'])) $hour = $date['hour'];
	  if(isset($date['second'])) $hour = $date['second'];
	  if(isset($date['minute'])) $hour = $date['minute'];
      if(isset($date['month'])){
            return date($stFormatTo,mktime($hour,
                                        $minute,
                                        $second,
                                        $date['month'],
                                        $date['day'],
                                        $date['year']));
      }

    }

    public static function dateParseFromFormat($stFormat, $stData){
        $aDataRet = array();
        $aPieces = split('[:/.\ \-]', $stFormat);
        $aDatePart = split('[:/.\ \-]', $stData);
        foreach($aPieces as $key=>$chPiece)
        {
            switch ($chPiece)
            {
                case 'd':
                case 'j':
                    $aDataRet['day'] = $aDatePart[$key];
                    break;

                case 'F':
                case 'M':
                case 'm':
                case 'n':
                    $aDataRet['month'] = $aDatePart[$key];
                    break;

                case 'o':
                case 'Y':
                case 'y':
                    $aDataRet['year'] = $aDatePart[$key];
                    break;

                case 'g':
                case 'G':
                case 'h':
                case 'H':
					if(isset($aDataRet['hour']))
						$aDataRet['hour'] = $aDatePart[$key];
                    break;

                case 'i':
					if(isset($aDataRet['minute']))
						$aDataRet['minute'] = $aDatePart[$key];
                    break;

                case 's':
					if(isset($aDataRet['second']))
						$aDataRet['second'] = $aDatePart[$key];
                    break;
            }

        }
        return $aDataRet;
    }
}
?>