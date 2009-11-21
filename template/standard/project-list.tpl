{load_project_list assign="project_list"}
<div class="post" style="margin-right:225px;">
	<table width="821" border="1" cellpadding="1" cellspacing="0" bordercolor="#CADBFF">
		  <tr>
		    <td width="23" bgcolor="#F2F2F2">編號</td>
		    <td width="97" bgcolor="#F2F2F2">名稱</td>
		    <td width="200" bgcolor="#F2F2F2">描述</td>
		    <td width="72" bgcolor="#F2F2F2">指導老師</td>
		    <td width="77" bgcolor="#F2F2F2">成員</td>
		    <td width="85" bgcolor="#F2F2F2">成立日期</td>
		    <td width="81" bgcolor="#F2F2F2">目前狀態</td>
		    <td width="72" bgcolor="#F2F2F2"></td>
		  </tr>
		  {section name=i loop=$project_list->mProjectList}
		  <tr>
		    <td bgcolor="#FFFFCC">{$project_list->mProjectList[i].project_id}</td>
		    <td align="left" valign="top" bgcolor="#FFFFCC">{$project_list->mProjectList[i].project_name}</td>
		    <td align="left" valign="top" bgcolor="#FFFFCC">{$project_list->mProjectList[i].project_description}</td>
		    <td align="left" valign="top" bgcolor="#FFFFCC">
              <ol>
		      {section name=j loop=$project_list->mProjectTeacher[i]}
		        <li>{$project_list->mProjectTeacher[i][j].realname}</li>
		      {/section}
		      </ol>
		    </td>
		    <td align="left" valign="top" bgcolor="#FFFFCC">
		      <ol>
		      {section name=k loop=$project_list->mProjectMember[i]}
		        <li>{$project_list->mProjectMember[i][k].realname}</li>
		      {/section}
		      </ol>
		    </td>
		    <td align="left" valign="top" bgcolor="#FFFFCC">{$project_list->mProjectList[i].project_start_date}</td>
		    <td align="left" valign="top" bgcolor="#FFFFCC">
		    {if (($project_list->mProjectList[i].project_status) == 0)}
		      {assign var=status value="尚未開始"}
		    {elseif (($project_list->mProjectList[i].project_status) == 1)}
		      {assign var=status value="進行中"}
		    {elseif (($project_list->mProjectList[i].project_status) == 99)}
		      {assign var=status value="已結束"}
		    {else}
		      {assign var=status value="不明"}
		    {/if}
		    {$status}
		    </td>
		    <td align="left" valign="top" bgcolor="#FFFFCC"><a href="main.php?event=Project&action=View&active_project={$project_list->mProjectList[i].project_id}">View</a></td>
		  </tr>
		  {/section}
	</table>
</div>
