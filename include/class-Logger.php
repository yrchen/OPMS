<?php
/*
 * OPMS
 * Class-Logger.php
 * Created on 2006/12/24 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Logger.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

 //Log Levels.  The higher the number, the less severe the message
 //Gaps are left in the numbering to allow for other levels
 //to be added later
 
 class Logger {
 
   private $hLogFile;
   private $logLevel;
 
   //Note: private constructor.  Class uses the singleton pattern
   private function __construct() {
     global $config2;  //system configuration info array from some external file
     
     $this->logLevel = $config2['LOGGER_LEVEL'];
     $logFilePath = $config2['LOGGER_FILE'];
     
     if(! strlen($logFilePath)) {
       throw new Exception('No log file path was specified ' . 
                           'in the system configuration.');
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
 
   public function __destruct() {
     if(is_resource($this->hLogFile)) {
       fclose($this->hLogFile);
     }
   }
   
   public static function getInstance() {
     static $objLog;
     
     if(!isset($objLog)) {
       $objLog = new Logger();
     }
     
     return $objLog;
   }
   
   public function logMessage($msg, $logLevel = LOGGER_INFO, $module = null) {
     
     if($logLevel <= $this->logLevel) {
       $time = strftime('%x %X', time());
       $msg = str_replace("\t", '    ', $msg);
       $msg = str_replace("\n", ' ', $msg);
     
       $strLogLevel = $this->levelToString($logLevel);
       
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
   
   public static function levelToString($logLevel) {
     switch ($logLevel) {
       case LOGGER_DEBUG:
         return 'LOGGER_DEBUG';
         break;
       case LOGGER_INFO:
         return 'LOGGER_INFO';
         break;
       case LOGGER_NOTICE:
         return 'LOGGER_NOTICE';
         break;
       case LOGGER_WARNING:
         return 'LOGGER_WARNING';
         break;
       case LOGGER_ERROR:
         return 'LOGGER_ERROR';
         break;
       case LOGGER_CRITICAL:
         return 'LOGGER_CRITICAL';
       default:
         return '[unknown]';
     }
   }
 }
 
?>
