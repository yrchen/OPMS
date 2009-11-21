<!-- Begin of navbar.tpl  -->

<body>
<img id="diggit" src="http://project.cis.au.edu.tw/home/opms/trunk/images/loginimage.jpg"/><img id="cursor-img" src="images/JackSlocum/cursor.gif"/><img id="resize-img" src="images/JackSlocum/resize.gif"/><img id="click-img" src="images/JackSlocum/click.gif"/>
<div class="blog-header" id="blog-header">
  <table border="0" cellpadding="0" cellspacing="0"><tr><td><a href="../../images/loginimage.jpg"><img src="/blog/images/jsblog.gif" width="160" height="27" alt="OPMS" border="0"/></a></td><td align="right"><span class="blog-desc">Light, Agile and Powerful!</span></td></tr></table>
</div>

<div id="navbar">
  <a id="nav-dock" href="#" title="Dock the Navigation Pane"><img src="images/JackSlocum/mm-expand.gif" width=12 height=11 border=0></a>
  <a id="nav-expand" href="#"><img src="images/JackSlocum/nav.gif" width=28 height=153 border=0></a>
</div>

<div id="sidebar">
  <div id="sidebar-inner">
    <div class="sidebar-block">
      <h2 class="sidebar-title"><span style="float:left">Dashboard</span><a id="nav-collapse" href="#" title="Collapse the Navigation Pane"><img src="images/JackSlocum/mm-collapse.gif" width=12 height=11 border=0></a></h2>
	  <ul id="link">
  	    <li><a href="main.php">首頁</a></li>
  	    <li><a href="logout.php">登出</a></li>
	  </ul>
    </div>

    <div class="sidebar-block">
      <h2 class="sidebar-title"><a href="project.php" title="專案列表">專案管理</a></h2>
	  <ul id="link">
	    <li><a href="main.php?event=Project&action=List" title="專案列表">所有專案列表</a></li>
	    <li><a href="main.php?event=Project&action=My" title="我的專案">我的專案</a></li>
	    <li><a href="main.php?event=Project&action=Add" title="新增專案">新增專案</a></li>
	    <li><a href="main.php?event=Apply&action=ListLiveProject" title="可申請加入專案清單">申請加入專案</a></li>
	  </ul>
    </div>

    <div class="sidebar-block">
      <h2 class="sidebar-title"><a href="search.php" title="搜尋">搜尋</a></h2>
	  <ul id="link">
	    <li><a href="#" title="快速跳躍">快速跳躍</a></li>
	    <li><a href="search.php" title="搜尋">搜尋</a></li>
	  </ul>
    </div>

    <div class="sidebar-block">
  	  <h2 class="sidebar-title"><a href="admin/" title="系統管理">系統管理</a></h2>
    </div>
    
    <div class="sidebar-block">
      <h2 class="sidebar-title"><a href="about.php" title="關於 OPMS">關於 OPMS</a></h2>
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
</div>

<div id="splitter">
</div>

<!-- End of navbar.tpl  -->
