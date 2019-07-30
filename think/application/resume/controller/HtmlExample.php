<?php
namespace app\resume\controller;
class HtmlExample 
{
    public function baseInfoHtml()
    {
        $html = '<div class="red_bd">
						<form onsumbit="return false;" class="form-horizontal new_add" id="base_info_form" role="form">
							<div class="form-group">
								<div class="pull-left"><img src="http://img01.51jobcdn.com/im/2016/resume/man.png"
							width="85" height="104" alt="头像"></div>
								<div class="pull-left">
									<table>
										<tr>
											<td><label>姓名</label><i>*</i><input type="text" name="name"></td>
											<td><label>性别</label><input type="text" name="sex"></td>
										</tr>
										<tr>
											<td><label>出生日期</label><i>*</i><input type="text" name="birthday"></td>
											<td><label>工作年份</label><i>*</i><input type="text" name="workage"></td>
										</tr>
										<tr>
											<td><label>手机</label><i>*</i><input type="text" name="phone"></td>
											<td><label>邮箱</label><i>*</i><input type="text" name="email"></td>
										</tr>
										<tr>
											<td><label>居住地</label><i>*</i><input type="text" name="address"></td>
											<td><label>QQ</label><input type="text" name="qq"></td>
										</tr>
										<tr>
											<td><label>身份证号</label><input type="text"
												name="indentity"></td>
											<td><label>婚姻状态</label><input type="text" name="marry"></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="btns">
								<button type="submit" id="base_info" class="save" onclick="saveButtonClicked(this);">保存</button>
								<button type="cancel" class="cancel">取消</button>
							</div>
						</form>
					</div>';
        return $html;
    }
    
    public function carrerHtml()
    {
        $html = '<div class="e">
						<label>期望薪资</label><i>：</i>
						<div class="inline-block"></div>
					</div>
					<div class="e">
						<label>地点</label><i>：</i>
						<div>
							<span class="ong"></span>
						</div>
					</div>
					<div class="e">
						<label>职能/职位</label><i>：</i>
						<div>
							<span class="ong"></span>
						</div>
					</div>
					<div class="e">
						<label>行业</label><i>：</i>
						<div>
							<span class="ong"></span>
						</div>
					</div>
					<div class="e">
						<label>个人标签</label><i>：</i>
						<div>
							<span class="ong"></span>
						</div>
					</div>
					<div class="con">
						<div class="clear"></div>
					</div>';
        return $html;
    }
    
    public  function baseInfoHtml2($record)
    {
        $html = '<div class="face">
        <img src="//img03.51jobcdn.com/im/2016/resume/man.png" width="85" height="104" alt="头像" />
        </div>
        <div class="name ">'. $record["resume_name"] . '</div>
        <p class="at">现居住'. $record["work_place"] .' │ '. $record["work_age"] .'年工作经验 │ '. $record["sex"].' │ '. $record["age"].' 岁 ('. $record["birthdy"].') │ 目前正在找工作</p>
        <div class="tab">
        <span class="email icons at" title="1393901022@qq.com">'.$record["email"].'</span>
        <span class="tel icons">'.$record["phone"].'</span>
        </div>
        <div class="abox">
        <div class="mbox" onclick="showMoreClickEvent(this)">
        <span class="icons" >更多展开</span>
        <em class="icons"></em>
        </div>
        <div class="all">
        <div class="e e2">
        <label>证件号</label><i>：</i>
        <div>'.$record["identity"].'(身份证)</div>
        </div>
        <div class="e e2">
        <label>婚姻状态</label><i>：</i>
        <div>已婚</div>
        </div>
        <div class="e e2">
        <label>身高</label><i>：</i>
        <div>'.$record["height"].'cm</div>
        </div>
        <div class="e e2">
        <label>QQ号</label><i>：</i>
        <div>'.$record["QQ"].'</div>
        </div>
        <div class="clear"></div>
        </div>
        </div>';
        return $html;        
    }
    
    public function carrerHtml2($record)
    {
        $html='<div class="bd">
        <div class="con">
            <div class="e e3">
                <label>期望薪资</label><i>：</i>
                <div>20-30万元/年</div>
            </div>
            <div class="e e3">
                <label>地点</label><i>：</i>
                <div>'. $record["work_place"]  . '</div>
            </div>
            <div class="e e3 ef">
                <label>职能/职位</label><i>：</i>
                <div>' . $record["work_position"]. '</div>
            </div>
            <div class="e e3">
                <label>行业</label><i>：</i>
                <div>' . $record["work_industry"] . '</div>
            </div>
            <div class="e">
                <label>个人标签</label><i>：</i>
                <div>
<span class="ong">高级开发工程师&nbsp;&nbsp;</span><span class="ong">图像算法工程师&nbsp;&nbsp;</span><span class="ong">校正&nbsp;&nbsp;</span><span class="ong">图像质量&nbsp;&nbsp;</span><span class="ong">项目经理</span>                </div>
            </div>
            <div class="e e2">
                <label>工作类型</label><i>：</i>
                <div>全职</div>
            </div>
            <div class="clear"></div>
        </div>
';
        return $html;
    }
}