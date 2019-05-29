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

	private $participants = array(//initial array
		"0"=>array("status"=>"","count"=>1),//farmer
		"1"=>array("status"=>"","count"=>1),//cow1
		"2"=>array("status"=>"","count"=>1),//cow2
		"3"=>array("status"=>"","count"=>1),//bunny1
		"4"=>array("status"=>"","count"=>1),//bunny2
		"5"=>array("status"=>"","count"=>1),//bunny3
		"6"=>array("status"=>"","count"=>1),//bunny4
	);


	private $died=array();

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url'));
	}

	public function index(){
		if(!empty($this->input->post('died')))
			$this->died=json_decode($this->input->post('died'),true);//Died array	
		$participants=array(0,1,2,3,4,5,6);//array of participants
		$active_participants=array_diff($participants,$this->died);//getting the diffrence array between died and participants
		$feed=array_rand($active_participants,1);
		/*Default 1st round data*/
		$response=array();
		$response['round']=1;
		$response['died']=json_encode(array());
		$this->participants[$feed]['count']=0;
		$this->participants[$feed]['status']="Fed";
		$response['feed_history']=json_encode($this->participants);
		$response['roundwise'][$response['round']][]=$response['feed_history'];
		/*End Default 1st round data*/
		if(strtoupper($this->input->server('REQUEST_METHOD'))=="POST"){
			$response=$this->set_fed_ui($feed);
		}		
		$this->load->view("feed",$response);
	}

	public function set_fed_ui($feed){	
		$this->died=json_decode($this->input->post('died'),true);//Died array	
		$this->participants=json_decode($this->input->post('feed_history'),true);//Last participants array with count
		$feed_data['roundwise']=json_decode($this->input->post('roundwise'),true);//History of feed roudwise
		foreach ($this->participants as $key => &$value) {
				$value['status']="";
				if($value['count'] != -1){
					$value['count']=$value['count']+1;
				}
				if($key==0){
					if($value['count'] > 15 ){
						$this->died[$key]=$key;
						$value['status']="Died";
						$value['count'] = -1;
						break;					
					}
				}
				if($key==1 || $key==2){
					if($value['count'] > 10  ){
						$this->died[$key]=$key;
						$value['status']="Died";
						$value['count']= -1;					
					}
				}
				if($key==3 || $key==4 || $key==5 || $key==6 ){				
					if($value['count'] >8  ){
						$this->died[$key]=$key;
						$value['status']="Died";
						$value['count']= -1;					
					}
				}	

			if($feed==$key && $value['count'] != -1){
				$value['status']="Fed";
				$value['count']=0;
			}
		}
		$feed_data['round'] = $this->input->post('round') + 1;		
		$feed_data['died']= json_encode($this->died);
		$feed_data['feed_history']= json_encode($this->participants);
		$feed_data['roundwise'][$feed_data['round']][]=$feed_data['feed_history'];
		if(in_array(0, $this->died) ){//to check if farmer is died or not
			$feed_data['game_over']="Farmer died! Game Over.";
		}
		else if( $feed_data['round']==50){// Check if 50 rounds are over or not.
			$feed_data['game_over']="You won!";
		}
		return $feed_data;
	}
	public function reset_fed(){
		redirect('farmgame','refresh');
	}
	
}
