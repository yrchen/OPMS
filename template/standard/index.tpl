<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="utf-8">
﻿<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="opms@Project.CIS.AU.edu.tw" />
  <meta name="copyright" content="&copy;2006 CIS@AU.edu.tw" />
  <meta name="robots" content="index,follow" />
  <meta name="description" content="Open Project Management System" />
  <meta name="keywords" content="Open Source, Project Management" />
  <meta name="author" content="OPMS Dev Team / Design Template: Gerhard Erbes / Email: gw@actamail.com/" />
  <link rel="stylesheet" type="text/css" href="style/index.css" />
  <title>OPMS</title>
</head>

<body>
<div id="wrap">

  <div id="header-banner">	
<!-- Header top navigation -->
	<div id="header-nav-top">
      <ul>
	    <li><a href="index.php">首頁</a></li>
		<li><a href="#">專案列表</a></li>																
	  </ul>
    </div>								
  </div>

  <div id="header-nav-bottom"></div>				
<!-- Buffer to content area -->		
  <div id="buffer"></div>			
			
<!-- MIDDLE COLUMN -->
  <div id="middle-column">
    <div class="middle-column-box-full-standard">
      <div class="middle-column-title-standard">關於 OPMS!</div>
	  <p>
		<b>OPMS</b> 的全名為 Open Project Management System (開放式專案管理系統)。本系統是專為真理大學資訊科學系專題課程所設計的平台，提供師生一個符合專案管理需求的介面，並整合相關所需之資源。
	  </p>
    </div>

	<div class="middle-column-box-left-standard">
      <div class="middle-column-title-standard">系統公告</div>
      {include file="standard/announce-all-nonlogin.tpl"}
    </div>
			
    <div class="middle-column-box-right-standard">
      <div class="middle-column-title-standard">最近新增的專案</div>
      {include file="standard/project-list-nonlogin.tpl"}
    </div>
    
  </div>

    <!-- RIGHT COLUMN -->
  <div id="right-column">

    <div class="right-column-box-standard">
	  <div class="right-column-title-grey">登入 OPMS</div>
      {if $user_logined}
      <p>
      {insert name="username"} 您好<br /><a href="logout.php">登出</a>
      </p>
      {else}
	  <form name="loginform" id="loginform" action="check-login.php" method="post">
		<p>
		  <label>帳號：<br />
		  <input type="text" name="username" id="username" value="" size="20" tabindex="1" />
		  </label>
        </p>
        <p>
          <label>密碼：<br />
            <input type="password" name="passwd" id="password" value="" size="20" tabindex="1" />
	      </label>
	    </p>
        <p class="submit">
		  <input type="submit" name="submit" id="login" value="登入" tabindex="4" />
		  <input type="hidden" name="redirect" value="{$page_redirect}" />
        </p>
	  </form>						
	  <p>
	   <a href="">忘記密碼？</a> | <a href="register.php">註冊</a>
	  </p>
	  {/if}
	</div>
												
			<!-- White box -->		
    <div class="right-column-box-standard">
      <div class="right-column-title-grey">相關連結</div>
      <ul>
	    <li><a href="http://www.au.edu.tw/">真理大學</a></li> 
	    <li><a href="http://www.cis.au.edu.tw/">真理大學資訊科學系</a></li>
	  </ul>	
    </div>			
			<!-- White box -->		
    <div class="right-column-box-standard">
      <div class="right-column-title-grey">關於我們</div>
      <ul id="link">
        <li><a href="/trac/opms/newticket" target="_blank">錯誤回報/意見提供</a></li>
        <li><a href="/home/opms/docs/OPMS_FAQ" title="常見問題">常見問題</a></li>
        <li><a href="about.php" title="關於 OPMS">關於 OPMS</a></li>
        <li><a href="/home/opms/devlog/" title="OPMS Development Blog">Blog</a></li>
        <li><a href="/home/opms/devforum/" title="OPMS Development 討論">討論區</a></li>
        <li><a href="rss.php" title="RSS">訂閱 RSS</a></li>
      </ul>						 
    </div>

  </div>		
    <!-- FOOTER -->
  <div id="footer">
     Copyright &copy;2006 OPMS Dev team | All rights reserved<br />Design by OPMS Team</a> | <a href="http://validator.w3.org/check?uri=referer" title="Validate code as W3C XHTML 1.1 Strict Compliant">W3C XHTML 1.1</a> | <a href="http://jigsaw.w3.org/css-validator/" title="Validate Style Sheet as W3C CSS 2.0 Compliant">W3C CSS 2.0</a>
  </div>

</div>
</body>
</html>