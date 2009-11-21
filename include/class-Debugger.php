<?php
/*
 * OPMS
 * class-Debugger.php
 * Created on 2006/12/16 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Debugger.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class Debugger
{
  public static function debug($data, $key = null, $debugLevel = DEBUG_INFO)
  {
    global $config2;

    if(!isset($_SESSION['debugData']))
    {
      $_SESSION['debugData'] = array();
    }

    if($debugLevel <= $config2['DEBUG_LEVEL'])
    {
      $_SESSION['debugData'][$key] = $data;
    }
  }

  public static function debugPrint()
  {
    $arDebugData = $_SESSION['debugData'];
    print $this->printArray($arDebugData);
    
    $_SESSION['debugData'] = array();
  }

  function printArray($var, $title = true)
  {
    $string = '<table border="1">';

    if ($title)
    {
      $string .= "<tr><td><b>Key</b></td><td><b>Value</b></td></tr>\n";
    }

    if (is_array($var))
    {
      foreach($var as $key => $value)
      {
        $string .= "<tr>\n" ;
        $string .= "<td><b>$key</b></td><td>";

        if (is_array($value))
        {
          $string .= $this->printArray($value, false);
        }
        elseif (gettype($value) == 'object')
        {
           $string .= "Object of class " . get_class($value);
        }
        else
        {
          $string .= "$value" ;
        }

        $string .= "</td></tr>\n";
      }
    }

    $string .= "</table>\n";

    return $string;
  }
}
?>
