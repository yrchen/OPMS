<!-- Begin of selector-announce-one.tpl  -->
<div class="container">
  <ul id="navPyra">
  {if isset($smarty.request.active_project)}
	<li><a href="main.php?event=Announce&action=Add&active_project={$smarty.request.active_project}">新增公告</a></li>
	<li><a href="main.php?event=Announce&action=Del&active_project={$smarty.request.active_project}">刪除公告</a></li>
	<li><a href="main.php?event=Announce&action=Edit&active_project={$smarty.request.active_project}">編輯公告</a></li>
	<li><a href="main.php?event=Announce&action=List&active_project={$smarty.request.active_project}">所有專案公告</a></li>
	<li><a href="main.php?event=Announce&action=ListNew&active_project={$smarty.request.active_project}">所有專案未讀公告</a></li>
  {else}
	<li><a href="main.php?event=Announce&action=AddSystem">新增系統公告</a></li>
	<li><a href="main.php?event=Announce&action=DelSystem">刪除系統公告</a></li>
	<li><a href="main.php?event=Announce&action=EditSystem">編輯系統公告</a></li>
	<li><a href="main.php?event=Announce&action=ListAll">所有公告</a></li>
	<li><a href="main.php?event=Announce&action=ListAllNew">所有未讀公告</a></li>
  {/if}
  </ul>
</div>
<!-- End of selector-announce-one.tpl  -->
