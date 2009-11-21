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

    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>Welcome to OPMS</strong><br />
        歡迎使用開放式專案管理系統(OPMS)！本系統是專為真理大學資訊科學系專題課程所設計的平台，提供師生一個符合專案管理需求的介面，並整合相關所需之資源。
        </p>
        <p style="margin-bottom:10px;">若有任何問題或指教，請利用左邊導覽列的 "錯誤回報/意見提供"，謝謝 :-)
        </p>
        OPMS 製作團隊
      </blockquote>
    </div>
	
	<div class="post">
      <div class="content content-title"><strong>訊息公告</strong>
        <div class="post-body">
          <div class="content">
            <ul class="list">
              <li>訊息1</li> 
              <li>主任專題生禮拜3中午至715找學長上課</li>
            </ul>
          </div>
        </div>
      </div>
	</div>
  </div>
  <div class="content"><hr /></div>
</div>

<div id="example" style="visibility:hidden;">
  <img src="http://www.jackslocum.com/blog/images/close.gif" id="exclose" width="19" height="19" border="0" onclick="hideExample();"/>
  <iframe class=innerFrame id="exframe" frameborder="0"></iframe>
</div> 

{include file="standard/footer.tpl"}
