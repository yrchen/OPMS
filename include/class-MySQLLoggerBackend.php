<?php
/*
 * OPMS
 * class-MySQL-LoggerBackend.php
 * Created on 2006/12/16 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-MySQLLoggerBackend.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class MySQLLoggerBackend extends LoggerBackend
{
  private $logLevel;
  private $hConn;
  
  private $table = 'logdata';
  private $messageField = 'message';
  private $logLevelField = 'loglevel';
  private $timestampField = 'logdate';
  private $moduleField = 'module';
  
  public function __construct($urlData)
  {
    global $config2; //system configuration info array from some external file
    
    parent::__construct($urlData);
    
    $this->logLevel = $config2['LOGGER_LEVEL'];
 
    $host = $urlData['host'];
    $port = $urlData['port'];
    $user = $urlData['user'];
    $password = $urlData['password'];
    $arPath = explode('/', $urlData['path']);
    $database = $arPath[1];
    
    if(!strlen($database))
    {
      throw new Exception('pgsqlLoggerBackend: Invalid connection string.' .
                          ' No database name was specified');
    }
    
    $connStr = '';

    if($host)
    {
      $connStr .= "host=$host ";
    }
    
    if($port)
    {
      $connStr .= "port=$port ";
    }
        
    if($user)
    {
      $connStr .= "user=$user ";
    }

    if($password)
    {
      $connStr .= "password=$password ";
    }
    
    $connStr .= "dbname=$database";
    //Suppress native errors.  We'll handle them with an exception
    $this->hConn = pg_connect($connStr);
    if(! is_resource($this->hConn))
    {
      throw new Exception("Unable to connect to the database using $connStr");
    }
    
    //Take the query string in the form var=foo&bar=blah
    //and convert it to an array like
    // array('var' => 'foo', 'bar' => 'blah')
    //Be sure to convert urlencoded values
    $queryData = $urlData['query'];
    if(strlen($queryData))
    {
      $arTmpQuery = explode('&',$queryData);
      
      $arQuery = array();
      foreach($arTmpQuery as $queryItem)
      {
        $arQueryItem = explode('=', $queryItem);
        $arQuery[urldecode($arQueryItem[0])] = urldecode($arQueryItem[1]);
      }
    }
    //None of these items is mandatory.  The defaults are established in the
    //private member declarations at the top of the class.
    //These variables establish the name of the table and the names of the fields
    //within that table that store the various elements of the log entry.
    if(isset($arQuery['table']))
    {
      $this->table = $arQuery['table'];
    }
    if(isset($arQuery['messageField']))
    {
      $this->messageField = $arQuery['messageField'];
    }
   
    if(isset($arQuery['logLevelField']))
    {
      $this->logLevelField = $arQuery['logLevelField'];
    }
    
    if(isset($arQuery['timestampField']))
    {
      $this->timestampField = $arQuery['timestampField'];
    }
    
    if(isset($arQuery['moduleField']))
    {
      $this->logLevelField = $arQuery['moduleField'];
    }
 
  }
  
   
  public function logMessage($msg, $logLevel = LOGGER_INFO, $module = null)
  {
    if($logLevel <= $this->logLevel)
    {
      $time = strftime('%x %X', time());
      
      $strLogLevel = Logger::levelToString($logLevel);
      
      $msg = pg_escape_string($msg);
      
      if(isset($module))
      {
        $module = "'" . pg_escape_string($module) . "'";
      }
      else
      {
        $module = 'NULL';
      }
     
      $arFields = array();
      $arFields[$this->messageField] = "'" . $msg . "'";
      $arFields[$this->logLevelField] = $logLevel;
      $arFields[$this->timestampField] = "'". strftime('%x %X', time()) . "'";
      $arFields[$this->moduleField] = $module;
     
      $sql = 'INSERT INTO ' . $this->table;
      $sql .= ' (' . join(', ', array_keys($arFields)) . ')';
      $sql .= ' VALUES (' . join(', ', array_values($arFields)) . ')';
      pg_exec($this->hConn, $sql);
    }
  }
}
?>
