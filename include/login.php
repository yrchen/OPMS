<?php
/* 
 * login.php
 * Created on 10-Oct-06 by yrchen
 *
 * Explain in here
 */
 
if (isset($_POST['submit']))
{
  require_once (ABSPATH . OPMS_INC . 'header.php');
  
  if (empty($_POST['username']))
  {
  	$u = FALSE;
  	$message .= '<p>You forgot to enter your username!</p>';
  }
  else
  {
  	$u = '';
  }
  
  if (empty($_POST['password']))
  {
  	$p = FALSE;
  	$message .= '<p>You forgot to enter your password!</p>';
  }
  else
  {
  	$p = '';
  }
  
  if ($u && $p)	//yrchen.061010: Database connection and seeting cookie.
  {

  }
  else
  {
  	$message .= '<p>Please try again.</p>';
  }
}
?>
