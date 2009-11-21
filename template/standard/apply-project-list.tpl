<!-- Begin of apply-project-list.tpl -->
{load_apply_project_list assign="apply_project_list"}

{if $apply_project_list->mApplyProjectList}
<div class="post">
	<table width="90%" border="1" cellpadding="1" cellspacing="0" bordercolor="#CADBFF">
		  <tr>
		    <td width="5%" bgcolor="#F2F2F2">編號</td>
		    <td width="35%" bgcolor="#F2F2F2">名稱</td>
		    <td width="10%" bgcolor="#F2F2F2">指導老師</td>
		    <td width="5%" bgcolor="#F2F2F2">人數</td>
		    <td width="20%" bgcolor="#F2F2F2">成立日期</td>
		    <td width="7%" bgcolor="#F2F2F2">目前狀態</td>
		    <td width="8%" bgcolor="#F2F2F2">已報名人數</td>
		  </tr>
          {section name=i loop=$apply_project_list->mApplyProjectList}
		  <tr>
		    <td width="5%" bgcolor="#F2F2F2"><a href="#id_{$apply_project_list->mApplyProjectList[i].id}">{$apply_project_list->mApplyProjectList[i].id}</a></td>
		    <td width="35%" bgcolor="#F2F2F2">{$apply_project_list->mApplyProjectList[i].title}</td>
		    <td width="10%" bgcolor="#F2F2F2">{$apply_project_list->mApplyProjectList[i].realname}</td>
		    <td width="5%" bgcolor="#F2F2F2">{$apply_project_list->mApplyProjectList[i].member_limit}</td>
		    <td width="7%" bgcolor="#F2F2F2">{$apply_project_list->mApplyProjectList[i].start_date}</td>
		    <td width="8%" bgcolor="#F2F2F2">
		    {if $apply_project_list->mApplyProjectList[i].status == 'open'}
		    開放
		    {elseif $apply_project_list->mApplyProjectList[i].status == 'close'}
		    不開放
		    {/if}
		    </td>
		    <td width="10%" bgcolor="#F2F2F2">{$apply_project_list->mApplyProjectUser[i]}</td>
		  </tr>
		  {/section}
	</table>
</div>

    <div class="post">
      {section name=j loop=$apply_project_list->mApplyProjectList}
      <blockquote><a name="id_{$apply_project_list->mApplyProjectList[j].id}"></a>
        <h2><strong>{$apply_project_list->mApplyProjectList[j].title}</strong></h2><br/>
        <p>{$apply_project_list->mApplyProjectList[j].description}</p><br/>
        <p>指導老師：{$apply_project_list->mApplyProjectList[j].realname}</p>
        <p>人數上限：{$apply_project_list->mApplyProjectList[j].member_limit}　已報名：{$apply_project_list->mApplyProjectUser[j]}</p>
        <p>參考資料：{$apply_project_list->mApplyProjectList[j].reference}</p>
        {if $apply_project_list->mApplyProjectList[j].status == 'open'}
          {if $apply_project_list->mApplyProjectExist[j]}
          <form name="apply_leave_project" action="main.php?event=Apply&action=LeaveProject&id={$apply_project_list->mApplyProjectList[j].id}" method="post">
            <input type="submit" name="submit_leave_project_{$apply_project_list->mApplyProjectList[j].id}" class="button" value="取消報名">
          </form>
          {else}
          <form name="apply_join_project" action="main.php?event=Apply&action=JoinProject&id={$apply_project_list->mApplyProjectList[j].id}" method="post">
            <input type="submit" name="submit_join_project_{$apply_project_list->mApplyProjectList[j].id}" class="button" value="報名">
          </form>
          {/if}
        {/if}
  	  </blockquote>
  	  {/section}
    </div>
{/if}

<!-- End of apply-project-list.tpl -->