<?php
namespace app\resume\controller;
use think\Controller;
use think\Db;
use think\Session;
class Resume extends Controller
{
    public function index($resumeId)
    {
        $this->showResume($resumeId);
        $allresumes=Db::name("resume_base_info")->column("resume_title");
        $this->assign("resumes",$allresumes);
        $this->assign("title", "骑着蜗牛去看海的简历");
        return $this->fetch();
    }
    
    function listResumes()
    {
        $base=Db::name("resume_base_info")->field("resume_id","resume_title")->select();
        return json($base);
    }
    
    //显示简历
    protected function showResume($resumeId)
    {
        //基本信息;
        $base=Db::name("resume_base_info")->where("resume_id", $resumeId)->select();
        
    }
    
    function newCreate()
    {
        $requestData = $this->request->post();
        $resumeTitle=$requestData["resume_title"];
        if($resumeTitle)
        {
            if(Db::name("resume_base_info")->where("resume_title",$resumeTitle)->count())
            {
                $this->error("this name exists");
                $this->assign("title", "骑着蜗牛去看海的简历");
                return  $this->fetch("index");
            }
            $maxId = Db::name("resume_base_info")->max("resume_id");
            $data=["resume_id"=>$maxId+1, "resume_title"=>$resumeTitle];
            Db::name("resume_base_info")->insert($date);
            session("resumeId",$maxId+1);
            $this->initSection();
            $baseInfoHtml='<div class="red_bd">
						<form class="form-horizontal new_add" role="form">
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
								<button type="submit" class="save">保存</button>
								<button type="cancel" class="cancel">取消</button>
							</div>
						</form>
					</div>';
            $this->assign("base_info",$baseInfoHtml);
            return $this->fetch("edit_Resume", ['title'=>"编辑简历"]);
        }else 
            $this->error("please set the resume title!!");
    }
    
    protected function initSection()
    {
        $section_name=array("work","project","education","schooljob","skilllanguage","schoolaward","skillcertification","skilltrain","additionattach");
        for ($idx = 0; $idx < count($section_name); $idx ++) {
            $recordNum = Db::name("resume_".$section_name[$idx]."_history")->count();
            $workList = Db::name("resume_".$section_name[$idx]."_history")->select();
            $this->assign($section_name[$idx]."_history", $workList);
            if ($recordNum == 0)
                $this->assign($section_name[$idx]."_empty", '<div class="none icons" id="'.$section_name[$idx]."_empty".'"'.'>完善工作经验，展现工作内容及能力，让HR更了解你！</div>');
                else
                    $this->assign($section_name[$idx]."_empty", '');
        }
    }
    
    function edit($resumeId)
    {       
        if($resumeId < 0) $this->edit("该简历不存在!");
        session("resumeId",$resumeId);                  //简历id保存；
        
        $this->initSection();
        
        //base info;
        $base=Db::name("resume_base_info")->where("resume_id", $resumeId)->select();        
        $base_html='<div class="face">
						<img src="http://img01.51jobcdn.com/im/2016/resume/man.png"
							width="85" height="104" alt="头像">
					</div>
					<div class="name">'.$base["resume_name"].'</div>
					<p class="at">现居住'.$base["address"].'&nbsp;│&nbsp;'.$base["work_age"].'年工作经验&nbsp;│&nbsp;'.$base["sex"].'&nbsp;│&nbsp;'.$base["age"].'
						岁 ('.$base["birthdy"].')&nbsp;│&nbsp;目前正在找工作</p>
					<div class="tab">
						<span class="email icons at" title="'.$base["email"].'">'.$base["email"].'</span>&nbsp;<span
							class="tel icons">'.$base["phone"].'</span>
					</div>
					<div class="abox">
						<div class="mbox" onclick="showMoreClickEvent(this)">
							<span class="icons">更多展开</span><em class="icons"></em>
						</div>
						<div class="all">
							<div class="e e2">
								<label>证件号</label><i>：</i>
								<div>'.$base["identity"].' (身份证)</div>
							</div>
							<div class="e e2">
								<label>婚姻状况</label><i>：</i>
								<div>'.$base["marry"].'</div>
							</div>
							<div class="e e2">
								<label>身高</label><i>：</i>
								<div>'.$base["height"].'</div>
							</div>
							<div class="e e2">
								<label>QQ号</label><i>：</i>
								<div>'.$base["QQ"].'</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="edit_delete">
						<a id="base_edit" href="baseInfoEditClicked(this);">编辑</a>
					</div>';
        $carrer_html='<div class="e">
						<label>期望薪资</label><i>：</i>
						<div class="inline-block">'.$base["salary"].'</div>
					</div>
					<div class="e">
						<label>地点</label><i>：</i>
						<div>
							<span class="ong">'.$base["	work_place"].'</span>
						</div>
					</div>
					<div class="e">
						<label>职能/职位</label><i>：</i>
						<div>
							<span class="ong">'.$base["work_position"].'</span>
						</div>
					</div>
					<div class="e">
						<label>行业</label><i>：</i>
						<div>
							<span class="ong">'.$base["work_industry"].'</span>
						</div>
					</div>
					<div class="e">
						<label>个人标签</label><i>：</i>
						<div>
							<span class="ong">'.$base["master_label"].'</span>
						</div>
					</div>
					<div class="con">
						<div class="clear"></div>
					</div>
					<div class="edit_delete">
						<a class="carrer_edit" href="baseInfoEditClicked(this);">编辑</a>
					</div>';
        $this->assign("base_info",$base_html);
        $this->assign("Career_expected", $carrer_html);
        return $this->fetch("editResume", ['title'=>"编辑简历"]);
    }
    function editSection()
    {
        // box分；
        $requestData = $this->request->post();
        $Type = $requestData["type"];
        $id = $requestData["id"];
        $record = Db::name("resume_work_histroy")->where("id", $id)->find(); 
    }
    
    function addNewHistory()
    {
        $requestData = $this->request->post();
        $Type = $requestData["type"];
        $newAddHtml="";
        switch ($Type)
        {
            case "work":
                $newAddHtml ='<div class="red_bd">
					<form class="form-horizontal new_add" role="form">
						<div class="form-group">
							<label>时间</label> <i>*</i> <input class="ip1" name="start" type="text" readonly="readonly">
							<span>到</span> <input name="end" class="ip1" type="text" readonly="readonly"
								placeholder="至今">
						</div>
						<div class="form-group">
							<label>公司</label> <i>*</i> <input name="company" class="ip2" type="text" readonly="readonly">
						</div>
						<div class="form-group">
							<label>职能</label><input class="ip3" type="text" name="position" readonly="readonly">
							<label class="lb">行业</label><input class="ip4" name="industry" type="text" readonly="readonly">
						</div>
							<div class="form-group">
								<label>部门</label><input class="ip3" name="workpart" type="text"
									readonly="readonly"> <label class="lb">公司性质</label><input
									class="ip4" type="text" name="type" readonly="readonly">
							</div>
							<div class="form-group">
								<label class="work_desc">工作描述</label>
								<textarea name="work_info"></textarea>
							</div>
							<div class="btns">
							<button type="submit" class="save">保存</button>
							<button type="cancel" class="cancel">取消</button>
						</div>
					</form>
					</div>';
                break;
            case "project":
                $newAddHtml='<div class="red_bd">
					<form class="form-horizontal new_add" role="form">
						<div class="form-group">
							<label>所属公司</label>							
							<input type="text" name="company" class="ip3 p1">
						</div>
						<div class="form-group">
							<label>时间</label> <i>*</i> <input class="ip1 p2" name="start" type="text" readonly="readonly">
							<span>到</span> <input name="end" class="ip1" type="text" readonly="readonly"
								placeholder="至今">
						</div>
						<div class="form-group">
							<label>项目</label>
							<i>*</i>
							<input class="ip3 p3" type="text" name="project">
						</div>
						<div class="form-group">
						<label>项目描述</label>
						<i>*</i>
						<textarea class="p4"></textarea>
						</div>
						<div class="form-group">
							<label>责任描述</label>
							<textarea class="p5"></textarea>
						</div>
							<div class="btns">
								<button type="submit" class="save">保存</button>
								<button type="cancel" class="cancel">取消</button>
							</div>
						</form>
				</div>';
                break;
            case "education":
                $newAddHtml='<div class="red_bd">
						<form class="form-horizontal new_add" role="form">
							<div class="form-group">
								<label>时间</label> <i>*</i> <input class="ip1 p2" name="start"
									type="text" readonly="readonly"> <span>到</span> <input
									name="end" class="ip1" type="text" readonly="readonly"
									placeholder="至今">
							</div>
							<div class="form-group">
								<label>学校</label>
								<i>*</i>
								<input class="ip2" type="text" name="school">
							</div>
							<div class="form-group">
								<label>学历/学位</label>
								<i>*</i>
								<input class="ip2" type="text" name="mba">
							</div>
							<div class="form-group">
								<label>专业</label>
								<i>*</i>
								<input class="ip2" type="text" name="profession">
							</div>
							<div class="form-group">
								<label>专业描述</label>
								<textarea class="ip3"></textarea>
							</div>
							<div class="btns">
								<button type="submit" class="save">保存</button>
								<button type="cancel" class="cancel">取消</button>
							</div>
						</form>
					</div>';
                break;
            case "schoolaward":
                $newAddHtml='<div class="red_bd">
						<form class="new_add" role="form">
							<div class="form-group">
								<label>时间</label> <input class="ip5" type="text" name="time">
							</div>
							<div class="form-group">
								<label>奖项</label> <input class="ip5" type="text" name="award">
							</div>
							<div class="form-group">
								<label>级别</label> <input class="ip5" type="text" name="level">
							</div>
							<div class="btns">
								<button type="submit" class="save">保存</button>
								<button type="cancel" class="cancel">取消</button>
							</div>							
						</form>
					</div>';
                break;
            case "schooljob":
                $newAddHtml='<div class="red_bd">
				<form class="form-horizontal new_add" role="form">
					<div class="form-group">
						<label>时间</label> <i>*</i> <input class="ip1 p2" name="start"
							type="text" readonly="readonly"> <span>到</span> <input
							name="end" class="ip1" type="text" readonly="readonly"
							placeholder="至今">
					</div>
					<div class="form-group">
						<label>职务</label>
						<i>*</i>
						<input type="text" class="ip2" name="job">					
					</div>
					<div class="form-group">
						<label>职务描述</label>
						<textarea></textarea>
					</div>
					<div class="btns">
						<button type="submit" class="save">保存</button>
						<button type="cancel" class="cancel">取消</button>
					</div>
				</form>
				</div>';
                break;
            case "skilllanguage":
                $newAddHtml='<div class="red_bd">
					<form class="form-horizontal new_add" role="form">
						<div class="form-group">
							<label>技能/语言</label>
							<i>*</i>
							<input type="text" class="ip5" name="skill">
						</div>
						<div class="form-group">
							<label>掌握程度</label>
							<i>*</i>
							<input type="text" class="ip5" name="master_level" name="level">
						</div>
						<div class="btns">
							<button type="submit" class="save">保存</button>
							<button type="cancel" class="cancel">取消</button>
						</div>
					</form>
				</div>';
                break;
            case "skillcertification":
                $newAddHtml = '<div class="red_bd">
					<form class="form-horizontal new_add" role="form">
						<div class="form-group">
							<label>获得时间</label>
							<i>*</i>
							<input class="ip5" type="text" name="time">
						</div>
						<div class="form-group">
							<label>证书</label>
							<i>*</i>
							<input class="ip5" type="text" name="certifications">
						</div>
						<div class="form-group">
							<label>成绩</label>
							<input class="ip5 noi" type="text" name="scoce">
						</div>
						<div class="btns">
							<button type="submit" class="save">保存</button>
							<button type="cancel" class="cancel">取消</button>
						</div>
					</form>
				</div>';
                break;
            case "skilltrain":
                $newAddHtml = '<div class="red_bd">
						<form class="form-horizontal new_add" role="form">
							<div class="form-group">
								<label>时间</label> <i>*</i> <input class="ip1" name="start"
									type="text" readonly="readonly"> <span>到</span> <input
									name="end" class="ip1" type="text" readonly="readonly"
									placeholder="至今">
							</div>
							<div class="form-group">
								<label>培训课程</label>
								<i>*</i>
								<input type="text" class="ip2" name="course">
							</div>
							<div class="form-group">
								<label>培训机构</label>
								<i>*</i>
								<input type="text" name="organ">
								<label>培训地点</label>
								<input type="text" name="">
							</div>
							<div class="form-group">
								<label>培训描述</label>
								<textarea></textarea>
							</div>
							<div class="btns">
								<button type="submit" class="save">保存</button>
								<button type="cancel" class="cancel">取消</button>
							</div>
						</form>
					</div>';
                break;
            case "additionattach":
                $newAddHtml = '<div class="red_bd">
						<form class="form-horizontal new_add" role="form">
							<div class="form-group">
								<label>附件名称</label> <i>*</i> <input type="text" class="ip5"
									name="attachname">
							</div>
							<div class="form-group">
								<label>上传方式</label> <i>*</i> <input type="text" class="ip5">
							</div>
							<div class="form-group">
								<div class="choose">
									<div class="word">选择</div>
									<input type="hidden" class="ip5">
								</div>
							</div>
							<div class="form-group">
								<label>附件描述</label>
								<textarea rows="10" cols="100"></textarea>
							</div>

							<div class="btns">
								<button type="submit" class="save">保存</button>
								<button type="cancel" class="cancel">取消</button>
							</div>
						</form>
					</div>';
                break;
        }
        return json($newAddHtml);
    }
    
    function editBaseInfo()
    {
        $requestData = $this->request->post();
        $Type = $requestData["type"];
        if(Session::has("resumeId"))
            $resumeId = session("resumeId");
        else 
            $this->error("no resume id;");
        $base=Db::name("resume_base_info")->where("resume_id",$resumeId)->select();
        if(count($base) <= 0 )
            $this->error("no info");
        $baseInfoHtml="";
        if($Type == "base")
        {
            $baseInfoHtml='<div class="red_bd">
						<form class="form-horizontal new_add" role="form">
							<div class="form-group">
								<div class="pull-left"><img src="http://img01.51jobcdn.com/im/2016/resume/man.png"
							width="85" height="104" alt="头像"></div>
								<div class="pull-left">
									<table>
										<tr>
											<td><label>姓名</label><i>*</i><input type="text" name="name" placeholder="'.$base["resume_name"].'"></td>
											<td><label>性别</label><input type="text" name="sex" placeholder="'.$base["sex"].'"></td>
										</tr>
										<tr>
											<td><label>出生日期</label><i>*</i><input type="text" name="birthday" placeholder="'.$base["	birthdy"].'"></td>
											<td><label>工作年份</label><i>*</i><input type="text" name="workage" placeholder="'.$base["work_age"].'"></td>
										</tr>
										<tr>
											<td><label>手机</label><i>*</i><input type="text" name="phone" palceholder="'.$base["phone"].'"></td>
											<td><label>邮箱</label><i>*</i><input type="text" name="email" placeholder="'.$base["email"].'"></td>
										</tr>
										<tr>
											<td><label>居住地</label><i>*</i><input type="text" name="address" placeholder="'.$base["address"].'"></td>
											<td><label>QQ</label><input type="text" name="qq" placeholder="'.$base["QQ"].'"></td>
										</tr>
										<tr>
											<td><label>身份证号</label><input type="text"
												name="indentity" placeholder="'.$base["identity"].'"></td>
											<td><label>婚姻状态</label><input type="text" name="marry" placeholder="'.$base["marry"].'"></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="btns">
								<button type="submit" class="save">保存</button>
								<button type="cancel" class="cancel">取消</button>
							</div>
						</form>
					</div>';
        }else if($Type == "carrer")
        {
            $baseInfoHtml='<div class="red_bd">
						<form class="form-horizontal new_add" role="form">
							<div class="form-group">
								<label>期望薪资</label>
								<i>*</i>
								<input type="text" name="salary" placeholder="'.$base["salary"].'">
							</div>
							<div class="form-group">
								<label>地点</label>
								<input type="text" name="address" placeholder="'.$base["work_place"].'">
							</div>
							<div class="form-group">
								<label>职能</label>
								<i>*</i>
								<input type="text" name="position" placeholder="'.$base["work_place"].'">
							</div>
							<div class="form-group">
								<label>行业</label>
								<i>*</i>
								<input type="text" name="industry" placeholder="'.$base["work_industry"].'">
							</div>
							<div class="form-group">
								<label>个人标签</label>
								<input type="text" name="person_label" placeholder="'.$base["master_label"].'">
							</div>
							<div class="btns">
								<button type="submit" class="save">保存</button>
								<button type="cancel" class="cancel">取消</button>
							</div>
						</form> 
					</div>';
        }
        return json($baseInfoHtml);
    }
    
}