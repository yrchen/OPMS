<?php
/*
 * OPMS - Open Project Management System
 * function-db.php
 * Created on 2006/10/21 by Chen YuRen (yrchen@ATCity.org)
 *
 * 資料庫連接
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-DB.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

require_once 'DB.php';

function db_connect()
{
  global $config;
  $result = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

  if (!$result)
    die('Could not connect to database server!');
  else
  {
    return $result;
  }
}

class DBManager
{
  var $num_queries = 0;
  public $db;
  
  function __construct($connectionString)
  {
  	$this->db = DB::connect($connectionString, true);
  	
  	if (DB::isError($this->db))
  	  trigget_error($this->db>getMessage(), E_USER_ERROR);
  	  
  	$this->db->setFetchMode(DB_FETCHMODE_ASSOC);
  }

  public function DBDisconnect()
  {
  	$this->db->disconnect();
  }
  
  public function DBQuery($queryString)
  {
  	$this->db->query("SET NAMES 'utf8'");
  	$result = $this->db->query($queryString);
  	
  	if (DB::isError($result))
  	  trigger_error($result->getMessage(), E_USER_ERROR);
  	  
  	$this->num_queries++;

  	return $result;
  }
  
  public function DBGetAll($queryString)
  {
  	$this->db->query("SET NAMES 'utf8'");
  	$result = $this->db->getAll($queryString);
  	
  	if (DB::isError($result))
  	  trigger_error($result->getMessage(), E_USER_ERROR);
  	  
  	$this->num_queries++;
  	  
  	return $result;
  }
  
  public function DBGetRow($queryString)
  {
  	$this->db->query("SET NAMES 'utf8'");
  	$result = $this->db->getRow($queryString);

  	if (DB::isError($result))
  	  trigger_error($result->getMessage(), E_USER_ERROR);

  	$this->num_queries++;
  	  	  
  	return $result;
  }

  public function DBGetOne($queryString)
  {
  	$this->db->query("SET NAMES 'utf8'");
  	$result = $this->db->getOne($queryString);
  	
  	if (DB::isError($result))
  	  trigger_error($result->getMessage(), E_USER_ERROR);

  	$this->num_queries++;
  	  	  
  	return $result;
  }
  
  public function CountQueryRecords($queryString)
  {
  	if (strtoupper(substr($queryString, 0, 6)) != 'SELECT')
  	  trigger_error("Not a SELECT statement!");
  	
  	$from_position = stripos($queryString, "FROM ");
  	if ($from_position == false)
  	  trigger_error("Bad SELECT statement!");
  	
  	if (isset($_SESSION['last_count_query']))
  	  if ($_SESSION['last_count_query'] == $queryString);
  	    return $_SESSION['last_count'];
  	    
  	$count_query = "SELECT COUNT(*) ".substr($queryString, $from_position);
  	$items_count = $this->DBGetOne($count_query);
  	$_SESSION['last_count_query'] = $queryString;
  	$_SESSION['last_count'] = $items_count;
  	
  	return $items_count;
  }
  
  public function DBEscapeSimple($string)
  {
  	if (get_magic_quotes_gpc())
  	  return $string;
  	else
  	  return $this->db->escapeSimple($string);
  }
}


function get_num_queries()
{
  global $opms_db;
  return $opms_db->num_queries;
}

if (!isset($opms_db))
  $opms_db = new DBManager("mysql://" . $config['db_user'] . ":" . $config['db_pass'] . "@" . $config['db_host'] . "/" . $config['db_name']);
?>