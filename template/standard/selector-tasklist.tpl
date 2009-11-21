<!-- Begin of selector-tasklist.tpl  -->
<div class="container">
  <ul id="navPyra">
	<li><a href="main.php?event=Task&action=AddList&active_project={$smarty.request.active_project}">新增工作清單</a></li>
	<li><a href="main.php?event=Task&action={if isset($smarty.request.id)}DelList&id={$smarty.request.id}{else}ListDelList{/if}&active_project={$smarty.request.active_project}">刪除工作清單</a></li>
	<li><a href="main.php?event=Task&action={if isset($smarty.request.id)}EditList&id={$smarty.request.id}{else}ListEditList{/if}&active_project={$smarty.request.active_project}">編輯工作清單</a></li>
	<li><a href="main.php?event=Task&action=View&active_project={$smarty.request.active_project}">所有工作清單</a></li>
  </ul>
</div>
<!-- End of selector-tasklist.tpl  -->
