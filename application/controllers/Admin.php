<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		/*
		if(!$this->session->userdata['email']) {
			redirect('auth');
		}
		*/
		is_logged_in();
	}

	public function index()
	{
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email'=> 
        $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer');
        //echo 'Selamat datang ' . $data['user']['name'];
	}

	public function role()
	{
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email'=> 
        $this->session->userdata('email')])->row_array();

		$data['role'] = $this->db->get('user_role')->result_array();

		$this->form_validation->set_rules('role', 'Role', 'required');

		if($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/role', $data);
			$this->load->view('templates/footer');
			//echo 'Selamat datang ' . $data['user']['name'];
		}

		else {
			$this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">New role added!</div>');
            redirect('admin/role');
		}

	}

	public function roleAccess($role_id)
	{
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email'=> 
        $this->session->userdata('email')])->row_array();

		$data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

		$this->db->where('id !=', 1);
		$data['menu'] = $this->db->get('user_menu')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/role-access', $data);
		$this->load->view('templates/footer');
        //echo 'Selamat datang ' . $data['user']['name'];
	}

	public function changeAccess()
	{
		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];

		$result = $this->db->get_where('user_access_menu', $data);

		if($result->num_rows() < 1)
		{
			$this->db->insert('user_access_menu', $data);
		} else {
			$this->db->delete('user_access_menu', $data);
		}

		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Access Changed!</div>');
	}

	public function edit($role_id){
		$data['title'] = 'Edit Role';
        $data['user'] = $this->db->get_where('user', ['email'=> 
        $this->session->userdata('email')])->row_array();
		
		$data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

		$this->form_validation->set_rules('role', 'Role Name', 'required|trim');

		if($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/edit', $data);
			$this->load->view('templates/footer');
			//echo 'Selamat datang ' . $data['user']['name'];
		}

		else {
			$role = $this->input->post('role');
			$email = $this->input->post('email');

			$this->db->set('role', $role);
			$this->db->where('email', $email);
			$this->db->update('user_role');
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Your role has been updated!</div>');
			redirect('admin/role');
		}
	}

	public function delete($role_id)
	{
		echo "Your role has been deleted!";
	}
}
