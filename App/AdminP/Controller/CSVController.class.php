<?php
namespace AdminP\Controller;
use Think\Controller;
class CSVController extends CommonController {
    public function index(){
	$csvData = M('car_allcar')->field('id,title,program_id,sort')->order("id")->select();
	
	$this->export_csv($csvData);
	
	}
		function test0122(){
		echo 333;
		dump(444);
	}
	/**
	 * 导出csv  开始
	 * */
	public function export_csv($csvData){
		$time = date('Y-m-d H:i:s', time());	
		
		
		$str = "id,title,program_id,sort\n";
		$str = iconv('utf-8', 'gb2312', $str);
		foreach ($csvData as $item) {
			$question = iconv('utf-8', 'gb2312', $item['id']);

			$a = iconv('utf-8', 'gb2312', $item['title']);
			$b = iconv('utf-8', 'gb2312', $item['program_id']);
			$c = iconv('utf-8', 'gb2312', $item['sort']);

		

			$str .= $question . "," . $a . "," . $b . "," . $c . "," . $d . "," . $e . "," . $f . "\n";
		}

		$jiange= " , , , , , , , , , , \n";//间隔
		$bottom_remark = iconv('utf-8', 'gb2312', "订单记录 \n");
		$filename = '下载于' . $time . '订单记录.csv';
		$this->export_filename($filename, $str);
		$this->export_filename($filename, $jiange);
		$this->export_filename($filename, $bottom_remark);
	}
	

	public function export_filename($filename,$data){
		header("Content-type:text/csv");
		header("Content-Disposition:attachment;filename=" . $filename);
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		echo $data;
	}
	/**
	 * 导出csv  结束
	 * */
}