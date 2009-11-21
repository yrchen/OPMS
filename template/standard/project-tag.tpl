
{include file="standard/header-YUI.tpl"}
{include file="standard/navbar.tpl"}

<div id="blogBody">
  <div id="innerBody">
    <div class="extra-block" id="extra-block">
      <div class="extra">
		<div class="hd">使用者資訊</div>
        <div class="bd">
          <ul>
        	<li style="font-size:8pt;">現在時間：{$time}</li>
			<li>帳號：{$user_name}</li>
			<li>身分：{$user_type}</li>
		  </ul>
    	</div>
	  </div>
	 
      <div class="extra">
	    <div class="hd">重要訊息</div>
        <div class="bd">
          <ul>
            <li>老師留言：<a href= "#">老師的留言</a></li>
            <li>任務提示：<a href= "#">您設定的任務過期了</a></li>
		  </ul>
        </div>
	  </div>

      <div class="extra">
	    <div class="hd">相關連結</div>
        <div class="bd">
          <ul id="links">
            <li><a href="http://www.au.edu.tw" target="_blank">真理大學</a></li>
			<li><a href="http://www.cis.au.edu.tw" target="_blank">真理大學資訊科學系</a></li>
		  </ul>
		</div>
      </div>
    </div>
	
    
    <p><a href="project-my.php" rel="bookmark" class="post-title">專案概要</a> 
        <a href="project-message.php" rel="bookmark" class="post-title">訊息</a>
        <a href="project-task.php" rel="bookmark" class="post-title">工作</a>
        <a href="project-milestone.php" rel="bookmark" class="post-title">日進度</a>
        <a href="project-file.php" rel="bookmark" class="post-title">檔案</a>
        <a href="project-tag.php" rel="bookmark" class="post-title">標籤</a>
        <a href="project-svn.php" rel="bookmark" class="post-title">SVN</a>
        <a href="project-trac.php" rel="bookmark" class="post-title">Trac</a></p>
    <p>&nbsp;</p>
<h2><strong>標籤</strong></h2>
	
	
<a href="#" rel="bookmark" class="post-title">新增標籤</a>
<div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>已設置的標籤</strong><br />
        
        
  </blockquote>
</div>
























{include file="standard/footer.tpl"}