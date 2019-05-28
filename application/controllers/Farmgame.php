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
		0=>0,//farmer
		1=>0,//cow1
		2=>0,//cow2
		3=>0,//bunny1
		4=>0,//bunny2
		5=>0,//bunny3
		6=>0,//bunny4
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
				
		if (!empty($this->session->userdata('feed_history')) ){
			$data_history = $this->session->userdata('feed_history');			
		}
		$data_history[$this->round][$feed]=$this->turn_count($feed);
		$this->session->set_userdata('feed_history',$data_history);

		$this->round++;
		$this->session->set_userdata('round',$this->round);
		
		return $data_history;
	}

	public function turn_count($feed){
		if( !empty($this->session->userdata('turn_count')) ){
			$turn_count=$this->session->userdata('turn_count');
			$died_paricipant=$this->session->userdata('died');

			foreach ($turn_count as $key => $value) {
				//exit;
				if($feed==$key){
					$turn_count[$key]=0;
				}else{
					$turn_count[$key]=$value+1;
				}
				if($feed==0){
					if($turn_count[$key] > 15){
						$died_paricipant[$feed]=$feed;
					}
				}elseif($feed == 1 || $feed == 2){
					if($turn_count[$key] > 10){
						$died_paricipant[$feed]=$feed;
					}
				}elseif( $feed == 3 || $feed == 4 || $feed == 5 || $feed == 6 ){
					if($turn_count[$key] > 8){
						$died_paricipant[$feed]=$feed;
					}
				}

				
				
			}
			echo "<pre>";
			print_r($died_paricipant);
			echo "</pre>";
			echo "<pre>";
			print_r($turn_count);
			echo "</pre>";


			$fed_text="Fed";
			if (!empty($died_paricipant)){
				
					if(in_array($feed, $died_paricipant)  ){
						$fed_text= "Died";
					}
				
			}

			$this->session->set_userdata('died',$died_paricipant );			
			$this->session->set_userdata('turn_count',$turn_count);

			return $fed_text;
		}else{
			//echo "Rajesh";
			$turn_count=$this->participants;
			foreach ($turn_count as $key => $value) {
				if($feed!=$key){					
					$turn_count[$key]=$this->participants[$key]+1;					
				}				
			}
			print_r($turn_count);
			$this->session->set_userdata('turn_count',$turn_count);
			$this->session->set_userdata('died',array() );
			return "Fed";
		}
		
	}

	public function reset_fed(){
		$this->session->set_userdata('feed_history','');
			$this->session->set_userdata('turn_count','');

		$this->session->set_userdata('died',array());
		$this->session->set_userdata('round',0);
		redirect('farmgame','refresh');

	}
	
}

