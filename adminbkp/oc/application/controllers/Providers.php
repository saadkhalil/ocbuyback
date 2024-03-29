<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Providers extends My_Controller {
	
		public function __construct(){
			parent::__construct();
			
			$this->load->library('user_agent');
			$this->table='providers';
			$this->pagetitle='Providers';
			$this->viewname='providers';
		}
		
		public function index(){
			$this->Dmodel->checkLogin();
			$viewdata['title']=$this->pagetitle;
			$viewdata['records']=$this->Dmodel->get_tbl($this->table);
			$this->LoadView($this->viewname,$viewdata);
		}
		public function AddRecord(){
			$this->Dmodel->checkLogin();
			$data=$_POST;
			$data['created_at']=DateTime_Now;
			if($this->Dmodel->IFExist($this->table,'title',$data['title'])){
				$exec=$this->Dmodel->insertdata($this->table,$data);
				$last_id=$this->db->insert_id();
				if(isset($_FILES['logo']) && $_FILES['logo']['tmp_name']){
					$config['upload_path']          = APPPATH.'../assets/uploads/providers';
					$config['allowed_types']        = 'gif|jpg|png';
					$config['max_size']             = 10000;
					$config['max_width']            = 1024;
					$config['max_height']           = 768;
					$filename=$_FILES['logo']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$lname=strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $data['title']));
					$ldata['logo']=$last_id.'-'.$lname.'.'.$ext;
					$_FILES['logo']['name']=$ldata['logo'];
					$this->load->library('upload', $config);
					if(file_exists(APPPATH.'../assets/uploads/providers/'.$ldata['logo'])){
						unlink(APPPATH.'../assets/uploads/providers/'.$ldata['logo']);
					}
					if ( ! $this->upload->do_upload('logo')){
						$error = array('error' => $this->upload->display_errors());
					}
					else{
						$exec=$this->Dmodel->update_data($this->table,$last_id,$ldata,'id');
						$data = array('upload_data' => $this->upload->data());
					}
				}		
				echo $exec;
			}
			else{
				echo 2;
			}
		}
		public function EditRecord(){
			$this->Dmodel->checkLogin();
			$data=$_POST;
			$data['updated_at']=DateTime_Now;
			if($this->Dmodel->IFExistEdit($this->table,'title',$data['title'],$data['id'])){
				$exec=$this->Dmodel->update_data($this->table,$data['id'],$data,'id');
				if(isset($_FILES['logo']) && $_FILES['logo']['tmp_name']){
					$config['upload_path']          = APPPATH.'/../assets/uploads/providers';
					$config['allowed_types']        = 'gif|jpg|png';
					$config['max_size']             = 10000;
					$config['max_width']            = 1024;
					$config['max_height']           = 768;
					$filename=$_FILES['logo']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$lname=strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $data['title']));
					$ldata['logo']=$data['id'].'-'.$lname.'.'.$ext;
					$_FILES['logo']['name']=$ldata['logo'];
					$this->load->library('upload', $config);
					if(file_exists(APPPATH.'../assets/uploads/providers/'.$ldata['logo'])){
						unlink(APPPATH.'../assets/uploads/providers/'.$ldata['logo']);
					}
					if ( ! $this->upload->do_upload('logo')){
						$exec = array('error' => $this->upload->display_errors());
					}
					else{
						$exec=$this->Dmodel->update_data($this->table,$data['id'],$ldata,'id');
						$data = array('upload_data' => $this->upload->data());
					}
				}
				echo $exec;
			}
			else{
				echo 2;
			}
		}
		public function DeleteRecord(){
			$whr_key="id";
			$ids=$this->input->post('ids');
			$result=$this->Dmodel->delete_multi_rec($ids,$whr_key,$this->table);
			$this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissable">
			<i class="fa fa-check"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<b>Record Deleted.</b>
			</div>'); 
			redirect($this->agent->referrer()) ;
		}
		
		public function toggleStatus(){
			$id=$this->input->post('id');
			$data=$this->Dmodel->toggle_status($this->table,$id);
			echo $data; 
		}
	}
?>	