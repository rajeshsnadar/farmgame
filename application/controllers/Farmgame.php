<?php
/**
 * Farmgame - Controller
 *
 * @category Controller
 * @package Farmgame
 * @subpackage Farmgame
 * @author Rajeshkkumar Nadar <rajeshsnadar1989@gmail.com>
 * @copyright 2019 
 * @version 1.0.0
 * 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Farmgame extends CI_Controller {

	private $participants = array(
		0,//farmer
		1,//cow1
		2,//cow2
		3,//bunny1
		4,//bunny2
		5,//bunny3
		6,//bunny4
	);
	private $round=0;

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url'));
	}

	public function index(){
		$feed=rand(0,6);
		$response=array();
		if(strtoupper($this->input->server('REQUEST_METHOD'))=="POST"){
			$response['fed_data']=$this->set_fed($feed);
		}
		$this->load->view("feed",$response);

	}
	public function set_fed($feed){
		$this->round=$this->session->userdata('round')?$this->session->userdata('round'):0;
		if($this->round > 50 ){
			$response["error"]=0;
			$response["message"]="";
			$response["disable_submit"]=True;
			return $response;
		} 
		$data_history[$this->round][$feed]="Fed";
		
		if (!empty($this->session->userdata('feed_history')) ){
			$feed_history = $this->session->userdata('feed_history');
			$feed_history[$this->round][$feed]="Fed";
			$this->session->set_userdata('feed_history',$feed_history);
		}else{
			$this->session->set_userdata('feed_history',$data_history);
		}

		if(empty($this->round) ){
			$this->round++;
			$this->session->set_userdata('round',$this->round);
		}else{
			$this->round++;
			$this->session->set_userdata('round',$this->round);
		}

		return $data_history;
	}
	public function turn_count($feed){
				
	}

	public function reset_fed(){
		$this->session->set_userdata('feed_history','');
		$this->session->set_userdata('round',0);
		redirect('farmgame','refresh');

	}
	
}

