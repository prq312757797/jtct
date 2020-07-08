<?php
namespace Hl\Controller;
use Think\Controller;

class ExampleController extends Controller {
	private $_APPKEY = ''; 
    
    private $_APIURL = "http://highapi.kuaidi.com/openapi-querycountordernumber.html?";
    
    private $_show = 0;

    private $_muti = 0;

    private $_order = 'desc';
    
    /**
     * 您获得的快递网接口查询KEY。
     * @param string $key
     */
    public function KuaidiAPi($key){
        $this->_APPKEY = $key;
    }

    /**
     * 设置数据返回类型。0: 返回 json 字符串; 1:返回 xml 对象
     * @param number $show
     */
    public function setShow($show = 1){
        $this->_show = $show;
    }
    
    /**
     * 设置返回物流信息条目数, 0:返回多行完整的信息; 1:只返回一行信息
     * @param number $muti
     */
    public function setMuti($muti = 0){
        $this->_muti = $muti;
    }
    
    /**
     * 设置返回物流信息排序。desc:按时间由新到旧排列; asc:按时间由旧到新排列
     * @param string $order
     */
    public function setOrder($order = 'desc'){
        $this->_order = $order;
    }

    /**
     * 查询物流信息，传入单号，
     * @param 物流单号 $nu
     * @param 公司简码 $com 要查询的快递公司代码,不支持中文,具体请参考快递公司代码文档。 不填默认根据单号自动匹配公司。注:单号匹配成功率高于 95%。
     * @throws Exception
     * @return array
     */
    public function query($nu, $com=''){
        if (function_exists('curl_init') == 1) {
            
            $url = $this->_APIURL;

            $dataArr = array(
                'id' => $this->_APPKEY,
                'com' => $com,
                'nu' => $nu,
                'show' => $this->_show,
                'muti' => $this->_muti,
                'order' => $this->_order
            );

            foreach ($dataArr as $key => $value) {
                $url .= $key . '=' . $value . "&";
            }

           //  echo $url;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            $kuaidresult = curl_exec($curl);
            curl_close($curl);

            if($this->_show == 0){
                $result = json_decode($kuaidresult, true);
            }else{
                $result = $kuaidresult;
            }

            return $result;

        }else{
            throw new Exception("Please install curl plugin", 1); 
        }
    }
	
	
	function index1215(){
		//1215  curl 直接使用无效，改写了
		
//include 'KuaidiAPI.php';

//根据订单号得到   运单号、快递公司代码

	$field='
		order_form.order_num,order_form.express_id,order_form.express_num,
		
		express.code
	';

	$order_info=M("order_form")
	->field($field)
	->join('left join express ON express.id=order_form.express_id')
	->where("order_num='".$_POST["order_num"]."'")
	->find();

if($order_info["express_id"]==0){
	//快递公司为无   无需物流信息
	$result["data"]="0";
	$this->ajaxReturn($result["data"]);
}else{
	$order_num=$order_info["express_num"];
	$company_code=$order_info["code"];

	//	$order_num="3924324620831";
	//	$company_code="yunda";
	
//修改成你自己的KEY
$key = 'c684ab43a28bc3caea53570666ce9762'; 

$kuaidichaxun = $this->KuaidiAPi($key);

//设置返回格式。 0: 返回 json 字符串; 1:返回 xml 对象
//$kuaidichaxun->setShow(1); //可选，默认为 0 返回json格式

//返回物流信息条目数。 0:返回多行完整的信息; 1:只返回一行信息
//$kuaidichaxun->setMuti(1); //可选，默认为0

//设置返回物流信息排序。desc:按时间由新到旧排列; asc:按时间由旧到新排列
//$kuaidichaxun->setOrder('asc');

//查询
///1010   $result = $kuaidichaxun->$this->query('886543311583751296', 'yuantong');
//$result = $this->query('886543311583751296', 'yuantong');

$result = $this->query($order_num, $company_code);

//带公司短码查询，短码列表见文档
//$result = $kuaidichaxun->query('111111', 'quanfengkuaidi');

//111111 快递单号
//quanfengkuaidi   快递公司名称

//echo json_encode($result);

//dump($result["data"]);die;

$this->ajaxReturn($result["data"]);
}



}
	function index(){
		
		$field='
		order_form.order_num,order_form.express_id,order_form.express_num,
		
		express.code
	';

	$order_info=M("order_form")
	->field($field)
	->join('left join express ON express.id=order_form.express_id')
	->where("order_num='".$_POST["order_num"]."'")
	->find();

		if($order_info["express_id"]==0){
			//快递公司为无   无需物流信息
			$result["data"]="0";
			$this->ajaxReturn($result["data"]);
		}else{
				$key = 'c684ab43a28bc3caea53570666ce9762'; 
				$kuaidichaxun = $this->KuaidiAPi($key);
		
		 		$url = "http://highapi.kuaidi.com/openapi-querycountordernumber.html?id=".$this->_APPKEY."&com=".$order_info["code"]."&nu=".$order_info["express_num"]."&show=".$this->_show."&muti=".$this->_muti."&order=".$this->_order;

		        $result = $this->http_request($url);
		   // dump($url);
		        $result = json_decode($result, true);
  		//	dump($result);die;
		        $this->ajaxReturn($result["data"]);
		}
		
	
	}
	function test(){
 		$this->ajaxReturn(123);
	}
function test_1(){
	$url = "https://sz800800.cn/adp.php/Example/test";
		
	$result = $this->http_request($url);
	$this->ajaxReturn($result."啦啦啦");
}
	 public function http_request($url,$data = null,$headers=array())
    {
        $curl = curl_init();
        if( count($headers) >= 1 ){
        	curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', 'CLIENT-IP:123.207.42.92'));//IP 
        //    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        
        $ip_set="CLIENT-IP:123.207.43.9".rand(1,9);
         curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', $ip_set));//IP 
       
     //   curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', 'CLIENT-IP:8.8.8.8'));//IP 
     curl_setopt($ch, CURLOPT_REFERER, "http://www.jb512.net/ ");   //来路 
	        curl_setopt($curl, CURLOPT_URL, $url);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
	
}


