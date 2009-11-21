<?php
/*
 * OPMS
 * class-FileLoggerBackend.php
 * Created on 2006/12/25 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $astChangedRevision$
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-FileLoggerBackend.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class fileLoggerBackend extends LoggerBackend {

  private $logLevel;
  private $hLogFile;
  
  public function __construct($urlData) {
    global $cfg;  //system configuration info array from some external file
    
    parent::__construct($urlData);
    
    $this->logLevel = $cfg['LOGGER_LEVEL'];
 
    $logFilePath = $this->urlData['path'];  
    if(! strlen($logFilePath)) {
      throw new Exception('No log file path was specified ' . 
                          'in the connection string.');
    }
    
    //Open a handle to the log file.  Suppress PHP error messages.
    //We'll deal with those ourselves by throwing an exception.
    $this->hLogFile = @fopen($logFilePath, 'a+');
    if(! is_resource($this->hLogFile)) {
      throw new Exception("The specified log file $logFilePath " . 
                          'could not be opened or created for ' . 
                          'writing.  Check file permissions.');
    }
  
  }
     
  public function logMessage($msg, $logLevel = LOGGER_INFO, $module = null) {
    if($logLevel <= $this->logLevel) {
      $time = strftime('%x %X', time());
      $msg = str_replace("\t", '    ', $msg);
      $msg = str_replace("\n", ' ', $msg);
    
      $strLogLevel = Logger::levelToString($logLevel);
      
      if(isset($module)) {
        $module = str_replace("\t", '    ', $module);
        $module = str_replace("\n", ' ', $module);
      }  
     
      //logs: date/time loglevel message modulename
      //separated by tabs, new line delimited       
      $logLine = "$time\t$strLogLevel\t$msg\t$module\n";
      fwrite($this->hLogFile, $logLine);
    }
  }

}
?>
