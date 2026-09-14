<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicalpanel extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $this->load->model('Medical_Model');
		 if(!$this->session->userdata('medicaluserid')){
			 $page=$this->uri->segment('1');
			 $excep_array=array('medical-login','medical-signup','medical-verifymobile','medical-forgotpassword','medical-verifymobileforgot');
			 if (!in_array($page, $excep_array))
				redirect('medical-login');
		 }else{
			 $chemRow = $this->db->where('user_id',$this->session->userdata('medicaluserid'))->or_where('id', $this->session->userdata('medicaluserid'))->get('profile_chem')->row();
			 $this->did = ($chemRow && isset($chemRow->id)) ? $chemRow->id : $this->session->userdata('medicaluserid');
		 }
		 
	}
	
	public function index()
	{
		$data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$this->load->view('home',$data);
	}
	/*
	public function dashboard()
	
	
	
	{
		$userid =$this->did;
		
		
         $this -> db -> where('doctor_id', $userid);   
        $this -> db -> where('status', '1');   
		 $this -> db -> where('appointment_date', date('Y-m-d'));   
        $query = $this -> db -> get('appointment');
		$data['todayappointment']=$query -> num_rows();
         
        $this -> db -> where('doctor_id', $userid);   
        $this -> db -> where('status', '1');    
        $query = $this -> db -> get('appointment');
		$data['totalappointment']=$query -> num_rows();
		
		
	//	$query =$this->db->select('profile_chem.*,dr_practice.status as p_status')->join('profile_chem','profile_chem.id=dr_practice.user_id')->get_where('dr_practice',array('institution_id'=>$this->did,'type'=>'H'));	
	//	$data['totaldoctor']=$query -> num_rows();
		$this->load->view('medicalpanel/dashboard',$data);
		
	}
	*/
	public function updateprofile()
	{
	
	$this->load->view('medicalpanel/milestone');    
	}
	
	public function managedoctor()
	{
		
		$data['clinic']=$this->db->select('profile_chem.*,dr_practice.status as p_status')->join('profile_chem','profile_chem.id=dr_practice.user_id')->get_where('dr_practice',array('institution_id'=>$this->did,'type'=>'H'))->result();	
			
		$this->load->view('medicalpanel/managedoctor',$data);
	}
	
	
	public function login()
	{
		if ($this->session->userdata('userid')) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-info'>You are logged in as a Patient. Please logout to access Medical Partner Login.</div>");
			redirect('myappointments');
			return;
		}
		if ($this->session->userdata('meduserid')) {
			redirect('medicalpanel/milestone');
			return;
		}
		$this->load->view('medicalpanel/login');
	}
	
	public function signup()
	{
		$this->load->view('medicalpanel/sign_up');
	}
	
	public function forgotpassword()
	{
		$this->load->view('medicalpanel/forgot_password');
	}
	
	public function verifymobile()
	{
		$this->load->view('medicalpanel/otp_send_pass');
	}
	
	/* public function verifymobileforgot()
	{
		$this->load->view('otp_send_pass_forgot');
	} */
	
	
	public function dashboard()
	{
		$userId = $this->session->userdata('medicaluserid');
		
		// 1. Resolve Chemist Profile
		$chemProfile = $this->db->where('user_id', $userId)
			->or_where('id', $userId)
			->get('profile_chem')->row();
		
		// 2. Resolve Associated Pharmacy Store
		$store = null;
		if ($chemProfile) {
			$store = $this->db->where('hospital_id', $chemProfile->id)
				->or_where('phone', $chemProfile->mobile ?? '')
				->get('pharmacy_stores')->row();
		}
		if (!$store) {
			$store = $this->db->where('is_active', 1)->get('pharmacy_stores')->row();
		}
		$storeId = $store ? (int)$store->id : 1;
		
		// 3. Order Telemetry
		$this->db->reset_query();
		$totalOrders = $this->db->count_all_results('medicine_orders');
		
		$pendingOrders = $this->db->where_in('order_status', ['PLACED', 'PENDING_RX'])->count_all_results('medicine_orders');
		$inTransitOrders = $this->db->where_in('order_status', ['PACKED', 'ASSIGNED', 'IN_TRANSIT'])->count_all_results('medicine_orders');
		$deliveredOrders = $this->db->where('order_status', 'DELIVERED')->count_all_results('medicine_orders');
		$todayOrders = $this->db->where('DATE(created_at)', date('Y-m-d'))->count_all_results('medicine_orders');
		
		$revRow = $this->db->select('COALESCE(SUM(total_amount), 0) as total_rev')
			->group_start()
				->where_in('order_status', ['DELIVERED', 'IN_TRANSIT', 'PACKED'])
				->or_where('payment_status', 'PAID')
			->group_end()
			->get('medicine_orders')->row();
		$totalRevenue = $revRow ? (float)$revRow->total_rev : 0.00;
		
		// 4. Inventory Telemetry
		$totalSkus = $this->db->where('pharmacy_id', $storeId)->count_all_results('pharmacy_inventory');
		if ($totalSkus == 0) {
			$totalSkus = $this->db->count_all_results('pharmacy_inventory');
		}
		
		$lowStockCount = $this->db->group_start()
			->where('stock_quantity <=', 15)
			->or_where('is_available', 0)
			->group_end()
			->count_all_results('pharmacy_inventory');
			
		$inStockCount = max(0, $totalSkus - $lowStockCount);
		
		// 5. Recent Live Orders
		$recentOrders = $this->db->select('id, order_code, customer_name, customer_phone, delivery_address, total_amount, payment_mode, payment_status, order_status, created_at')
			->order_by('id', 'DESC')
			->limit(8)
			->get('medicine_orders')->result();
			
		// 6. Fast-moving & Low stock watchlist medicines
		$lowStockItems = $this->db->select('pi.*, mm.brand_name, mm.generic_composition, mm.manufacturer, mm.dosage_form')
			->from('pharmacy_inventory pi')
			->join('medicines_master mm', 'mm.id = pi.medicine_id')
			->order_by('pi.stock_quantity', 'ASC')
			->limit(6)
			->get()->result();
			
		// 7. Weekly Trend Data (Last 7 Days) for Chart.js
		$chartDays = [];
		$chartOrderCounts = [];
		$chartRevenue = [];
		for ($i = 6; $i >= 0; $i--) {
			$d = date('Y-m-d', strtotime("-$i days"));
			$chartDays[] = date('D (M j)', strtotime($d));
			
			$dayOrderCount = $this->db->where('DATE(created_at)', $d)->count_all_results('medicine_orders');
			$dayRevRow = $this->db->select('COALESCE(SUM(total_amount), 0) as day_rev')
				->where('DATE(created_at)', $d)
				->get('medicine_orders')->row();
			$chartOrderCounts[] = (int)$dayOrderCount;
			$chartRevenue[] = (float)($dayRevRow ? $dayRevRow->day_rev : 0);
		}
		
		// 8. Profile Completeness Score
		$profileScore = 20;
		if ($chemProfile) {
			if (!empty($chemProfile->fname)) $profileScore += 15;
			if (!empty($chemProfile->mobile)) $profileScore += 15;
			if (!empty($chemProfile->regd_no)) $profileScore += 20;
			if (!empty($chemProfile->id_proof)) $profileScore += 15;
			if (!empty($chemProfile->med_reg_proof)) $profileScore += 15;
		}
		$profileScore = min(100, $profileScore);

		$data = [
			'profile' => $chemProfile,
			'store' => $store,
			'store_id' => $storeId,
			'total_orders' => $totalOrders,
			'pending_orders' => $pendingOrders,
			'in_transit_orders' => $inTransitOrders,
			'delivered_orders' => $deliveredOrders,
			'today_orders' => $todayOrders,
			'total_revenue' => $totalRevenue,
			'total_skus' => $totalSkus,
			'low_stock_count' => $lowStockCount,
			'in_stock_count' => $inStockCount,
			'recent_orders' => $recentOrders,
			'low_stock_items' => $lowStockItems,
			'chart_days' => $chartDays,
			'chart_order_counts' => $chartOrderCounts,
			'chart_revenue' => $chartRevenue,
			'profile_score' => $profileScore
		];
	    
	    $this->load->view('medicalpanel/mainpage', $data);
	}


    public function addandimport()
    {
        $this->load->view('medicalpanel/addandimport');
        
    }
     public function pendingorder()
     {
         
         $this->load->view('medicalpanel/penddingorder');
     }
         public function import()
        {
        $this->load->view('medicalpanel/addmadicine');
    
        }
      public function exportsheet()
     {
       $this->load->view('medicalpanel/importsheet');
    
     }



      public function profile_step21()
	{
		if(isset($_POST['submit']))
			$this->Medical_Model->profile_step21();
		
		$data['data']=$this->db->get_where('profile_chem',array('id'=>$this->did))->row();			
		$data_spl=$this->db->select('specialization_id')->get_where('dr_specialization',array('user_id'=>$this->did))->result_array();
		$data['data_spl']= array_map (function($value){
					return $value['specialization_id'];
				} , $data_spl);		
		$this->load->view('medicalpanel/profile_step1',$data);
	}
       
       public function profile_step22()
	{
		if(isset($_POST['submit']))
			$this->Medical_Model->profile_step22();
		$data['data']=$this->db->get_where('profile_chem',array('id'=>$this->did))->row();	
		$this->load->view('medicalpanel/profile_step2',$data);
	}



   public function profile_step23()
	{
		if(isset($_POST['submit']))
			$this->Medical_Model->profile_step23();
		$data['data']=$this->db->get_where('profile_chem',array('id'=>$this->did))->row();	
		$data_qua=$this->db->select('qualification_id')->get_where('dr_qualifications',array('user_id'=>$this->did))->result_array();
		$data['data_qua']= array_map (function($value){
					return $value['qualification_id'];
				} , $data_qua);	
		$this->load->view('medicalpanel/profile_step3',$data);
	}

       public function profile_about2()
	{
		if(isset($_POST['submit']))
			$this->Medical_Model->about2();
		$data['data']=$this->db->select('about,short_about')->get_where('profile_chem',array('id'=>$this->did))->row();
		$this->load->view('medicalpanel/about',$data);
	}
    
    
    
        public function profile_drpic2()
	{
		if(isset($_POST['submit']))
			$this->Medical_Model->profile_drpic2();
		$data['src']=$this->db->select('drimage')->get_where('profile_chem',array('id'=>$this->did))->row('drimage');	
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('medicalpanel/profile_drpic',$data);
	}

           public function profile_idproof2()
	{
		if(isset($_POST['submit']))
			$this->Medical_Model->profile_idproof2();
		
		$data['src']=$this->db->select('id_proof')->get_where('profile_chem',array('id'=>$this->did))->row('id_proof');
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('medicalpanel/profile_idproof',$data);
	}
    
    
    
     
      
	
	public function profile_regproof2()
	{
		if(isset($_POST['submit']))
			$this->Medical_Model->profile_regproof2();
		
		$data['src']=$this->db->select('med_reg_proof')->get_where('profile_chem',array('id'=>$this->did))->row('med_reg_proof');
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('medicalpanel/profile_regproof',$data);
	}
     
     	public function managepractice2()
	{
		if(isset($_POST['submit']))
			$this->Medical_Model->profile_step22();
		$data['clinic']=$this->db->select('clinic.*,dr_practice.id as practice_id,fee as practicefee')->join('clinic','clinic.id=dr_practice.institution_id')->get_where('dr_practice',array('user_id'=>$this->did,'type'=>'C'))->result();	
		$data['hospital']=$this->db->select('hospital.*,dr_practice.id as practice_id,fee as practicefee')->join('hospital','hospital.id=dr_practice.institution_id')->get_where('dr_practice',array('user_id'=>$this->did,'type'=>'H'))->result();	
		$this->load->view('medicalpanel/managepractice',$data);
	}
	
     
     
     

         public function change_password()
          {
              
              
        if($this->input->post('change_pass'))
		{
		$cur_password = md5($this->input->post('password'));
        $new_password = md5($this->input->post('newpass'));
        $conf_password = md5($this->input->post('confpassword'));
        $id=$this->session->userdata('medicaluserid');

        $passwd = $this->Medical_Model->change_password($id);
        if($passwd->PASSWORD == $cur_password)
        {
            if($new_password == $conf_password)
            {
                if($this->Medical_Model->updatePassword($new_password, $id))
                {
                    echo 'Password updated successfully';
                }
                else{
                    echo 'Failed to update password';
                }
            }
            else{
                echo 'New password & Confirm password is not matching';
            }
        }
        else{
            echo'Sorry! Current password is not matching';

       }
     
		} 
           $this->load->view('medicalpanel/change_password');
           
       }


public function gallery()
{

    if(isset($_POST['submit']))
			$uploadimage='';
		//	$id=base64_decode($this->input->post('id'));
        $uploadimage=$_FILES['uploadimage']['name'];
		$extsign = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);
       

					if($uploadimage != '') 
				{	
					$rname=rand(1111111,999999999);
					$date=date('Y-m-d');
					$uploadimage=$typename.'_profile_pic_'.$rname.$date.'.'.$extsign;
					
					$config['upload_path']          = './admin1947/public/assets/upload/';
					$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
					$config['max_size']             = 2048;
					$config['quality'] = '60%';
					$config['file_name']  = $uploadimage;
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('uploadimage'))
					{
						$error = $this->upload->display_errors();
						$flashmsg='<div class="alert alert-danger">
						  <strong>Failed!</strong>'.$error.'
						</div>';
						$this->session->set_flashdata('flashmsg',$flashmsg);
						redirect(base_url().'medicalpanel/gallery');
						exit();
					}


					if($this->Medical_Model->gallery($uploadimage)) 
						{
							//$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
							//$this->session->set_flashdata('flashmsg',$msg);
							
						
						}
						else{
							$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
							$this->session->set_flashdata('flashmsg',$msg);
						}
						
						}
					
	       $data['content_view'] = 'medicalpanel/gallery';
	       $this->load->view('layouts/chemist_layout', $data);
            }
	   
	 }
