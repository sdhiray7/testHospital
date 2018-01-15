<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * 	@author : Joyonto Roy
 * 	date	: 1 August, 2014
 * 	http://codecanyon.net/user/Creativeitem
 * 	http://creativeitem.com
 */

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
		$this->load->model('crud_model');
        $this->load->model('email_model');
        $this->load->model('sms_model');
        $this->load->model('frontend_model');

        /* cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    /*     * *default function, redirects to login page if no admin logged in yet** */

    public function index() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }

    /*     * *ADMIN DASHBOARD** */

    function dashboard() {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ***LANGUAGE SETTINGS******** */

    function manage_language($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile'] = $param2;
        }
        if ($param1 == 'update_phrase') {
            $language = $param2;
            $total_phrase = $this->input->post('total_phrase');
            for ($i = 1; $i < $total_phrase; $i++) {
                //$data[$language]	=	$this->input->post('phrase').$i;
                $this->db->where('phrase_id', $i);
                $this->db->update('language', array($language => $this->input->post('phrase' . $i)));
            }
            redirect(base_url() . 'index.php?admin/manage_language/edit_phrase/' . $language, 'refresh');
        }
        if ($param1 == 'do_update') {
            $language = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = $this->input->post('phrase');
            $this->db->insert('language', $data);
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);

            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('message', get_phrase('settings_updated'));

            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        $page_data['page_name'] = 'manage_language';
        $page_data['page_title'] = get_phrase('manage_language');
        //$page_data['language_phrases'] = $this->db->get('language')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*     * ***SITE/SYSTEM SETTINGS******** */

    function system_settings($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'do_update') {
            $this->crud_model->update_system_settings();
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }

        $page_data['page_name'] = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings'] = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    // SMS settings.
    function sms_settings($param1 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'do_update') {
            $this->crud_model->update_sms_settings();
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        $page_data['page_name'] = 'sms_settings';
        $page_data['page_title'] = get_phrase('sms_settings');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'update_profile_info') {
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $validation = email_validation_on_edit($data['email'], $this->session->userdata('login_user_id'), 'admin');
            if ($validation == 1) {
              $returned_array = null_checking($data);
              $this->db->where('admin_id', $this->session->userdata('login_user_id'));
              $this->db->update('admin', $returned_array);
              $this->session->set_flashdata('message', get_phrase('profile_info_updated_successfuly'));
              redirect(base_url() . 'index.php?admin/manage_profile');
            }
            else{
              $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
              redirect(base_url() . 'index.php?admin/manage_profile');
            }

        }
        if ($param1 == 'change_password') {
            $current_password_input = sha1($this->input->post('password'));
            $new_password = sha1($this->input->post('new_password'));
            $confirm_new_password = sha1($this->input->post('confirm_new_password'));

            $current_password_db = $this->db->get_where('admin', array('admin_id' =>
                        $this->session->userdata('login_user_id')))->row()->password;

            if ($current_password_db == $current_password_input && $new_password == $confirm_new_password) {
                $this->db->where('admin_id', $this->session->userdata('login_user_id'));
                $this->db->update('admin', array('password' => $new_password));

                $this->session->set_flashdata('message', get_phrase('password_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/manage_profile');
            } else {
                $this->session->set_flashdata('message', get_phrase('password_update_failed'));
                redirect(base_url() . 'index.php?admin/manage_profile');
            }
        }
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data'] = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    function department($task = "", $department_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_department_info();
            $this->session->set_flashdata('message', get_phrase('department_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/department');
        }

        if ($task == "update") {
            $this->crud_model->update_department_info($department_id);
            $this->session->set_flashdata('message', get_phrase('department_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/department');
        }

        if ($task == "delete") {
            $this->crud_model->delete_department_info($department_id);
            redirect(base_url() . 'index.php?admin/department');
        }

        $data['department_info'] = $this->crud_model->select_department_info();
        $data['page_name'] = 'manage_department';
        $data['page_title'] = get_phrase('department');
        $this->load->view('backend/index', $data);
    }

    function department_facilities($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'add') {
            $this->frontend_model->add_department_facility($param2);
            $this->session->set_flashdata('message', get_phrase('facility_saved_successfully'));
            redirect(base_url() . 'index.php?admin/department_facilities/'.$param2, 'refresh');
        }

        if ($param1 == 'edit') {
            $this->frontend_model->edit_department_facility($param2);
            $this->session->set_flashdata('message', get_phrase('facility_updated_successfully'));
            redirect(base_url() . 'index.php?admin/department_facilities/'.$param3, 'refresh');
        }

        if ($param1 == 'delete') {
            $this->frontend_model->delete_department_facility($param2);
            $this->session->set_flashdata('message', get_phrase('facility_deleted_successfully'));
            redirect(base_url() . 'index.php?admin/department_facilities/'.$param3, 'refresh');
        }

        $data['department_info'] = $this->frontend_model->get_department_info($param1);
        $data['facilities']      = $this->frontend_model->get_department_facilities($param1);
        $data['page_name']       = 'department_facilities';
        $data['page_title']      = get_phrase('department_facilities').' | '.$data['department_info']->name.' '.get_phrase('department');
        $this->load->view('backend/index', $data);
    }

    function doctor($task = "", $doctor_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "create") {
            $email = $_POST['email'];
            $validation = email_validation_on_create($email);

            if ($validation == 1) {
                $this->crud_model->save_doctor_info();
                $this->session->set_flashdata('message', get_phrase('doctor_info_saved_successfuly'));
            }
            else {
                $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?admin/doctor');
        }
        if ($task == "update") {
          $this->crud_model->update_doctor_info($doctor_id);
          redirect(base_url() . 'index.php?admin/doctor');
        }

        if ($task == "delete") {
          $this->crud_model->delete_doctor_info($doctor_id);
          redirect(base_url() . 'index.php?admin/doctor');
        }
        $data['doctor_info'] = $this->crud_model->select_doctor_info();
        $data['page_name'] = 'manage_doctor';
        $data['page_title'] = get_phrase('doctor');
        $this->load->view('backend/index', $data);
    }

    function patient($task = "", $patient_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_patient_info();
            $this->session->set_flashdata('message', get_phrase('patient_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/patient');
        }

        if ($task == "update") {
            $this->crud_model->update_patient_info($patient_id);
            redirect(base_url() . 'index.php?admin/patient');
        }

        if ($task == "delete") {
            $this->crud_model->delete_patient_info($patient_id);
            redirect(base_url() . 'index.php?admin/patient');
        }

        $data['patient_info'] = $this->crud_model->select_patient_info();
        $data['page_name'] = 'manage_patient';
        $data['page_title'] = get_phrase('patient');
        $this->load->view('backend/index', $data);
    }

    function nurse($task = "", $nurse_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_nurse_info();
            $this->session->set_flashdata('message', get_phrase('nurse_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/nurse');
        }

        if ($task == "update") {
            $this->crud_model->update_nurse_info($nurse_id);
            redirect(base_url() . 'index.php?admin/nurse');
        }

        if ($task == "delete") {
            $this->crud_model->delete_nurse_info($nurse_id);
            redirect(base_url() . 'index.php?admin/nurse');
        }

        $data['nurse_info'] = $this->crud_model->select_nurse_info();
        $data['page_name'] = 'manage_nurse';
        $data['page_title'] = get_phrase('nurse');
        $this->load->view('backend/index', $data);
    }

    function pharmacist($task = "", $pharmacist_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_pharmacist_info();
            $this->session->set_flashdata('message', get_phrase('pharmacist_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/pharmacist');
        }

        if ($task == "update") {
            $this->crud_model->update_pharmacist_info($pharmacist_id);
            redirect(base_url() . 'index.php?admin/pharmacist');
        }

        if ($task == "delete") {
            $this->crud_model->delete_pharmacist_info($pharmacist_id);
            redirect(base_url() . 'index.php?admin/pharmacist');
        }

        $data['pharmacist_info'] = $this->crud_model->select_pharmacist_info();
        $data['page_name'] = 'manage_pharmacist';
        $data['page_title'] = get_phrase('pharmacist');
        $this->load->view('backend/index', $data);
    }

    function laboratorist($task = "", $laboratorist_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_laboratorist_info();
            $this->session->set_flashdata('message', get_phrase('laboratorist_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/laboratorist');
        }

        if ($task == "update") {
                $this->crud_model->update_laboratorist_info($laboratorist_id);
                redirect(base_url() . 'index.php?admin/laboratorist');
        }

        if ($task == "delete") {
            $this->crud_model->delete_laboratorist_info($laboratorist_id);
            redirect(base_url() . 'index.php?admin/laboratorist');
        }

        $data['laboratorist_info'] = $this->crud_model->select_laboratorist_info();
        $data['page_name'] = 'manage_laboratorist';
        $data['page_title'] = get_phrase('laboratorist');
        $this->load->view('backend/index', $data);
    }

    function accountant($task = "", $accountant_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_accountant_info();
            $this->session->set_flashdata('message', get_phrase('accountant_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/accountant');
        }

        if ($task == "update") {
          $this->crud_model->update_accountant_info($accountant_id);
          redirect(base_url() . 'index.php?admin/accountant');
        }

        if ($task == "delete") {
            $this->crud_model->delete_accountant_info($accountant_id);
            redirect(base_url() . 'index.php?admin/accountant');
        }

        $data['accountant_info'] = $this->crud_model->select_accountant_info();
        $data['page_name'] = 'manage_accountant';
        $data['page_title'] = get_phrase('accountant');
        $this->load->view('backend/index', $data);
    }

    function receptionist($task = "", $receptionist_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_receptionist_info();
            $this->session->set_flashdata('message', get_phrase('receptionist_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/receptionist');
        }

        if ($task == "update") {
          $this->crud_model->update_receptionist_info($receptionist_id);
          redirect(base_url() . 'index.php?admin/receptionist');
        }

        if ($task == "delete") {
            $this->crud_model->delete_receptionist_info($receptionist_id);
            redirect(base_url() . 'index.php?admin/receptionist');
        }

        $data['receptionist_info'] = $this->crud_model->select_receptionist_info();
        $data['page_name'] = 'manage_receptionist';
        $data['page_title'] = get_phrase('receptionist');
        $this->load->view('backend/index', $data);
    }

    function payment_history($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['invoice_info'] = $this->crud_model->select_invoice_info();
        $data['page_name'] = 'show_payment_history';
        $data['page_title'] = get_phrase('payment_history');
        $this->load->view('backend/index', $data);
    }
    function payment_history_by_doctor($task = "") {

        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $data['page_name'] = 'show_payment_history_by_doctor';
        $data['page_title'] = get_phrase('payment_history_by_doctor');
        $this->load->view('backend/index', $data);
    }

    function payment_history_by_doctor_post($task = "") {

        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $returndata = array(
            'doctor_id'=>$_POST['doctor_id'],
            'from_date'=>$_POST['from_date'],
            'to_date'=>$_POST['to_date'],
        );

        $data['invoice_info'] = $this->crud_model->get_payment_history_by_doctor($returndata);
        /*echo "<pre>";
        var_dump($data['invoice_info']);
        echo "</pre>";
        die();*/
        $data['page_name'] = 'show_payment_history_by_doctor';
        $data['page_title'] = get_phrase('payment_history_by_doctor');
        $this->load->view('backend/index', $data);
    }

    function bed_allotment($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['bed_allotment_info'] = $this->crud_model->select_bed_allotment_info();
        $data['page_name'] = 'show_bed_allotment';
        $data['page_title'] = get_phrase('bed_allotment');
        $this->load->view('backend/index', $data);
    }

    function blood_bank($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['blood_bank_info'] = $this->crud_model->select_blood_bank_info();
        $data['page_name'] = 'show_blood_bank';
        $data['page_title'] = get_phrase('blood_bank');
        $this->load->view('backend/index', $data);
    }

    function blood_donor($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['blood_donor_info'] = $this->crud_model->select_blood_donor_info();
        $data['page_name'] = 'show_blood_donor';
        $data['page_title'] = get_phrase('blood_donor');
        $this->load->view('backend/index', $data);
    }

    function medicine($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['medicine_info'] = $this->crud_model->select_medicine_info();
        $data['page_name'] = 'show_medicine';
        $data['page_title'] = get_phrase('medicine');
        $this->load->view('backend/index', $data);
    }

    function operation_report($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'show_operation_report';
        $data['page_title'] = get_phrase('operation_report');
        $this->load->view('backend/index', $data);
    }

    function birth_report($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'show_birth_report';
        $data['page_title'] = get_phrase('birth_report');
        $this->load->view('backend/index', $data);
    }

    function death_report($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'show_death_report';
        $data['page_title'] = get_phrase('death_report');
        $this->load->view('backend/index', $data);
    }

    function notice($task = "", $notice_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_notice_info();
            $this->session->set_flashdata('message', get_phrase('notice_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/notice');
        }

        if ($task == "update") {
            $this->crud_model->update_notice_info($notice_id);
            $this->session->set_flashdata('message', get_phrase('notice_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/notice');
        }

        if ($task == "delete") {
            $this->crud_model->delete_notice_info($notice_id);
            redirect(base_url() . 'index.php?admin/notice');
        }

        $data['notice_info'] = $this->crud_model->select_notice_info();
        $data['page_name'] = 'manage_notice';
        $data['page_title'] = get_phrase('noticeboard');
        $this->load->view('backend/index', $data);
    }

    // PAYROLL
    function payroll()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name']     = 'payroll_add';
        $page_data['page_title']    = get_phrase('create_payroll');
        $this->load->view('backend/index', $page_data);
    }

    function payroll_selector()
    {
        $user           = explode('-', $this->input->post('employee_id'));
        $user_type      = $user[0];
        $employee_id    = $user[1];
        $month          = $this->input->post('month');
        $year           = $this->input->post('year');

        redirect(base_url() . 'index.php?admin/payroll_view/' . $user_type
            . '/' . $employee_id . '/' . $month . '/' . $year, 'refresh');
    }

    function payroll_view($user_type = '', $employee_id = '', $month = '', $year = '')
    {
        $page_data['user_type']     = $user_type;
        $page_data['employee_id']   = $employee_id;
        $page_data['month']         = $month;
        $page_data['year']          = $year;
        $page_data['page_name']     = 'payroll_add_view';
        $page_data['page_title']    = get_phrase('create_payroll');
        $this->load->view('backend/index', $page_data);
    }

    function create_payroll()
    {
        $data['payroll_code']   = substr(md5(rand(100000000, 20000000000)), 0, 7);
        $data['user_id']        = $this->input->post('user_id');
        $data['user_type']      = $this->input->post('user_type');
        $data['joining_salary'] = $this->input->post('joining_salary');

        $allowances             = array();
        $allowance_types        = $this->input->post('allowance_type');
        $allowance_amounts      = $this->input->post('allowance_amount');
        $number_of_entries      = sizeof($allowance_types);

        for($i = 0; $i < $number_of_entries; $i++)
        {
            if($allowance_types[$i] != "" && $allowance_amounts[$i] != "")
            {
                $new_entry = array('type' => $allowance_types[$i], 'amount' => $allowance_amounts[$i]);
                array_push($allowances, $new_entry);
            }
        }
        $data['allowances']     = json_encode($allowances);

        $deductions             = array();
        $deduction_types        = $this->input->post('deduction_type');
        $deduction_amounts      = $this->input->post('deduction_amount');
        $number_of_entries      = sizeof($deduction_types);

        for($i = 0; $i < $number_of_entries; $i++)
        {
            if($deduction_types[$i] != "" && $deduction_amounts[$i] != "")
            {
                $new_entry = array('type' => $deduction_types[$i], 'amount' => $deduction_amounts[$i]);
                array_push($deductions, $new_entry);
            }
        }
        $data['deductions']     = json_encode($deductions);
        $data['date']           = $this->input->post('month') . ',' . $this->input->post('year');
        $data['status']         = $this->input->post('status');

        $this->db->insert('payroll', $data);

        $this->session->set_flashdata('message', get_phrase('data_created_successfully'));
        redirect(base_url() . 'index.php?admin/payroll_list', 'refresh');
    }

    function payroll_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if($param1 == 'mark_paid') {
            $data['status'] = 1;

            $this->db->update('payroll', $data, array('payroll_id' => $param2));

            $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?admin/payroll_list', 'refresh');
        }

        $page_data['page_name']     = 'payroll_list';
        $page_data['page_title']    = get_phrase('payroll_list');
        $this->load->view('backend/index', $page_data);
    }

    // forntend management
    function frontend($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == '' || $param1 == 'home_page') {
            $page_data['inner_page']      = 'frontend_home_page';
            $page_data['sliders']         = $this->frontend_model->get_frontend_settings('slider');
            $page_data['welcome_content'] = $this->frontend_model->get_frontend_settings('homepage_welcome_section');
        }

        if ($param1 == 'about_us') {
            $page_data['inner_page']    =   'frontend_about_us';
        }

        if ($param1 == 'blog') {
            $page_data['inner_page']    =   'frontend_blog';
            $page_data['blogs']         =   $this->frontend_model->get_blogs();
        }

        if ($param1 == 'blog_new') {
            $page_data['inner_page']    =   'frontend_blog_new';
        }

        if ($param1 == 'blog_edit') {
            $page_data['blog']          =   $this->frontend_model->get_blog_details($param2);
            $page_data['inner_page']    =   'frontend_blog_edit';
        }

        if ($param1 == 'service') {
            $page_data['inner_page']    =   'frontend_service';
            $page_data['service']       =   $this->frontend_model->get_frontend_settings('service_section');
            $page_data['services']      =   $this->frontend_model->get_services();
        }

        if ($param1 == 'settings') {
            $page_data['inner_page']    =   'frontend_settings';
        }

        $page_data['page_name']     = 'frontend';
        $page_data['page_title']    = get_phrase('manage_hospital_website');
        $this->load->view('backend/index', $page_data);
    }

    // update frontend settings
    function frontend_settings($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'slider') {
            $this->frontend_model->update_slider();
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(base_url() . 'index.php?admin/frontend/home_page', 'refresh');
        }

        if ($param1 == 'welcome_section') {
            $this->frontend_model->update_welcome_section_content();
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(base_url() . 'index.php?admin/frontend/home_page', 'refresh');
        }

        if ($param1 == 'service_section') {
            $this->frontend_model->update_service_section();
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(base_url() . 'index.php?admin/frontend/service', 'refresh');
        }

        if ($param1 == 'service_new') {
            $this->frontend_model->add_new_service();
            $this->session->set_flashdata('message', get_phrase('service_saved_successfully'));
            redirect(base_url() . 'index.php?admin/frontend/service', 'refresh');
        }

        if ($param1 == 'service_edit') {
            $this->frontend_model->update_service($param2);
            $this->session->set_flashdata('message', get_phrase('service_updated_successfully'));
            redirect(base_url() . 'index.php?admin/frontend/service', 'refresh');
        }

        if ($param1 == 'service_delete') {
            $this->frontend_model->delete_service($param2);
            $this->session->set_flashdata('message', get_phrase('service_deleted_successfully'));
            redirect(base_url() . 'index.php?admin/frontend/service', 'refresh');
        }

        if ($param1 == 'blog_new') {
            $this->frontend_model->add_new_blog();
            $this->session->set_flashdata('message', get_phrase('blogpost_saved_successfully'));
            redirect(base_url() . 'index.php?admin/frontend/blog', 'refresh');
        }

        if ($param1 == 'blog_edit') {
            $this->frontend_model->update_blog($param2);
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(base_url() . 'index.php?admin/frontend/blog', 'refresh');
        }

        if ($param1 == 'blog_delete') {
            $this->frontend_model->delete_blog($param2);
            $this->session->set_flashdata('message', get_phrase('blog_deleted'));
            redirect(base_url() . 'index.php?admin/frontend/blog', 'refresh');
        }

        if ($param1 == 'about_us') {
            $this->frontend_model->update_about_us();
            $this->session->set_flashdata('message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/frontend/about_us', 'refresh');
        }

        if ($param1 == 'settings') {
            $this->frontend_model->update_frontend_settings();
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(base_url() . 'index.php?admin/frontend/settings', 'refresh');
        }
    }

    function contact_email($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('contact_email_id', $param2);
            $this->db->delete('contact_email');
            $this->session->set_flashdata('message', get_phrase('email_deleted'));
            redirect(base_url() . 'index.php?admin/contact_email', 'refresh');
        }

        $page_data['page_name']      = 'contact_email';
        $page_data['page_title']     = get_phrase('contact_emails');
        $page_data['contact_emails'] = $this->frontend_model->get_contact_emails();
        $this->load->view('backend/index', $page_data);
    }

}
