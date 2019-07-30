<?php
namespace app\portfolio\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Validate;
class Portfolio extends Controller
{
    public function index()
    {
        $this->assign("title", "骑着蜗牛去看海的相册");
        $albums = Db::name("album")->select();
      
        for($idx = 0; $idx<count($albums); $idx++)
        {
            $tmpId=$albums[$idx]["album_id"];
            $allPhotos = Db::name("photo")->where("album_id", $tmpId)->select();
            if(count($allPhotos) == 0)
                $albums[$idx]["firstImg"] = "#";
            else
                $albums[$idx]["firstImg"] = $allPhotos[0]["photo_path"];
        }
        $this->assign("albums",$albums);
        $this->assign("albumList", $albums);
        return $this->fetch();
    }
    
    /**
     * 创建相册
     */
    public function createAblum()
    {
        //第一种方法：
        $tmpData=$this->request->post();
        $requestData=[
            'name'=>$tmpData["album_name"],
            'des'=>$tmpData["description"],
        ];
        $rule=[
            'name'=>'require|max:10',            
        ];
        $msg=[
            'name.require' => '名称必须',
            'name.max' => '名称最多不能超过25个字符'            
        ];
        $validator= new Validate($rule, $msg);
        if(!$validator->check($requestData))
        {
            return json($validator->getError());
        }
        
        if(Db::name("album")->where("album_name", $requestData["name"])->find())
            return json("该相册已经存在，请更换名称！");
        
        //创建专辑；        
        $newId = findNewId("album", "album_id");
        $newAlbum=[
            "album_id"=>$newId,
            "album_name"=>$requestData["name"],
            "album_msg"=>$requestData["des"],
            "album_create_time"=>date('Y-m-d H:i:s',time()),
        ];
        Db::name("album")->insert($newAlbum);
        return  json("相册".$newAlbum["album_name"]."创建成功");
    }
    
    /**
     * 删除指定的相册；
     * @param unknown $albumsId
     */
    public  function deleteAblum()
    {
        $requestData=$this->request->post(); 
        for($idx = 0; $idx < count($requestData); $idx++)
        {
            $tmpAlbumId= $requestData[$idx];
            Db::name("album")->where("album_id", $tmpAlbumId)->delete();
            Db::name("photo")->where("album_id", $tmpAlbumId)->delete();
        }
        return json("删除成功!");
    }
    
    
    /**
     * 删除图像;
     * @param unknown $albumsId
     * @param unknown $photoId
     */
    public  function  deletePhoto()
    {
        $requestData=$this->request->post(); 
        for($idx = 0; $idx < count($requestData); $idx++)
        {
            $tmpAlbumId = $requestData[$idx][0];
            $tmpPhotoId = $requestData[$idx][1];
            if(Db::name("photo")->where("album_id", $tmpAlbumId)->where("photo_id", $tmpPhotoId)->find())
            {
                Db::name("photo")->where("album_id", $tmpAlbumId)->where("photo_id", $tmpPhotoId)->delete();
            }
        }
        return json("删除成功!!");
    }
    
    /**
     * 上传图像；
     * @param unknown $photoUrl
     */
    public function  uploadPhotos($photoUrl)
    {
        
        
    }
       
    
    public function  addPhoto($albumId, $photoName)
    {
        $albumName = Db::name("album")->where("album_id", $albumId)->value("album_name");
        $photoPath=$_SERVER["DOCUMENT_ROOT"]."/Uploads/Albums/".$albumName.'/'.$photoName;
        $relativePath="/Uploads/Albums/".$albumName.'/'.$photoName;
        if(is_file($photoPath))
        {
            //保存；
            $minId = Db::name("photo")->min("photo_id");
            $maxId = Db::name("photo")->max("photo_id");
            for($idx = 0; $idx >= $minId && $idx <= $maxId; $idx++)
            {
                if(!Db::name("photo")->where("photo_id", $idx)->find())
                    break;
            }
            $newData=[
                "photo_id"=>$idx,
                "album_id"=>$albumId,
                "photo_path"=>$relativePath
            ];   
            Db::name("photo")->insert($newData);
        }
    }
    
    /**
     * 显示指定相册下的所有图像；
     * @param unknown $albumsId
     */
    public  function  showPhotos($id)
    {
        if(! Db::name("album")->where("album_id",$id)->find())
            $this->error("该相册不存在");
        else 
        {
            $albumName=Db::name("album")->where("album_id",$id)->value("album_name");
            $photoRecord=Db::name("photo")->where("album_id",$id)->select();
            $this->assign("title","相册:".$albumName);
            $this->assign("album_name", $albumName);
            $this->assign("album_photo", $photoRecord);
            return $this->fetch("showPhoto");
        }        
    }
    
}