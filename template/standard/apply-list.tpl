<!-- Begin of apply-list.tpl -->
{load_apply_list assign="apply_list"}

<div class="post">
	<table width="90%" border="1" cellpadding="1" cellspacing="0" bordercolor="#CADBFF">
		  <tr>
		    <td width="5%" bgcolor="#F2F2F2">編號</td>
		    <td width="20%" bgcolor="#F2F2F2">名稱</td>
		    <td width="25%" bgcolor="#F2F2F2">描述</td>
		    <td width="15%" bgcolor="#F2F2F2">開始日期</td>
		    <td width="15%" bgcolor="#F2F2F2">結束日期</td>
		    <td width="10%" bgcolor="#F2F2F2">目前狀態</td>
		  </tr>
          {section name=i loop=$apply_list->mApplyList}
		  <tr>
		    <td width="5%" bgcolor="#F2F2F2"><a href="main.php?event=Apply&action={$apply_list->mApplyList[i].default_action}">{$apply_list->mApplyList[i].id}</a></td>
		    <td width="20%" bgcolor="#F2F2F2"><a href="main.php?event=Apply&action={$apply_list->mApplyList[i].default_action}">{$apply_list->mApplyList[i].title}</a></td>
		    <td width="25%" bgcolor="#F2F2F2">{$apply_list->mApplyList[i].description}</td>
		    <td width="15%" bgcolor="#F2F2F2">{$apply_list->mApplyList[i].start_date}</td>
		    <td width="15%" bgcolor="#F2F2F2">{$apply_list->mApplyList[i].expire_date}</td>
		    <td width="10%" bgcolor="#F2F2F2">
		    {if $apply_list->mApplyList[i].status == 'open'}
		    開放
		    {elseif $apply_list->mApplyList[i].status == 'close'}
		    結束
		    {/if}
		    </td>
		  </tr>
		  {/section}
	</table>
</div>
<!-- End of apply-list.tpl -->