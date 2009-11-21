<h2>新增專案</h2>
	<div id="sidebar">
	  <div class="box">
			<h3>專案設定</h3>
			<ul>

				<li><a href="#">新增專案</a></li>
				<li><a href="#">專案檢視</a></li>
				
		    </ul>
	  </div>
	</div>
<div id="content">
	<form name="project_add" id="project_form" action="" method="post">
				<h3>專案名稱(中文)：<input type="text" name="project_name" id="project_name" value="" size="40" /></h3>
				<h3>專案名稱(英文)：<input type="text" name="project_shortname" id="project_shortname" value="" size="20" /></h3>				
				<h3>專案簡述：<input name="project_description" type="text" value="" size="80" maxlength="500"></h3>
				<h3>人數：<input type="text" id="project_user_number" value="" size="2" maxlength="1"/></h3>
				<div>
				<h3>相關資料1(URL)：<input type="text" name="project_shortname" id="project_shortname" value="" size="30" /></h3>
				</div>
				<div>
				<h3>相關資料2(URL)：<input type="text" name="project_shortname" id="project_shortname" value="" size="30" /></h3>
				</div>
				<div>
				<h3>相關資料3(URL)：<input type="text" name="project_shortname" id="project_shortname" value="" size="30" /></h3>
				</div>

				<input class="button" value="新增" type="submit">
				<input class="button" value="預覽" type="submit">
				<input name="重設" type="reset" class="button" value="重設">
	</form>		

</div>