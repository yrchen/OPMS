<!-- Begin of milestone-add.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-milestone.tpl"}
{add_milestone assign="add_milestone"}

<div class="post" style="margin-right:225px;">
<h2><strong>新增日進度</strong></h2>

<form name="milestone_add" action="main.php?event=Milestone&action=Add&active_project={$smarty.request.active_project}" method="post" >
  <label>
  日程名稱：<span class="label_required">*</span><br />
  <input name="textfield" type="text" size="52" maxlength="52" />
  </label>
  <p>日程描述：
    <label> <br />
    <textarea name="textarea" cols="50" rows="10"></textarea>
    </label>
  </p>
  <lable>最後時限: <span class="label_required">*</span></label>    
  <select name="milestone_due_date_month">
	<option value="1">一月</option>
	<option value="2">二月</option>
	<option value="3">三月</option>
	<option value="4">四月</option>
	<option value="5">五月</option>
	<option value="6">六月</option>
	<option value="7">七月</option>
	<option value="8">八月</option>
	<option value="9">九月</option>
	<option value="10">十月</option>
	<option value="11">十一月</option>
	<option value="12">十二月</option>
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
 
  <label for="milestoneFormAssignedTo"><br />
  <br />
  設定給:</label>       
  <select id="milestoneFormAssignedTo" name="milestone_assigened_to_user_id">
	<option value="0:0">Anyone</option>
	<option value="0:0">--</option>
  </select>

  <p>
    <label>
    <input type="submit" name="submit_add_milestone_{$smarty.request.active_project}" class="button" value="新增" />
    </label>
    <label>
    <input type="reset" name="reset" class="button" value="重設" />
    </label>
    <label>
    <input type="submit" name="submit_cancel_{$smarty.request.active_project}" class="button" value="取消">
    </label>
  </p>
</form>	
</div>
<!-- Begin of milestone-add.tpl -->
