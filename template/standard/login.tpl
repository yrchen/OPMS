{include file="standard/header.tpl"}

<body>

  <div id="login">
  <h1><a href="http://project.cis.au.edu.tw/">OPMS</a></h1>

  <form name="loginform" id="loginform" action="check-login.php" method="post">
    <p>
      <label>Username:<br /><input type="text" name="username" id="log" value="" size="20" tabindex="1" /></label>
    </p>
    <p>
      <label>Password:<br /> <input type="password" name="passwd" id="pwd" value="" size="20" tabindex="2" /></label>
    </p>
    <p>
      <label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="3" />Remember me</label>
    </p>
    <p class="submit">
	  <input type="submit" name="submit" id="submit" value="Login &raquo;" tabindex="4" />
	  <input type="hidden" name="redirect" value="{$page_redirect}" />
    </p>
  </form>

  <ul>
    <li><a href="register.php">Register</a></li>
    <li><a href="login.php?action=lostpassword" title="Password Lost and Found">Lost your password?</a></li>
  </ul>
  </div>

{include file="standard/footer.tpl"}