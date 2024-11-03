<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct() {
		parent::__construct();
		//$this->load->library('form_validation');
		/*
		if(!$this->session->userdata['email']) {
			redirect('auth');
		}
		*/
		is_logged_in();
	}

	public function index()
	{
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email'=> 
        $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
            //echo 'Selamat datang ' . $data['user']['name'];
        }

        else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
	}

    public function submenu() {
        $data['title'] = 'Sub Menu Management';
        $data['user'] = $this->db->get_where('user', ['email'=> 
        $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');

        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
            //echo 'Selamat datang ' . $data['user']['name'];
        }

        else {
            $data = [
                'title'=> $this->input->post('title'),
                'menu_id'=> $this->input->post('menu_id'),
                'url'=> $this->input->post('url'),
                'icon'=> $this->input->post('icon'),
                'is_active'=> $this->input->post('is_active'),

            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">New sub menu added!</div>');
            redirect('menu/submenu');
        }
    }

	public function edit($menu_id){
		$data['title'] = 'Edit Menu';
        $data['user'] = $this->db->get_where('user', ['email'=> 
        $this->session->userdata('email')])->row_array();
		
		$data['menu'] = $this->db->get_where('user_menu', ['id' => $menu_id])->row_array();

		$this->form_validation->set_rules('menu', 'Menu Name', 'required|trim');

		if($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('menu/edit', $data);
			$this->load->view('templates/footer');
			//echo 'Selamat datang ' . $data['user']['name'];
		}

		else {
			$menu = $this->input->post('menu');
			$email = $this->input->post('email');

			$this->db->set('menu', $menu);
			$this->db->where('email', $email);
			$this->db->update('user_menu');
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Your menu has been updated!</div>');
			redirect('menu');
		}
	}

	public function submenuEdit($submenu_id){
		$data['title'] = 'Edit Sub Menu';
        $data['user'] = $this->db->get_where('user', ['email'=> 
        $this->session->userdata('email')])->row_array();

		$this->load->model('Menu_model', 'menu');
		
		$data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
		$data['sub_menu'] = $this->db->get('user_sub_menu', ['id' => $submenu_id])->row_array();

		$this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');

		if($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('menu/submenuedit', $data);
			$this->load->view('templates/footer');
			//echo 'Selamat datang ' . $data['user']['name'];
		}

		else {
			$title = $this->input->post('title');
			$menu_id = $this->input->post('menu_id');
			$url = $this->input->post('url');
			$icon = $this->input->post('icon');
			$email = $this->input->post('email');

			$this->db->set('title', $title);
			$this->db->set('menu_id', $menu_id);
			$this->db->set('url', $url);
			$this->db->set('icon', $icon);
			$this->db->where('email', $email);
			$this->db->update('user_sub_menu');
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Your sub menu has been updated!</div>');
			redirect('menu/submenu');
		}
	}
}
