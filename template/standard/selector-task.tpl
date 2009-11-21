<!-- Begin of selector-task.tpl  -->
<div class="container">
  <ul id="navPyra">
	<li><a href="main.php?event=Task&action=AddTask&active_project={$smarty.request.active_project}">新增工作</a></li>
	<li><a href="main.php?event=Task&action={if isset($smarty.request.id)}DelTask&id={$smarty.request.id}{else}ListDelTask{/if}&active_project={$smarty.request.active_project}">刪除工作</a></li>
	<li><a href="main.php?event=Task&action={if isset($smarty.request.id)}EditTask&id={$smarty.request.id}{else}ListEditTask{/if}&active_project={$smarty.request.active_project}">編輯工作</a></li>
	<li><a href="main.php?event=Task&action=ListAll&active_project={$smarty.request.active_project}">所有工作</a></li>
  </ul>
</div>
<!-- End of selector-task.tpl  -->
