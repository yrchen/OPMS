<!-- Begin of project-one.tpl  -->

{load_project_content assign="project_content"}
{load_project_announce_list assign="project_announce_list"}
{load_project_milestone assign="project_milestone"}
{load_project_tasklist assign="project_tasklist"}
{include file="standard/selector-project.tpl"}

    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>{$project_content->mProjectContent.project_description}</strong></p>
        <p>指導老師：{section name=k loop=$project_content->mProjectTeacher}{if $smarty.section.k.iteration > 1}、{/if}{$project_content->mProjectTeacher[k].realname}{/section}</p>
        <p>成　　員：{section name=j loop=$project_content->mProjectMember}{if $smarty.section.j.iteration > 1}、{/if}{$project_content->mProjectMember[j].realname}{/section}</p>
  	  </blockquote>
    </div>

    <div class="post" style="margin-right:225px;">
      <h3><strong>公告</strong></h3>
      <blockquote style="margin:0;">
        {if $project_announce_list->mAnnounceList}
        <ol>
          {section name=i loop=$project_announce_list->mAnnounceList}
            <li><a href="main.php?event=Announce&action=View&id={$project_announce_list->mAnnounceList[i].id}">{$project_announce_list->mAnnounceList[i].title}</a> - 由 {$project_announce_list->mAnnounceList[i].realname} 於 {$project_announce_list->mAnnounceList[i].start_date} 發布</li>
          {/section}
        </ol>
        {else}
        目前沒有公告，是否<a href="main.php?event=Announce&action=Add&active_project={$project_content->mProjectContent.project_id}">新增</a>？
        {/if}
  	  </blockquote>
    </div>

    <div class="post" style="margin-right:225px;">
      <h3><strong>目標</strong></h3>
      <blockquote style="margin:0;">
        {if $project_milestone->mProjectMilestone}
        <ol>
          {section name=i loop=$project_milestone->mProjectMilestone}
          <li><a href="main.php?event=Milestone&action=View&id={$project_milestone->mProjectMilestone[i].id}&active_project={$project_content->mProjectContent.project_id}">{$project_milestone->mProjectMilestone[i].name}</a></li>
          {/section}
        </ol>
        {else}
        目前尚未設定目標，是否<a href="main.php?event=Milestone&action=Add&active_project={$project_content->mProjectContent.project_id}">新增</a>？
        {/if}
  	  </blockquote>
    </div>
    
    <div class="post" style="margin-right:225px;">
      <h3><strong>工作</strong></h3>
      <blockquote style="margin:0;">
        {if $project_tasklist->mProjectTaskList}
        <ol>
          {section name=i loop=$project_tasklist->mProjectTaskList}
          <li><a href="main.php?event=Task&action=ViewList&id={$project_tasklist->mProjectTaskList[i].id}&active_project={$smarty.request.active_project}">{$project_tasklist->mProjectTaskList[i].name}</a></li>
          {/section}
        </ol>
        {else}
        目前尚未設定工作，是否<a href="main.php?event=Task&action=AddList&active_project={$project_content->mProjectContent.project_id}">新增</a>？
        {/if}
  	  </blockquote>
    </div>

<!-- End of project-ons.tpl  -->
