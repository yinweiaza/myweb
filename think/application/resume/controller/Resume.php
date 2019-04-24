<?php
namespace app\resume\controller;
use think\Controller;
use think\Db;
class Resume extends Controller
{
    public function index()
    {
        $this->assign("title", "骑着蜗牛去看海的简历");
        return $this->fetch();
    }
    
    function edit()
    {
        //工作经验；
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
                $newAddHtml='';
                break;
            case "schooljob":
                $newAddHtml='';
                break;
            case "skilllanguage":
                $newAddHtml='';
                break;
            case "skillcertification":
                $newAddHtml = '';
                break;
            case "skilltrain":
                $newAddHtml = '';
                break;
            case "additionattach":
                $newAddHtml = '';
                break;
        }
        return json($newAddHtml);
    }
}