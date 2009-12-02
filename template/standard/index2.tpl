<head>
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="utf-8" >
  <meta name="description" content="Your description goes here" />
  <meta name="keywords" content="your,keywords,goes,here" />
  <meta name="author" content="Your Name / Design Template: Gerhard Erbes / Email: gw@actamail.com/" />
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
	    		<li><a href="#">系統討論區</a></li>																		
	        </ul>
		</div>								
	</div>
		
<div id="header-nav-bottom">
</div>				
    
		
<!-- Buffer to content area -->		
<div id="buffer"></div>			
			
<!-- 	MIDDLE COLUMN -->
<div id="middle-column">

    <div class="middle-column-box-left-standard">
        <div class="middle-column-title-standard">關於 OPMS!</div>
    </div>

    <div class="middle-column-box-right-standard">
        <div class="middle-column-title-standard">最近新增的專案</div>
    </div>

	<div class="middle-column-box-left-standard">
        <div class="middle-column-title-standard">系統公告</div>
    </div>
			
    <div class="middle-column-box-right-standard">
        <div class="middle-column-title-standard">最新消息</div>
    </div>
</div>

    <!-- RIGHT COLUMN -->
	  <div id="right-column">

		<div class="right-column-box-standard">
			<div class="right-column-title-grey">Login System</div>
			
				<form name="loginform" id="loginform" action="check-login.php" method="post">
			      <p>
			        <label>Username:<br />
		  	          <input type="text" name="username" id="username" value="" size="20" tabindex="1" />
			        </label>
			      </p>

		          <p>
		            <label>Password:<br />
		              <input type="password" name="passwd" id="password" value="" size="20" tabindex="1" />
		            </label>
		          </p>

		          <p class="submit">
		            <input type="submit" name="submit" id="login" value="Login &raquo;" tabindex="4" />
		            <input type="hidden" name="redirect" value="{$page_redirect}" />
		          </p>
				</form>
									
	  		<p><a href="#">忘記密碼？</a> | <a href="#">Link B</a></p>		
      </div>												

			<!-- White box -->		
      <div class="right-column-box-standard">
        <div class="right-column-title-grey">相關連結</div>
			<p><a href="http://www.au.edu.tw">真理大學</a></p> 
			<p><a href="#">真理大學資訊科學系</a></p>	
      </div>			

			<!-- White box -->		
      <div class="right-column-box-standard">
        <div class="right-column-title-grey">連絡我們</div>
        <p>We are OPMS Devlope Team , and here is our email:</p>
				<p><a href="#">opms@au.edu.tw</a></p>								 
      </div>			
    </div>		
		
    <!-- FOOTER -->
    <div id="footer">
       Copyright &copy;2006 OPMS Dev team | All rights reserved<br />Design by Gerhard Studios</a> | <a href="http://validator.w3.org/check?uri=referer" title="Validate code as W3C XHTML 1.1 Strict Compliant">W3C XHTML 1.1</a> | <a href="http://jigsaw.w3.org/css-validator/" title="Validate Style Sheet as W3C CSS 2.0 Compliant">W3C CSS 2.0</a>
    </div>
</div>

  
</body>
</html>