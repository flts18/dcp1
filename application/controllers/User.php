<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller 
{
    
  function __construct()
    {
	parent::__construct();
	$this->load->helper('captcha');
	
	$this->load->model('User_model');
	$this->load->model('General_model');
	$this->load->library("pagination");
	
    $this->load->library('form_validation');
    

    }
    
    public function fetch_email_ph()
	{
		check_user_page_access();
	   if($this->input->post('uid',true)){
		    $results= $this->User_model->get_email_ph($this->input->post('uid',true));
			$res=array("e"=>$results["email"],"p"=>$results["phone"]);
			echo json_encode($res);
	   }
       
	}

//add section
    public function add_section()
    {
        check_user_page_access();
		$sec="";
    	//$data['section']= $this->File_model->General_model->view_all_data('fts_section');
        $data['section']= $this->User_model->parent_sec();
		$data["active"]="add_section_page";
    	$content=$this->load->view("add_section/add_section",$data,true);
    	render($content);

    }


 public function insert_section()
    {
        check_user_page_access();
    	$data_value=array(
		              
		              "sec_name"=>strtoupper($this->input->post('sec_name', TRUE)),
					  "sec_code"=>strtoupper($this->input->post('sec_code', TRUE)),
					  
					  );
    	$this->form_validation->set_rules('sec_name', 'sec name','required|is_unique[ fts_section.sec_name]',array('is_unique'=> 'This %s already exists.'));
    	
 if ($this->form_validation->run() == FALSE)
                {
                     
                      $data["active"]="";
    	
    	$content=$this->load->view("add_section/add_section",$data,true);
    	render($content);


                }
                else
                {
		           

    	if($sec_id=$this->General_model->insert_data('fts_section',$data_value))
    	{	
    	  $this->session->set_flashdata('success_message', 'Section has been registered successfully.');
		}
		else
		{
		  $this->session->set_flashdata('error_message', 'Error. Try again later.');	
		}
    	redirect("user/add_section");
	    	}

}


 //add sub section
    public function add_sub_section()
      {
      	check_user_page_access();
    	 $sec="";
    	 $data['section']= $this->User_model->parent_sec();
    	if(trim($this->input->post('sec', TRUE))!="")
    {

    $this->session->set_userdata(array('sec_id'=>trim($this->input->post('sec', TRUE))));

    }
    	$data["active"]="add_sub_section_page";

		$content=$this->load->view("add_section/add_sub_section",$data,true);
    	render($content);

     }
    		

      public function insert_sub_section()
    {       
        check_user_page_access();
         $data_value=array(
                      
                      "sec_name"=>strtoupper($this->input->post('sec_name', TRUE)),
                      "sec_code"=>strtoupper($this->input->post('sec_code', TRUE)),
                      "parent_sec"=>$this->input->post('sec', TRUE),
                      );
        

     if($this->General_model->section_unique($this->input->post('sec', TRUE),strtoupper($this->input->post('sec_name', TRUE))))
     {
        if($sec_id=$this->General_model->insert_data('fts_section',$data_value))
        {   
          $this->session->set_flashdata('success_message', 'Sub Section has been registered successfully.');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Error. Try gain later.'); 
        }
    }
    else
    {
        $this->session->set_flashdata('error_message', 'section name allready exist.');
    }

        redirect("user/add_sub_section");

}

public function set_access()
    {
        check_user_page_access();
        $sec="";
        //$data['section']= $this->File_model->General_model->view_all_data('fts_section');
        $data['section']= $this->User_model->parent_sec();
        $data["active"]="add_section_page";
        $content=$this->load->view("add_section/add_section",$data,true);
        render($content);

    }

function forceLogoutOnbrowserClose()
	{
		check_user_page_access();
		if(isset($_POST['force_logout']))
		{
			$this->User_model->forceLogoutOnbrowserClose();
			$_SESSION['browserCloseBefore'] = true;
		}
	}
	function checkCurrentUserExists()
	{
		if($this->session->userdata('user_id')!="" && isset($_SESSION['browserCloseBefore'])){
			$this->User_model->setUserLoginOn();
			unset($_SESSION['browserCloseBefore']);
		}
	}

//login
	public function login()
	{
		
		/**if($this->session->userdata('user_id')!='')
        { 
            redirect('home_controller');
			exit;
        }**/
		
		$username=$this->input->post('username', TRUE);
		//$fullname=$this->input->post('name', TRUE);
		$password=md5($this->input->post('pwd', TRUE));
		//$user_type=$this->input->post('user_type', TRUE);
		$user_ip=get_client_ip();
		
		if($this->input->post('username', TRUE)!="")
		{
			/**echo $inputCaptcha = $this->input->post('captcha_fld').'<br>';
			echo $sessCaptcha = $this->session->userdata('captchaCode').'<br>'; exit;**/
			$inputCaptcha = $this->input->post('captcha_fld');
			$sessCaptcha = $this->session->userdata('captchaCode');
			if($inputCaptcha == $sessCaptcha){
				$data_arr= $this->User_model->authenticate($username,$password);
				if(isset($data_arr) && is_array($data_arr))
				{
					if($data_arr['is_active']=='Y')
					{
						$this->User_model->log_this_login($data_arr);
						login_log(doctype_action('ULgin'),'U',$this->session->userdata('user_id'));
						//$this->user_details=check_user_page_access();
						$this->session->set_userdata('file_letter', 'letter');
						redirect('home_controller');
						exit;
					}
					else
					{
						$this->session->set_flashdata('error_message', 'You are not permitted by Administrator');
					}
				}
				else
				{
					
					$this->session->set_flashdata('error_message', 'Invalid username or password');
					
				}
			}else{
				$this->session->set_flashdata('error_message', 'Captcha code was not match, please try again.');
				
			}
			
		}
		
		/**$this->load->library('antispam');
		$configs = array(
				'img_path'      => 'captcha_images/',
				'img_url'       => base_url().'captcha_images/',
				'img_height' => '50',
			);			
		$captcha = $this->antispam->get_antispam_image($configs);
        
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);**/
        
        $data['captchaImg'] = '';
		
		$this->load->view('user/login',$data);
	}
	
	//logout
	 function logout()
    {
        if($this->session->userdata('user_id')!=""){
        	login_log(doctype_action('ULgout'),'U',$this->session->userdata('user_id'));
    		$this->User_model->logout();
			//$this->session->sess_destroy();
        }
		redirect('/', 'refresh');
    }
	
	function set_section(){

        $content=$this->load->view('user/user_access_section');
       
        render($content);
    }
	//profile
	function profile()
	{
        //$this->user_details=check_user_page_access();
		check_user_page_access();
		
		$data['designation']=$this->General_model->view_all_data('fts_designation');
		$data['data_value']=$this->User_model->profile();
		$data['section_name']=$this->User_model->parent_sec();

		//echo $data['data_value'][0]['sec_id'];
		//print_r (explode(',',$data['data_value'][0]['sec_id']));exit;
		//$data['designation']=$this->User_model->designation(explode(',',$data['data_value'][0]['desig_id']));
		$data['sec_name']=$this->User_model->section(explode(',',$data['data_value'][0]['sec_id']));
		$data['usr_desig']=$this->User_model->designation(explode(',',$data['data_value'][0]['desig_id']));
		       $content=$this->load->view('user/user_profile',$data,true);
		    render($content);
			
	}
	//profile update
	
	function profile_update()
	{
		check_user_page_access();
		$data_value=array(
		              
		              "name"=>strtoupper($this->input->post('name', TRUE)),
					  "email"=>$this->input->post('email', TRUE),
					  "user_name"=>$this->input->post('uname', TRUE),
					  "phone"=>$this->input->post('phone', TRUE),
					  "gender"=>$this->input->post('gender',TRUE),
					  );
		$sec_id='';
                	if(implode("",$this->input->post('section', TRUE))=="others")
                	{
                	 	//echo $this->input->post('add_sec', TRUE);exit;
                	 	$sec_add=array("sec_name"=>strtoupper($this->input->post('add_sec', TRUE)));
                		$sec_id=$this->General_model->insert_data('fts_section',$sec_add);	
                	}
                	else if($this->input->post('subsec_list', TRUE)!="" && implode("",$this->input->post('subsec_list', TRUE))!="")
                	{
                		
                		$sec_id=implode(",",$this->input->post('subsec_list', TRUE));
                	}
                	else
                	{
                		
                		$sec_id=implode(",",$this->input->post('section', TRUE));
                	}

             $desig_id='';
                	if(implode("",$this->input->post('designation', TRUE))=="others")
                	{
                	 	
                	 	$desig_add=array("desig_name"=>strtoupper($this->input->post('add_desig', TRUE)));
                		$desig_id=$this->General_model->insert_data('fts_designation',$desig_add);	
                	}
                	else
                	{
                		
                		$desig_id=implode(",",$this->input->post('designation', TRUE));
                	}


	if($this->General_model->update_data('fts_user',$data_value,array('user_id'=>$this->session->userdata('user_id'))))
	{
		login_log(doctype_action('UPro'),'U',$this->session->userdata('user_id'));
		$this->session->set_userdata('fullname',strtoupper($this->input->post('name', TRUE)));
	$this->session->set_flashdata('success_message', 'The User Profile is updated successfully.');
	}
	$data_personel=array(

					"desig_id"=>$desig_id,
					"sec_id"=>$sec_id,
					);
	//echo $data_personel["desig_id"]; exit;
	if($this->General_model->update_data('fts_personel_info',$data_personel,array('user_id'=>$this->session->userdata('user_id'))))

	{
		
		login_log(doctype_action('UPro'),'U',$this->session->userdata('user_id'));
	$this->session->set_flashdata('success_message', 'The User Profile is updated successfully.');
	}

	

	redirect('user/profile');
	}
	
	//setting
	function setting()
	{
		
        check_user_page_access();
		$data['data_value']=$this->User_model->setting();
		$str=$this->User_model->pass_check();
		$data_value=array(
		              
					  "password"=>md5($this->input->post('npwd', TRUE)),
					  
					  );
		
		if($this->input->post('opwd')!='')
		{
			
		if(md5($this->input->post('opwd'))==$str[0]['password'])
		{
			
		if($this->General_model->update_data('fts_user',$data_value,array('user_id'=>$this->session->userdata('user_id'))))
		{
			
			login_log(doctype_action('USett'),'U',$this->session->userdata('user_id'));
			$this->session->set_flashdata('error_message', '');
	$this->session->set_flashdata('success_message', 'New Password is updated successfully.');
	}
		}
		else
		{
			$this->session->set_flashdata('success_message', '');
	
			$this->session->set_flashdata('error_message', 'Old and New Password Mismatched');
		}
		}
		$content=$this->load->view('user/user_setting',$data,true);
		    render($content);
		
		
	}
	

	public function fetch_subsec()
    {
		check_user_page_access();
    	if(is_array($this->input->post('section',TRUE)))
    	{
    	$sec=implode(",",$this->input->post('section',TRUE));
        }
        else
        {
        	$sec=$this->input->post('section',TRUE);
        }
    	//print_r($sec);exit;
        
        $results="";

        if($this->input->post('section',TRUE) !=""){
        $sub_sec=$this->User_model->get_subsec($sec);
        //print_r($sub_sec);exit;
        
        if(is_array($sub_sec) && count($sub_sec)){
        	//echo("jata akdom");
        	

      				foreach($sub_sec as $value)
				      {
				           
				          echo '<option value="'.$value['sec_id'].'|'.$value['sec_code'].'">'.$value['sec_name'].'</option>';
				      }
      			
	    	}
	    

        }
    }		       
			          
	                

    //registration 
	 function signup()
    {
        
		check_user_page_access();
		$data['section_name']=$this->User_model->parent_sec();
	   // $data['sub_sec']=$this->User_model->sub_sec('fts_section');
		$data['designation']=$this->General_model->view_all_data('fts_designation');
		
		$this->load->library('form_validation');
			   
		$this->form_validation->set_rules('section[]', 'Section Name', 'required');
				$this->form_validation->set_rules('phone', 'Contact No', 'required');
				$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('designation[]', 'Desination', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[fts_user.email]');
			  $this->form_validation->set_rules('pwd', 'Password', 'required');
		$this->form_validation->set_rules('uname', 'User Name', 'is_unique[fts_user.user_name]');
		if ($this->form_validation->run() != FALSE)
		{
			$str_uname="";
			if($this->input->post('uname', TRUE)=="")
			{
			$str_uname=$this->input->post('email', TRUE);
			}
			else
			{
			  $str_uname=$this->input->post('uname', TRUE);
			}	

			  $data_value=array(
							   "gpf_id"=>$this->input->post('gpf', TRUE),
							   "name"=>strtoupper($this->input->post('name', TRUE)),
							   "user_name"=>$str_uname,
							   "email"=>$this->input->post('email', TRUE),
							   "gender"=>$this->input->post('gender',TRUE),
							   "phone"=>$this->input->post('phone', TRUE),
							   "password"=>md5($this->input->post('pwd', TRUE)),
							   "user_type"=>'normal_user',
							   "is_active"=>'N',
							   "reg_date"=>date('Y-m-d H:i:s')
							   );

			$desig_id='';
			if(implode("",$this->input->post('designation', TRUE))=="others")
			{
				
				$desig_add=array("desig_name"=>strtoupper($this->input->post('add_desig', TRUE)));
				$desig_id=$this->General_model->insert_data('fts_designation',$desig_add);	
			}
			else
			{
				$desig_id=implode(",",$this->input->post('designation', TRUE));
			}
			$section_id='';
			if(implode("",$this->input->post('section', TRUE))=="others")
			{
				$section_add=array("sec_name"=>strtoupper($this->input->post('add_sec', TRUE)));
				$section_id=$this->General_model->insert_data('fts_section',$section_add);	
			}
			else if($this->input->post('subsec_list', TRUE)!="")
			{
				$section_id=($this->input->post('subsec_list', TRUE));
			} else
			{
				$section_id=implode(",",$this->input->post('section', TRUE));
			}
				
			  //--------inserting data user table
			  $last_id=$this->User_model->General_model->insert_data('fts_user',$data_value);
			 if($last_id > 0)
			 {
				//--------inserting data personel table
				   $personel_info=array(
							   "user_id"=>$last_id,
							   "gpf_id"=>$this->input->post('gpf', TRUE),
							   "desig_id"=>$desig_id,
							   "sec_id"=>$section_id
							   );
				  $this->User_model->General_model->insert_data('fts_personel_info',$personel_info);
						$this->session->set_flashdata('success_message', 'You have registered successfully.<br> Please wait for verification by the Administrator.');
						
					redirect('user/login');	
						
						
			 }
		}
		$this->load->view('user/user_registration',$data);
	}
	
	public function gpf_validation($str)
        {
                if (!emp_validation($str))
                {
                        $this->form_validation->set_message('gpf_validation', 'Your GPF No. is wrong. Please check the number.');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
     public function user_list()
     {
        check_user_page_access();
		
		if(!$this->session->userdata('sessionUserDetails')) {
			$this->user_details=get_user_details();
		} else {
			$this->user_details=$this->session->userdata('sessionUserDetails');
		}
        
     	check_user_type($this->user_details['user_type'],array('admin','priv_user'));
     	$config = array();
        $config["base_url"] = base_url() . "user/user_list";
        $config["total_rows"] = $this->User_model->user_count($this->user_details['user_type']);
        $config["per_page"] = 7;
        $config["uri_segment"] = 3;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["results"] = $this->User_model->fetch_user_data($this->user_details['user_type'],$config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['designation']=$this->General_model->view_all_data('fts_designation');
        $data['active']='user_list_page';
		    $content=$this->load->view('user/user_list',$data,true);
		    render($content);


     }

     //forget password
	
	public function forget_password()
	{
		$this->load->view('user/forget_password');
	}
	  
	 //check mail_id for forget password
	
	public function ckh_mailid()
	{
		if($this->User_model->chk_mid($this->input->post('email')))
		{
			$password = (mt_rand(1000000,9999999));
			$this->User_model->new_pass(md5($password),$this->input->post('email'));
			
			$this->session->set_flashdata('success_message', 'Your password is updated check your email.');
			redirect('user/forget_password');
			
		}
		else
		{
			$this->session->set_flashdata('err_message', '<br>Your email id is incorrect.');
			redirect('user/forget_password');

		}
	}
	


	public function user_status()
     {
      $user_id=$this->input->post('id', TRUE);
      echo  $this->User_model->user_status_chang($user_id);
     }
	
    public function permit_usr()
     {
      $user_id=$this->input->post('id', TRUE);
      $permt_name=$this->input->post('permt_name', TRUE);
      $permt_val=$this->input->post('permt_val', TRUE);
      echo  $this->User_model->user_permit_chang($user_id,$permt_name,$permt_val);
     }

	public function user_type()
     {
      $user_id=substr($this->input->post('id', TRUE),1);
      $typevalue=$this->input->post('typevalue', TRUE);
      
     $this->User_model->user_type_chang($user_id,$typevalue);
      
     }
	
    public function active_inactive_user()
    {
		check_user_page_access();
		
        if(!$this->session->userdata('sessionUserDetails')) {
			$this->user_details=get_user_details();
		} else {
			$this->user_details=$this->session->userdata('sessionUserDetails');
		}
        check_user_type($this->user_details['user_type'],array('admin','priv_user'));
        $config = array();
        $config["base_url"] = base_url() . "user/user_list";
        $config["total_rows"] = $this->User_model->user_count($this->user_details['user_type']);
        $config["per_page"] = 7;
        $config["uri_segment"] = 3;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["results"] = $this->User_model->fetch_user_data($this->user_details['user_type'],$config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['designation']=$this->General_model->view_all_data('fts_designation');
        $data['active']='user_list_page';
            $content=$this->load->view('user/user_status',$data,true);
            render($content);


        //$this->session->set_flashdata('error_message', '');
        //$this->load->view('user/user_status');
    //redirect('user/profile');

    }

}
