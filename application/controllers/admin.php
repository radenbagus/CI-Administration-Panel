<?php
class admin extends CI_Controller {
	/**
	 *
	 * Load construct and set values for app.
	 *
	 */
	var $sess_profile = '';
	var $sess_email = '';
	var $sess_vanity = '';
	var $logged = '';
	var $data = '';
	
	function __construct() {
		parent::__construct();
		$this -> load -> model('admin_model', '', TRUE);
		$this -> load -> library('session');
		$this -> load -> helper('url');
		$this -> sess_profile = $this -> session -> userdata('profile');
		$this -> sess_email = $this -> session -> userdata('email');
		$this -> logged = $this -> session -> userdata('logged_in');
		$this -> data['sel_secciones'] = "";
		$this -> data['sel_content'] = "";
		$this -> data['sel_logos'] = "";
		$this -> data['sel_config'] = "";
		$this -> data['sel_cm'] = "";
		$this -> data['post'] = FALSE;
	}

	function index() {
		$this -> _check_login();
		$this -> _selected("videos");
		$this -> images();
	}

	function login() {
		if ($this -> logged) {
			redirect('/admin/');
		}
		$this -> data['message'] = "";
		$this -> data['post'] = FALSE;
		if ($this -> input -> post('gologin')) {
			$valcheck = TRUE;
			$this -> data['post'] = TRUE;
			$valemail = $this -> input -> post('email');
			$password = md5($this -> input -> post('password'));
			if (($valemail) && ($password)) {
				$check_email = $this -> admin_model -> get_email($valemail);
				if (isset($check_email) && ($password == $check_email -> password)) {
					if ($valcheck) {
						$newdata = array('userid' => $check_email -> id, 'role' => $check_email -> id, 'email' => $check_email -> email, 'logged_in' => TRUE);
						$this -> session -> set_userdata($newdata);
						redirect('/admin/');
					} else {
						$this -> data['logged'] = $valcheck;
						$this -> data['message'] = "Combinac&iacute;on email / clave no correto";
					}
				} else {
					$this -> data['logged'] = FALSE;
					$this -> data['message'] = "Combinac&iacute;on email / clave no correto";
				}
			} else {
				$this -> data['logged'] = FALSE;
				$this -> data['message'] = "Todos los campos son obligatorios";
			}
		}
		$this -> load -> view('admin/pages/login', $this -> data);
	}

	function config($action = null, $aid = null) {
		$this -> _check_login();
		$this -> _selected("config");
		$this -> data['result'] = FALSE;
		switch ($action) {
			case 'update' :
				$this -> admin_model -> update_order($value, $key);
				break;
			case 'new' :
				if ($this -> input -> post('name')) {
					$result = $this -> admin_model -> create_profile();
					if ($result)
						$this -> data['result'] = TRUE;
				}
				break;
			case 'delete' :
				$this -> data['result'] = TRUE;
				$this -> admin_model -> delete("admin_users", $aid);
				$this -> data['users'] = $this -> admin_model -> get("admin_users");
				$this -> load -> view('admin/pages/config', $this -> data);
				break;
			default :
				$this -> data['users'] = $this -> admin_model -> get("admin_users");
				$this -> load -> view('admin/pages/config', $this -> data);
				break;
		}
	}

	function images($action = NULL, $aid = NULL, $sid = NULL) {
		$this -> data['result'] = FALSE;
		$this -> _check_login();
		$this -> _selected("logos");
		
		
		$this -> data['sinfo'] = 0;
		
		switch ($action) {
			
			case 'save' :
			
				if ($this->input->post('name')) {
					
					if($sid) {
						$result = $this -> admin_model -> update_names($sid);
					}
					
					if ($result) {  $this -> data['result'] = TRUE; }
                                        }
				
				break;
				
			case 'update':
				
				$orderpost = $this->input->post('pages');
				parse_str($this->input->post('pages'), $pageOrder);

				foreach ($pageOrder['logo'] as $key => $value) {
					$this->admin_model->update_order($value, $key);
				}

				break;
				
			case 'upload' :
			
				$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/img/gallery/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '10000';
				$config['max_width'] = '3000';
				$config['max_height'] = '3000';
				$this -> load -> library('upload', $config);
				
				if (!$this -> upload -> do_upload()) {
					
					$error = array('error' => $this -> upload -> display_errors());
					echo "error";
					
				} else {
					
					$image_resize = $this -> upload -> data();
					$image_name = $image_resize['file_name'];
					$result = $this -> admin_model -> insert_image($image_name, $sid);
					echo "success";
				}
				
				break;
				
			case 'delete' :
				
				$this -> admin_model -> delete("gallery_photos", $aid);
				
				break;
				
			case 'new' :
				
				if ($this->input->post('name')) {
					$this -> admin_model -> add_new();
				}
				
				break;
				
						
			case 'view' :
				
				$categoria = $aid;
				$this -> data['info'] = $categoria;
				
				$this -> data['cats'] = $this -> admin_model -> get("gallery_cat_primary");
				$this -> data['scats'] = $this -> admin_model -> get_orderby("gallery_cat_secondary", "id", "pid = $categoria");
				
				if($sid) {
					 $this -> data['sinfo'] = $sid; 
				} else {
					$findid = min($this -> data['scats']);
					$sid = $findid->id;
				}
				
				$this -> data['catinfo'] = $this -> admin_model -> get_one("gallery_cat_secondary", "id = $sid");
				$this -> data['logos'] = $this -> admin_model -> get_orderby("gallery_photos", "weight", "sid = $sid");
				$this -> load -> view('admin/pages/images', $this -> data);
				
				break;
				
			default :
				

				$categoria = $this -> data['info'] = 1;
				$sid = $this -> data['sinfo'] = 1;

				$this -> data['cats'] = $this -> admin_model -> get("gallery_cat_primary");
				$this -> data['scats'] = $this -> admin_model -> get_orderby("gallery_cat_secondary", "id", "pid = $categoria");
				
				$this -> data['logos'] = $this -> admin_model -> get_orderby("gallery_photos", "weight", "sid = $sid");
				$this -> data['catinfo'] = $this -> admin_model -> get_one("gallery_cat_secondary", "id = $sid");

				$this -> load -> view('admin/pages/images', $this -> data);
				
				break;
		}
	}

	function sections($action = NULL, $aid = NULL) {
		
		$this -> data['result'] = FALSE;
		$this -> _check_login();
		$this -> _selected("secciones");
		
		switch ($action) {
			
			case 'edit' :
				if ($this -> input -> post('save')) {
					$this -> data['result'] = TRUE;
					$this -> admin_model -> update_section($aid);
				}
				$this -> data['section'] = $this -> admin_model -> get_one("press", "id = $aid");
				$this -> load -> view('admin/pages/sliders_edit', $this -> data);
				break;
				
			case 'new' :
				
				if ($this -> input -> post('name')) {
					$result = $this -> admin_model -> create_section();
					if ($result)
						$this -> data['result'] = TRUE;
				}
				break;
				
			case 'upload_image' :
				
				$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/img/press/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '10000';
				$this -> load -> library('upload', $config);
				if (!$this -> upload -> do_upload()) {						$error = array('error' => $this -> upload -> display_errors());
					echo "error";
				} else {						echo "success";
					$data = array('upload_data' => $this -> upload -> data());
				}
				break;
				
			case 'upload_pdf' :
				$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/img/press/';
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = '10000';
				$this -> load -> library('upload', $config);
				if (!$this -> upload -> do_upload()) {						$error = array('error' => $this -> upload -> display_errors());
					echo "error";
				} else {						echo "success";
					$data = array('upload_data' => $this -> upload -> data());
				}
				break;
				
			case 'delete' :
				
				$result = $this -> admin_model -> delete("press", $aid);
				
				if ($result) $this -> data['result'] = TRUE;
					
				$this -> data['data'] = $this -> admin_model -> get("press");
				$this -> load -> view('admin/pages/secciones', $this -> data);
				
				break;
				
			default :
				
				$this -> data['data'] = $this -> admin_model -> get("press");
				$this -> load -> view('admin/pages/secciones', $this -> data);
				break;
		}
	}

	function content($action = NULL, $aid = NULL) {
		
		$this -> _check_login();
		$this -> _selected("content");
		$this -> data['result'] = FALSE;
		$this -> data['action'] = $action;
		
		switch ($action) {
			case 'edit' :
				if ($this -> input -> post('save')) {
					$result = $this -> admin_model -> update_content($aid);
					if ($result) {
						$this -> data['result'] = TRUE;
					}
				}								
				$this -> data['content'] = $result = $this -> admin_model -> get_one("profile", "version = 1");
				$this -> load -> view('admin/pages/secciones_edit', $this -> data);
				break;
			default :
				$this -> data['content'] = $result = $this -> admin_model -> get_one("profile", "version = 1");
				$this -> load -> view('admin/pages/secciones_edit', $this -> data);
				break;
		}
	}

	function filters($action = NULL, $aid = NULL) {
		$this -> _check_login();
		$this -> _selected("filters");
		$this -> data['post'] = FALSE;
		$this -> data['result'] = FALSE;
		switch ($action) {
			case 'edit' :
				if ($this -> input -> post('modify_filter')) {
					$result = $this -> admin_model -> modify_filter($aid);
					if ($result) { $this -> data['result'] = TRUE;
					}
				}
				$this -> data['filter'] = $result = $this -> admin_model -> get_filter($aid);
				$this -> load -> view('admin/pages/filters_edit', $this -> data);
				break;
			case 'new' :
				if ($this -> input -> post('name')) {
					$result = $this -> admin_model -> create_tag();
					if ($result)
						$this -> data['result'] = TRUE;
				}
				$this -> load -> view('admin/pages/filters', $this -> data);
				break;
			case 'delete' :
				$result = $this -> admin_model -> delete_filter($aid);
				if ($result)
					$this -> data['result'] = TRUE;
				$this -> data['filters'] = $result = $this -> admin_model -> get_filters();
				$this -> load -> view('admin/pages/filters', $this -> data);
				break;
			default :
				$this -> data['filters'] = $result = $this -> admin_model -> get_filters();
				$this -> load -> view('admin/pages/filters', $this -> data);
				break;
		}
	}

	function cm($action = NULL) {
		$this -> _check_login();
		$this -> _selected("cm");
		$this -> data['result'] = "";
		switch ($action) {
			case 'update' :
				if ($this -> input -> post('about_save')) {
					$result = $this -> admin_model -> modify_about();
					if ($result)
						$this -> data['result'] = "about";
				}
				if ($this -> input -> post('contact_save')) {
					$result = $this -> admin_model -> modify_contact();
					if ($result) {
						$this -> data['result'] = "contact";
					}
				}
				$this -> data['data'] = $this -> admin_model -> get_content();
				$this -> load -> view('admin/pages/cm', $this -> data);
				break;
			default :
				$this -> data['data'] = $this -> admin_model -> get_one("profile", "version=1");
				$this -> load -> view('admin/pages/cm', $this -> data);
				break;
		}
	}/*

	 function images($action=NULL, $aid=NULL)
	 {
	 $this->_check_login();
	 $this->_selected("images");
	 switch ($action) {
	 case 'edit':
	 if($this->input->post('modify_filter')) {
	 $result = $this->admin_model->modify_filter($aid);
	 if($result) { $this->data['result'] = TRUE; }
	 }
	 $this->data['filter'] = $result = $this->admin_model->get_filter($aid);
	 $this->load->view('admin/pages/filters_edit', $this->data);
	 break;
	 case 'new':
	 if($this->input->post('photo')) {
	 $result = $this->admin_model->create_image();
	 if($result) $this->data['result'] = TRUE;
	 }
	 break;
	 case 'upload':
	 $config['upload_path'] =  $_SERVER['DOCUMENT_ROOT'].'/images/studiobig/';
	 $config['allowed_types'] = 'gif|jpg|png';
	 $config['max_size']	= '2000';
	 $config['max_width']  = '1024';
	 $config['max_height']  = '768';
	 $this->load->library('upload', $config);
	 if (!$this->upload->do_upload()) {
	 $error = array('error' => $this->upload->display_errors());
	 echo "error";
	 } else {
	 $image_resize = $this->upload->data();
	 $configsize['image_library'] = 'gd2';
	 $configsize['source_image']	= $image_resize['full_path'];
	 $configsize['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/images/studiothumb/'.$image_resize['file_name'];
	 $configsize['maintain_ratio'] = TRUE;
	 $configsize['width']	 = 200;
	 $this->load->library('image_lib', $configsize);
	 $this->image_lib->resize();
	 if(!$this->image_lib->resize()) {
	 echo "error";
	 } else {
	 echo "success";
	 }
	 $data = array('upload_data' => $this->upload->data());
	 }

	 break;
	 case 'delete':
	 $result = $this->admin_model->delete_image($aid);
	 if($result) $this->data['result'] = TRUE;
	 $this->data['images'] = $this->admin_model->get_images();
	 $this->load->view('admin/pages/images', $this->data);
	 break;
	 default:
	 $this->data['images'] = $this->admin_model->get_images();
	 $this->load->view('admin/pages/images', $this->data);
	 break;
	 }
	 }
	 */
	function logout() {
		$this -> session -> sess_destroy();
		redirect('/admin/login/?s=l');
	}

	function _check_login() {
		if (!$this -> logged) {
			redirect('/admin/login');
			exit ;
		}
	}

	function _selected($sel) {
		$this -> data['sel_secciones'] = "";
		$this -> data['sel_sliders'] = "";
		$this -> data['sel_logos'] = "";
		$this -> data['sel_config'] = "";
		$this -> data['sel_images'] = "";
		switch ($sel) {
			case 'secciones' :
				$this -> data['sel_secciones'] = "selected";
				break;
			case 'content' :
				$this -> data['sel_content'] = "selected";
				break;
			case 'logos' :
				$this -> data['sel_logos'] = "selected";
				break;
			case 'config' :
				$this -> data['sel_config'] = "selected";
				break;
			case 'images' :
				$this -> data['sel_images'] = "selected";
				break;
			default :
				break;
		}
	}

	function _curl_get($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		$return = curl_exec($curl);
		curl_close($curl);
		return $return;
	}

}
