<!-- Begin of selector-project.tpl  -->
{load_project_selector assign="project_content"}
<div class="post" style="margin-right:225px;">
  <h2><strong>{$project_content->mProjectContent.project_name}</strong><a href="main.php?event=Project&action=Edit&active_project={$project_content->mProjectContent.project_id}">編輯</a></h2>
</div>

<div class="container">
  <ul id="navPyra">
	<li><a href="main.php?event=Project&action=View&active_project={$smarty.request.active_project}">專案概要</a></li>
	<li><a href="main.php?event=Announce&action=List&active_project={$smarty.request.active_project}">公告</a></li>
	<li><a href="main.php?event=Message&action=List&active_project={$smarty.request.active_project}">訊息</a></li>
	<li><a href="main.php?event=Task&action=List&active_project={$smarty.request.active_project}">工作</a></li>
	<li><a href="main.php?event=Milestone&action=List&active_project={$smarty.request.active_project}">目標</a></li>
	<li><a href="main.php?event=File&action=List&active_project={$smarty.request.active_project}">檔案</a></li>
	<li><a href="main.php?event=Tag&action=List&active_project={$smarty.request.active_project}">標籤</a></li>
	<li><a href="main.php?event=Forum&action=List&active_project={$smarty.request.active_project}">論壇</a></li>
	<li><a href="/svn/{$project_content->mProjectShortName}/">SVN</a></li>
	<li><a href="/trac/{$project_content->mProjectShortName}/">Trac</a></li>
  </ul>
</div>
<!-- End of selector-project.tpl  -->
