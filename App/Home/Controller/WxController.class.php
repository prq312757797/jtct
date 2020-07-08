<?php
namespace Home\Controller;
use Think\Controller;
define("TOKEN", "jack");

class WxController extends Controller {
	
/* https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' + that.data.access_token; 
     * 微信规定：不能直接在小程序调用，只能在后台发起
     *  -xzz0704 
     */
    public function send_msg(){
              $data = $_POST;
                $access_token = I('POST.access_token');
                $touser = I('POST.touser');
                $template_id = I('POST.template_id');
                $page = I('POST.page');
                $form_id = I('POST.form_id');
                $keyword1 = I('POST.keyword1');
                $fee = I('POST.keyword4')?I('POST.keyword4'):'免费';  //活动费用，默认0.00免费
                
                /* 
                 * 根据活动id，获取活动对应的地址信息，$keyword3  -xzz 0705
                 */
                $a_id = I('POST.keyword3');
                $msg = M('activity','xxf_witkey_')->where('a_id='.$a_id)->field('a_id,act_name,province,city,town,address')->find();
                $province = M('district','xxf_witkey_')->where('id='.$msg['province'])->getField('name');
                $city = M('district','xxf_witkey_')->where('id='.$msg['city'])->getField('name');
                $town = M('district','xxf_witkey_')->where('id='.$msg['town'])->getField('name');
                $keyword3 = $province.$city.$town.$msg['address'];
                
                if(empty($keyword1)){
                    exit('empty activity message!');
                }
                $value = array(
                    "keyword1"=>array(
                    "value"=>I('POST.keyword1'),
                     //"value"=>'woshihaoren',
                    "color"=>"#4a4a4a"
                    ),
                    "keyword2"=>array(
                        "value"=>I('POST.keyword2'),
                        "color"=>"#9b9b9b"
                    ),
                    "keyword3"=>array(
                        "value"=>$keyword3,
                        "color"=>"#9b9b9b"
                    ),
                    "keyword4"=>array(
                        "value"=>$fee,
                        "color"=>"#9b9b9b"
                    ),
                    "keyword5"=>array(
                        "value"=>I('POST.keyword5'),
                        "color"=>"#9b9b9b"
                    ),
                    "keyword6"=>array(
                        "value"=>I('POST.keyword6'),
                        "color"=>"#9b9b9b"
                    ),
                    "keyword7"=>array(
                        "value"=>I('POST.keyword7'),
                        "color"=>"#9b9b9b"
                    ),
                    "keyword8"=>array(
                        "value"=>I('POST.keyword8'),
                        "color"=>"#9b9b9b"
                    ),
                    "keyword9"=>array(
                        "value"=>I('POST.keyword9'),
                        "color"=>"red"
                    )
                );
                
                $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
                $dd = array();
                //$dd['access_token']=$access_token;
                $dd['touser']=$touser;
                $dd['template_id']=$template_id;
                $dd['page']=$page;  //点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
                $dd['form_id']=$form_id;
                
                $dd['data']=$value;                        //模板内容，不填则下发空模板
                
                $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
                //$dd['color']='#ccc';
                $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
                //$dd['emphasis_keyword']='keyword1.DATA';
                
                //$send = json_encode($dd);   //二维数组转换成json对象
                
                /* curl_post()进行POST方式调用api： api.weixin.qq.com*/
                $result = $this->https_curl_json($url,$dd,'json');
                if($result){
                    echo json_encode(array('state'=>5,'msg'=>$result));
                }else{
                    echo json_encode(array('state'=>5,'msg'=>$result));
                }
    }
    /* 发送json格式的数据，到api接口 -xzz0704  */
    function https_curl_json($url,$data,$type){
        if($type=='json'){//json $_POST=json_decode(file_get_contents('php://input'), TRUE);
            $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
            $data=json_encode($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
        $output = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl);
        return $output;
    }
	
	
    /* 调用微信api，获取access_token，有效期7200s -xzz0704 */
    public function get_accessToken(){
        /* 在有效期，直接返回access_token */
        if(S('access_token')){
            return S('access_token');
        }
        /* 不在有效期，重新发送请求，获取access_token */
        else{
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=YourAppid&secret=YourXiaochengxuSecret';
            $result = curl_get_https($url);　　　　//就是一个普通的get方式调用https接口的请求，我就不写出来了，自己找去。
            $res = json_decode($result,true);   //json字符串转数组
            
            if($res){
                S('access_token',$res['access_token'],7100);
                return S('access_token');
            }else{
                return 'api return error';
            }
        }
    }
}
?>