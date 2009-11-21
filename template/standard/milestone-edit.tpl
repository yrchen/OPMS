<!-- Begin of milestone-edit.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-milestone.tpl"}
{edit_milestone assign="edit_milestone"}
{load_project_member assign="project_member"}

    <div class="post" style="margin-right:225px;">
      <h3><strong>編輯目標</strong></h3>
      <form action="main.php?event=Milestone&action=Edit&id={$edit_milestone->mMilestoneContent.id}&active_project={$smarty.request.active_project}" method="post">
        <div>
          <label for="milestoneFormName">名稱：</label>
          <input class="long" id="milestoneFormName" type="text" name="name" value="{$edit_milestone->mMilestoneContent.name}" />
        </div>

        <div>
          <label for="milestoneFormDesc">說明：</label>
          <textarea class="short" id="milestoneFormDesc" name="description" rows="10" cols="40">{$edit_milestone->mMilestoneContent.description}</textarea>
        </div>
  
        <div>
          <label >結束日期：</label>
          <select name="milestone_due_date_month">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>
          <select name="milestone_due_date_day">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
          </select>
          <select name="milestone_due_date_year">
            <option value="1996">1996</option>
            <option value="1997">1997</option>
            <option value="1998">1998</option>
            <option value="1999">1999</option>
            <option value="2000">2000</option>
            <option value="2001">2001</option>
            <option value="2002">2002</option>
            <option value="2003">2003</option>
            <option value="2004">2004</option>
            <option value="2005">2005</option>
            <option value="2006">2006</option>
            <option value="2007">2007</option>
            <option value="2008">2008</option>
            <option value="2009">2009</option>
            <option value="2010">2010</option>
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
          </select>
        </div>
  
        <div class="formBlock">
          <label>私人目標：</label>
          <input id="milestoneFormIsPrivateYes" class="yes_no" value="1" type="radio" name="is_private" />
          <label class="yes_no" for="milestoneFormIsPrivateYes">是</label>
          <input id="milestoneFormIsPrivateNo" class="yes_no" value="0" type="radio" checked="checked" name="is_private" />
          <label class="yes_no" for="milestoneFormIsPrivateNo">否</label>
        </div>
  
        <div class="formBlock">
          <div>
            <label for="milestoneFormAssignedTo">指派給：</label>
            <select id="milestoneFormAssignedTo" name="assigned_to_user_id">
              <option value="0">任何人</option>
              {section name=j loop=$project_member->mProjectMember}
              <option {if $edit_milestone->mMilestoneContent.assigned_to_user_id == $project_member->mProjectMember[j].id}selected="selected" {/if}value="{$project_member->mProjectMember[j].id}">{$project_member->mProjectMember[j].realname}</option>
              {/section}
            </select>
          </div>

          <div>
            <input id="milestoneFormSendNotification" type="checkbox" class="checkbox" checked="checked" name="send_notification" value="checked" />
            <label for="milestoneFormSendNotification" class="checkbox">寄送電子郵件通知給使用者？</label>
          </div>
        </div>

        <input type="submit" name="submit_edit_milestone_{$edit_milestone->mMilestoneContent.id}" class="button" value="編輯工作">
        <input type="reset" name="submit_reset" class="button" value="重設">
        <input type="submit" name="submit_cancel_{$edit_milestone->mMilestoneContent.id}" class="button" value="取消">
      </form>
<!-- End of milestone-edit.tpl -->
