<?php
namespace AdminSh\Controller;
use Think\Controller;
class DistributionController extends CommonController {
    //分销商管理
    //分销商增长趋势
    //分销商等级
    //分销订单
    //分销商统计
    //分销关系
    //待审核的
    //待打款的
    //已打款的
    //无效的
    //基础设置


    //分销商管理
    public function index(){

    	$this->display();
	}
   //分销商增长趋势
    public function fx_trend(){
echo  1;
        $this->display();
    }
    //分销商等级
    public function fx_lever(){

        $this->display();
    }
    //分销订单
    public function fx_order(){

        $this->display();
    }
    //分销商统计
    public function fx_count(){

        $this->display();
    }
    //分销关系
    public function fx_relation(){

        $this->display();
    }
    //    提现申请=============================================================
    //待审核的
    public function cash_ing(){

        $this->display();
    }
    //待打款的
    public function cash_git(){

        $this->display();
    }
    //已打款的
    public function cash_done(){

        $this->display();
    }
    //无效的
    public function cash_none(){

        $this->display();
    }


    //基础设置==============================================
    public function cash_set(){

        $this->display();
    }
}