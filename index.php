<?php

$wechatObj = new IndexController();
$wechatObj->index();
class IndexController extends Controller {
   
    public function index(){
        $type = $_SERVER['REQUEST_METHOD'];
        if(isset($_GET['signature'])){
              $signature = $_GET["signature"];//从用户端获取签名赋予变量signature11
        $timestamp = $_GET["timestamp"];//从用户端获取时间戳赋予变量timestamp
        $nonce = $_GET["nonce"];    //从用户端获取随机数赋予变量nonce

        $token ='hhh';//将常量token赋予变量token
        $tmpArr = array($token, $timestamp, $nonce);//简历数组变量tmpArr
        sort($tmpArr, SORT_STRING);//新建排序
        $tmpStr = implode( $tmpArr );//字典排序
        $tmpStr = sha1( $tmpStr );//shal加密
        //tmpStr与signature值相同，返回真，否则返回假
        if( $tmpStr == $signature ){
        echo $_GET["echostr"];
        }else{
        return false;
        }
           }     
    if($type=='POST'){
           $this->responseMsg();
    }
         /*$strP = file_get_contents("php://input");
         $postObj = simplexml_load_string($strP, 'SimpleXMLElement', LIBXML_NOCDATA);
         dump2file(1);*/
  }
  public function responseMsg(){
      //get post data, May be due to the different environments
      $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
     
      //extract post data
      if (!empty($postStr)){
         
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
           <ToUserName><![CDATA[%s]]></ToUserName>
           <FromUserName><![CDATA[%s]]></FromUserName>
           <CreateTime>%s</CreateTime>
           <MsgType><![CDATA[%s]]></MsgType>
           <Content><![CDATA[%s]]></Content>
           <FuncFlag>0</FuncFlag>
           </xml>";    
        if(!empty( $keyword ))
        {
         $msgType = "text";
         $contentStr = "Welcome to wechat world!";
         $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
         echo $resultStr;
        }else{
         echo "Input something...";
        }
     
      }else {
       echo "";
       exit;
      }
     }


}
