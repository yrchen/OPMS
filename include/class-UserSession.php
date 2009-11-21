<?php
/*
 * OPMS
 * class-UserSession.php
 * Created on 2006/12/16 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-UserSession.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

  class UserSession {
    private $php_session_id;
    private $native_session_id;
    private $dbhandle;
    private $logged_in;
    private $user_id;
    private $session_timeout = 600; # 10 minute inactivity timeout
    private $session_lifespan = 3600; # 1 hour session duration
    
    public function __construct() {
      # Connect to database
      $this->dbhandle = pg_connect("host=db dbname=prophp5 user=ed") or die ("PostgreSQL error: --> " . pg_last_error($this->dbhandle));
      # Set up the handler
      session_set_save_handler(
          array(&$this, '_session_open_method'),
          array(&$this, '_session_close_method'),
          array(&$this, '_session_read_method'),
          array(&$this, '_session_write_method'),
          array(&$this, '_session_destroy_method'),
          array(&$this, '_session_gc_method')
      );
      # Check the cookie passed - if one is - if it looks wrong we'll scrub it right away
      $strUserAgent = $GLOBALS["HTTP_USER_AGENT"];
      if ($_COOKIE["PHPSESSID"]) {
       # Security and age check
       $this->php_session_id = $_COOKIE["PHPSESSID"];
       $stmt = "select id from \"user_session\" where ascii_session_id = '" . $this->php_session_id . "' AND ((now() - created) < ' " . 
$this->session_lifespan . " seconds') AND user_agent='" . $strUserAgent . "' AND ((now() - last_impression) <= '".$this->session_timeout." seconds' 
OR last_impression IS NULL)";
       $result = pg_query($stmt);
       if (pg_num_rows($result)==0) {
         # Set failed flag
          $failed = 1;
         # Delete from database - we do garbage cleanup at the same time
         $result = pg_query("DELETE FROM \"user_session\" WHERE (ascii_session_id = '". $this->php_session_id . "') OR (now() - created) > 
$maxlifetime)");
         # Clean up stray session variables
         $result = pg_query("DELETE FROM \"session_variable\" WHERE session_id NOT IN (SELECT id FROM \"user_session\")");
         # Get rid of this one... this will force PHP to give us another
         unset($_COOKIE["PHPSESSID"]);
       };
      };
      # Set the life time for the cookie
      session_set_cookie_params($this->session_lifespan);
      # Call the session_start method to get things started
      session_start();
    }
    
    public function Impress() {
      if ($this->native_session_id) {
        $result = pg_query("UPDATE \"user_session\" SET last_impression = now() WHERE id = " . $this->native_session_id);
      };
    }
    
    public function IsLoggedIn() {
      return($this->logged_in);
    }
    
    public function GetUserID() {
      if ($this->logged_in) {
        return($this->user_id);
      } else {
        return(false);
      };
    }
    
    public function GetUserObject() {
      if ($this->logged_in) {
        if (class_exists("user")) {
          $objUser = new User($this->user_id);
          return($objUser);
        } else {
          return(false);
        };
      };
    }
    
    public function GetSessionIdentifier() {
      return($this->php_session_id);
    }
    
    public function Login($strUsername, $strPlainPassword) {
      $strMD5Password = md5($strPlainPassword);
      $stmt = "select id FROM \"user\" WHERE username = '$strUsername' AND md5_pw = '$strMD5Password'";
      $result = pg_query($stmt);
      if (pg_num_rows($result)>0) {
        $row = pg_fetch_array($result);
        $this->user_id = $row["id"];
        $this->logged_in = true;
        $result = pg_query("UPDATE \"user_session\" SET logged_in = true, user_id = " . $this->user_id . " WHERE id = " . $this->native_session_id);
        return(true);
      } else {
        return(false);
      };
    }  
    
    public function LogOut() {
      if ($this->logged_in == true) {
        $result = pg_query("UPDATE \"user_session\" SET logged_in = false, user_id = 0 WHERE id = " . $this->native_session_id);
        $this->logged_in = false;
        $this->user_id = 0;
        return(true);
      } else {
        return(false);
      };
    }
    
    public function __get($nm) {
      $result = pg_query("SELECT variable_value FROM session_variable WHERE session_id = " . $this->native_session_id . " AND variable_name = '" . 
$nm . "'");
      if (pg_num_rows($result)>0) {
        $row = pg_fetch_array($result);
        return(unserialize($row["variable_value"]));
      } else {
        return(false);
      };
    }
    
    public function __set($nm, $val) {
      $strSer = serialize($val);
      $stmt = "INSERT INTO session_variable(session_id, variable_name, variable_value) VALUES(" . $this->native_session_id . ", '$nm', '$strSer')";
      $result = pg_query($stmt);
    }
    
    private function _session_open_method($save_path, $session_name) {
      # Do nothing
      return(true);
    }
    
    private function _session_close_method() {
      pg_close($this->dbhandle);
      return(true);
    }
    
    private function _session_read_method($id) {
      # We use this to determine whether or not our session actually exists.
      $strUserAgent = $GLOBALS["HTTP_USER_AGENT"];
      $this->php_session_id = $id;
      # Set failed flag to 1 for now
      $failed = 1;
      # See if this exists in the database or not.
      $result = pg_query("select id, logged_in, user_id from \"user_session\" where ascii_session_id = '$id'");
      if (pg_num_rows($result)>0) {
       $row = pg_fetch_array($result);
       $this->native_session_id = $row["id"];
       if ($row["logged_in"]=="t") {
         $this->logged_in = true;
         $this->user_id = $row["user_id"];
       } else {
         $this->logged_in = false;
       };
      } else {
        $this->logged_in = false;
        # We need to create an entry in the database
        $result = pg_query("INSERT INTO user_session(ascii_session_id, logged_in, user_id, created, user_agent) VALUES 
('$id','f',0,now(),'$strUserAgent')");
        # Now get the true ID
        $result = pg_query("select id from \"user_session\" where ascii_session_id = '$id'");
        $row = pg_fetch_array($result);
        $this->native_session_id = $row["id"];
      };
      # Just return empty string
      return("");
    }
    
    private function _session_write_method($id, $sess_data) {
      return(true);
    }
    
    private function _session_destroy_method($id) {
      $result = pg_query("DELETE FROM \"user_session\" WHERE ascii_session_id = '$id'");
      return($result);
    }
    
    private function _session_gc_method($maxlifetime) {
      return(true);
    }
    
    
  }
?>
