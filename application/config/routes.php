<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 			= 'home';
$route['404_override'] 					= '';
$route['translate_uri_dashes'] 			= FALSE;

$route['contactus'] 					= 'home/contactus';
$route['hospitals'] 					= 'home/hospitals';
$route['hospitallist'] 					= 'home/hospitallist';
$route['doctors'] 						= 'home/doctors';
$route['doctor/(:num)'] 				= 'home/doctor/$1';
$route['hospital/(:num)'] 				= 'home/hospital/$1';
$route['pathlab-login'] 				= 'pathlabpanel/login';
$route['pathlab-signup'] 				= 'pathlabpanel/signup';
$route['pathlab-verifymobile'] 			= 'pathlabpanel/verifymobile';
$route['pathlab-forgotpassword'] 		= 'pathlabpanel/forgotpassword';
$route['pathlab-verifymobileforgot'] 	= 'pathlabpanel/verifymobileforgot';
$route['pathlab-dashboard'] 			= 'pathlabpanel/dashboard';



$route['pathdoctor-login'] 				= 'pathdoctorpanel/login';
$route['pathdoctor-signup'] 			= 'pathdoctorpanel/signup';
$route['pathdoctor-verifymobile'] 		= 'pathdoctorpanel/verifymobile';
$route['pathdoctor-forgotpassword'] 	= 'pathdoctorpanel/forgotpassword';
$route['pathdoctor-verifymobileforgot'] = 'pathdoctorpanel/verifymobileforgot';
$route['pathdoctor-dashboard'] 			= 'pathdoctorpanel/dashboard';


$route['profile_step11'] 				= 'pathdoctorpanel/profile_step11';
$route['profile_step12'] 				= 'pathdoctorpanel/profile_step12';
$route['profile_step13'] 				= 'pathdoctorpanel/profile_step13';
$route['profile_about1'] 				= 'pathdoctorpanel/profile_about1';
$route['profile_drpic1'] 				= 'pathdoctorpanel/profile_drpic1';
$route['profile_idproof1'] 				= 'pathdoctorpanel/profile_idproof1';
$route['mci_proof1'] 					= 'pathdoctorpanel/mci_proof1';
$route['profile_regproof1'] 			= 'pathdoctorpanel/profile_regproof1';


$route['managepractice1'] 				= 'pathdoctorpanel/managepractice1';

$route['hospital-aindex'] 				= 'hospitalpanel/aindex';
$route['hospital-login'] 				= 'hospitalpanel/login';
$route['hospital-signup'] 				= 'hospitalpanel/signup';
$route['hospital-verifymobile'] 		= 'hospitalpanel/verifymobile';
$route['hospital-forgotpassword'] 		= 'hospitalpanel/forgotpassword';
$route['hospital-dashboard'] 			= 'hospitalpanel/dashboard';
$route['hospitalpanel'] 				= 'hospitalpanel/dashboard';
$route['hospitalpanel/dashboard'] 		= 'hospitalpanel/dashboard';
$route['hospitalpanel/earnings'] 		= 'hospitalpanel/earnings';
$route['hospitalpanel/export_earnings'] = 'hospitalpanel/export_earnings';
$route['hospitalpanel/invoice_view/(:any)'] = 'hospitalpanel/invoice_view/$1';
$route['hospitalpanel/generate_monthly_invoice'] = 'hospitalpanel/generate_monthly_invoice';
$route['hospitalpanel/(:any)'] 			= 'hospitalpanel/$1';
$route['hospitalpanel/(:any)/(:any)'] 	= 'hospitalpanel/$1/$2';
$route['patient/:any']					= 'hospitalpanel/patient/$1';



$route['doctor-aindex'] 				= 'doctorpanel/aindex';
$route['doctor-login'] 					= 'doctorpanel/login';
$route['doctor-signup'] 				= 'doctorpanel/signup';
$route['doctor-verifymobile'] 			= 'doctorpanel/verifymobile';
$route['doctor-forgotpassword']			= 'doctorpanel/forgotpassword';
$route['doctor-verifymobileforgot'] 	= 'doctorpanel/verifymobileforgot';
$route['doctor-dashboard'] 				= 'doctorpanel/dashboard';




$route['addclinic'] 					= 'doctorpanel/addclinic';
$route['addpractice'] 					= 'doctorpanel/addpractice';
$route['linkpractice'] 					= 'doctorpanel/linkpractice';
$route['profile_consultant_fee/:any'] 	= 'doctorpanel/profile_consultant_fee/$1';

$route['managepractice'] 				= 'doctorpanel/managepractice';
$route['manageownclinic'] 				= 'doctorpanel/manageownclinic';
$route['manageappointment'] 			= 'doctorpanel/manageappointment';

$route['progress_profile'] 				= 'doctorpanel/progress_profile';
$route['progress_profile2'] 			= 'doctorpanel/progress_profile2';
$route['progress_profile3'] 			= 'doctorpanel/progress_profile3';
$route['progress_profile4'] 			= 'doctorpanel/progress_profile4';

$route['profile_step1'] 				= 'doctorpanel/profile_step1';
$route['profile_step2'] 				= 'doctorpanel/profile_step2';
$route['profile_step3'] 				= 'doctorpanel/profile_step3';
$route['profile_step4'] 				= 'doctorpanel/profile_step4';
$route['profile_step5'] 				= 'doctorpanel/profile_step5';
$route['profile_step6'] 				= 'doctorpanel/profile_step6';

$route['profile_about'] 				= 'doctorpanel/profile_about';
$route['profile_drpic'] 				= 'doctorpanel/profile_drpic';
$route['profile_idproof'] 				= 'doctorpanel/profile_idproof';
$route['mci_proof'] 					= 'doctorpanel/mci_proof';
$route['profile_regproof'] 				= 'doctorpanel/profile_regproof';


$route['updateclinic/:any'] 			= 'doctorpanel/updateclinic/$1';
$route['profile_clinicproof/:any'] 		= 'doctorpanel/profile_clinicproof/$1';
$route['profile_maplocation/:any'] 		= 'doctorpanel/profile_maplocation/$1';
$route['profile_clinic_timing/:any'] 	= 'doctorpanel/profile_clinic_timing/$1';



$route['medical-login'] 				= 'medicalpanel/login';
$route['medical-signup'] 				= 'medicalpanel/signup';
$route['medical-verifymobile'] 			= 'medicalpanel/verifymobile';
$route['medical-forgotpassword'] 		= 'medicalpanel/forgotpassword';
$route['medical-verifymobileforgot'] 	= 'medicalpanel/verifymobileforgot';
$route['medical-dashboard'] 			= 'medicalpanel/dashboard';

$route['profile_step21'] 				= 'medicalpanel/profile_step21';
$route['profile_step22'] 				= 'medicalpanel/profile_step22';
$route['profile_step23'] 				= 'medicalpanel/profile_step23';
$route['profile_step24'] 				= 'medicalpanel/profile_step24';
$route['profile_about2'] 				= 'medicalpanel/profile_about2';

$route['profile_drpic2'] 				= 'medicalpanel/profile_drpic2';
$route['profile_idproof2'] 				= 'medicalpanel/profile_idproof2';

$route['profile_regproof2'] 			= 'medicalpanel/profile_regproof2';
$route['managepractice2'] 				= 'medicalpanel/managepractice2';

$route['login'] 	     				= 'home/login';
$route['signup'] 		 				= 'home/signup';
$route['forgotpassword'] 				= 'home/forgotpassword';
$route['verifymobile'] 					= 'home/verifymobile';
$route['verifymobileforgot'] 			= 'home/verifymobileforgot';
$route['hospitallist'] 					= 'home/hospitallist';
$route['hospitals'] 					= 'home/hospitals';
$route['doctors'] 						= 'home/doctors';
$route['doctor/:any'] 					= 'home/doctor/$1';
//$route['patient/:any']				= 'home/patient/$1';
$route['hospital/:any'] 				= 'home/hospital/$1';
$route['newfiles/mystatic/:any'] 		= 'dummy/mystatic/$1';
$route['search'] 						= 'home/search';
$route['gethint'] 						= 'home/gethint';
$route['gethintcity'] 					= 'home/gethintcity';
$route['aboutus'] 						= 'home/aboutus';
$route['news'] 							= 'home/news';
$route['news/:any'] 					= 'home/news_details/$1';
$route['tnc'] 							= 'home/tnc';
$route['profile']						= 'home/profile';
$route['updateprofile']					= 'home/updateprofile';
$route['mytest'] 						= 'mytest/index';
$route['mytest/add_to_cart'] 			= 'mytest/add_to_cart';
$route['mytest/remove_from_cart'] 		= 'mytest/remove_from_cart';
$route['mytest/clear_cart'] 			= 'mytest/clear_cart';
$route['mytest/get_cart'] 				= 'mytest/get_cart';
$route['mytest/checkout'] 				= 'mytest/checkout';
$route['mytest/process_payment'] 		= 'mytest/process_payment';
$route['mytest/order_success/(:num)'] 	= 'mytest/order_success/$1';
$route['mytest/(:any)'] 				= 'mytest/$1';
$route['diagnostic'] 					= 'mytest/index';
$route['pathlabview'] 					= 'pathology/index';
$route['pathlabview/(:any)'] 			= 'pathology/$1';
$route['pathology'] 					= 'pathology/index';
$route['pathology/(:any)'] 				= 'pathology/$1';
$route['bed-availability'] 				= 'home/bed_availability';

$route['privacy'] 						= 'home/privacy';
$route['refund_cancellation'] 			= 'home/refund_cancellation';
$route['myappointents'] 				= 'home/manageappointment';
$route['myappointments'] 				= 'home/manageappointment';
$route['change_password'] 				= 'home/change_password';
$route['logout'] 						= 'home/logout';
$route['processorder'] 					= 'paysecure/processorder';
$route['processordercod'] 				= 'paysecure/processordercod';
$route['videocall/(:any)'] 				= 'home/videocall/$1';
$route['video-consultation/(:any)'] 	= 'home/videocall/$1';
$route['doctorpanel/videocall/(:any)'] 	= 'doctorpanel/videocall/$1';

/*
|--------------------------------------------------------------------------
| UPCHAR UNIFIED PAYMENT & WALLET SYSTEM ROUTES (NON-DISRUPTIVE)
|--------------------------------------------------------------------------
*/
$route['payment/checkout']                  = 'payment/checkout';
$route['payment/create_order']              = 'payment/create_order';
$route['payment/verify']                    = 'payment/verify';
$route['payment/process_points_only/(:any)']= 'payment/process_points_only/$1';
$route['payment/webhook']                   = 'payment/webhook';
$route['payment/success/(:any)']            = 'payment/success/$1';
$route['payment/failed/(:any)']             = 'payment/failed/$1';
$route['payment/history']                   = 'payment/history';
$route['payment/orders']                    = 'payment/history';
$route['payment/dashboard']                 = 'payment/history';

$route['wallet']                            = 'wallet/index';
$route['wallet/recharge']                   = 'wallet/recharge';
$route['wallet/get_balance_ajax']           = 'wallet/get_balance_ajax';
$route['wallet_v2']                         = 'wallet/index';
$route['wallet/(:any)']                     = 'wallet/$1';

$route['refund/initiate']                   = 'refund/initiate';
$route['refund/status/(:any)']              = 'refund/status/$1';

$route['payout/dashboard']                  = 'payout/dashboard';
$route['payout/trigger_batch']              = 'payout/trigger_batch';
$route['payout/add_account']                = 'payout/add_account';
$route['payout/verify_account']             = 'payout/verify_account';

$route['admin_payment']                     = 'admin_payment/index';
$route['admin_payment/save_wallet_settings']= 'admin_payment/save_wallet_settings';
$route['admin_payment/export_orders']       = 'admin_payment/export_orders';

/*
|--------------------------------------------------------------------------
| UPCHAR ENTERPRISE MULTI-ROLE & LOGISTICS SUITE ROUTES
|--------------------------------------------------------------------------
*/
$route['staff']                             = 'staff/login';
$route['staff/login']                       = 'staff/login';
$route['staff/authenticate']                = 'staff/authenticate';
$route['staff/demo_login/(:any)']           = 'staff/demo_login/$1';
$route['staff/logout']                      = 'staff/logout';

// Sample Collector (Phlebotomist) Mobile Field PWA
$route['collector']                         = 'collector/dashboard';
$route['collector/dashboard']               = 'collector/dashboard';
$route['collector/pickup/(:num)']           = 'collector/pickup/$1';
$route['collector/update_status']           = 'collector/update_status';
$route['collector/scan_barcode']            = 'collector/scan_barcode';
$route['collector/complete_payment']        = 'collector/complete_payment';

// Geofenced Attendance Engine
$route['attendance']                        = 'attendance/punch';
$route['attendance/punch']                  = 'attendance/punch';
$route['attendance/record_punch_in']        = 'attendance/record_punch_in';
$route['attendance/record_punch_out']       = 'attendance/record_punch_out';
$route['attendance/history']                = 'attendance/history';

// HR & Staff Portal
$route['hr']                                = 'hr/dashboard';
$route['hr/dashboard']                      = 'hr/dashboard';
$route['hr/employees']                      = 'hr/employees';
$route['hr/save_employee']                  = 'hr/save_employee';
$route['hr/leaves']                         = 'hr/leaves';
$route['hr/update_leave']                   = 'hr/update_leave';
$route['hr/payroll']                        = 'hr/payroll';

// BDE CRM Suite
$route['crm']                               = 'crm/dashboard';
$route['crm/dashboard']                     = 'crm/dashboard';
$route['crm/leads']                         = 'crm/leads';
$route['crm/save_lead']                     = 'crm/save_lead';
$route['crm/update_stage']                  = 'crm/update_stage';
$route['crm/onboard_partner/(:num)']        = 'crm/onboard_partner/$1';

// Central Operations & Expense Desk
$route['operations']                        = 'operations/dashboard';
$route['operations/dashboard']              = 'operations/dashboard';
$route['operations/handoffs']               = 'operations/handoffs';
$route['operations/verify_handoff']         = 'operations/verify_handoff';
$route['operations/expenses']               = 'operations/expenses';
$route['operations/save_expense']           = 'operations/save_expense';
$route['operations/update_expense']         = 'operations/update_expense';
