	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

		class Employee extends CI_Controller {
	    
			 public function __construct() {
		        parent::__construct();
		        $this->load->library('csvimport');
		         $this->load->model('model_users');
		    }
	
		    public function index() {
		          
		        $this->load->view('employee');
		    }
			public function fetch_employeeData(){
				 $result = array('data' => array());
				 $data=$this->model_users->getEmployeeData();
				 foreach ($data as $key => $value) {
						$age=date('Y') - date('Y',strtotime($value['date_of_birth']));
						$datetime1 = new DateTime($value['joining_date']);
						$datetime2 = new DateTime(date('Y-m-d'));
						$interval = $datetime1->diff($datetime2);
						 $joining = $interval->format('%y Year %m Month');
						$result['data'][$key] = array(
						$value['emp_code'],
						$value['emp_name'],
						 $value['department'],
						$age,
						$joining
					   
					);
				} 
				echo json_encode($result);
			}

		   
			public function import()
			{
				
				$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"],[0,1,2,3,4]);
			
				$select_data=$this->input->post('select_data');
				$insert=0;
				  for($k=0;$k<count($file_data);$k++)
				  {
					
					if(count($select_data)!=count(array_filter($file_data[$k]))){
						$response = 'Fields Are Missing in Row '.$k;
					}else if($k>19){
						$response = 'Limit Exceeded';
					}
					else if(count($select_data)>count(array_unique($select_data))){
						$response = 'Please Select Unique Values';
					}else{
						$j_key=array_search('joining_date',$select_data);
						$d_key=array_search('date_of_birth',$select_data);
						if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$file_data[$k][$j_key])){
							$response = 'Incorrect Joining Date Format in Row '.$k;
						}else if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$file_data[$k][$d_key])){
							$response = 'Incorrect Date of Birth Format in Row '.$k;
						}else{
							$data=array();
							$select_keys=array_values($select_data);	
							$file_values=array_values($file_data[$k]);
							$data=array_combine($select_keys,$file_values);
							$insert = $this->model_users->createUsers($data);
						}
						
						
					}
				}
				if($insert==1){
						
					$response = 'Data Imported Successfully';
				}
				echo $response;
			}
	}
	
