<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('contest_model', 'contest');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function contestant() {
		$data['districts'] = $this->contest->getDistricts();
		/*print_r($data['districts']);
		echo $data['districts'][0]->Id;exit();*/
		$this->load->view('contestant_view', $data);
	}

	public function push_contestant() {
		$this->validate();

		$data = array(
					"Firstname" => $this->input->post('first_name'),
					"Lastname" => $this->input->post('last_name'),
					"DateOfBirth" => $this->input->post('dob'),
					"IsActive" => (int)$this->input->post('is_active'),
					"DistrictId" => $this->input->post('district'),
					"Gender" => $this->input->post('gender'),
					"PhotoUrl" => htmlspecialchars($this->input->post('file_path')),
					"Address" => $this->input->post('address')
				);


		if($this->input->post('hidden') == 'create') {
			$this->contest->insert($data);
			echo json_encode(array("status" => true));
		} else {
			$this->contest->update_contestant($this->input->post('hiddenId'), $data);
			echo json_encode(array("status" => true));
		}
	}

	public function read_contestant() {
		$data = $this->contest->select_contestant();
		$tbody = '';
		foreach($data as $key => $value) {
			//echo $key;
			$tbody = $tbody . '<tr>';
			$tbody = $tbody . '<td>' . ucfirst($value->Firstname) . ' ' . ucfirst($value->Lastname) . '</td>';
			$tbody = $tbody . '<td>' . date("Y/m/d", strtotime($value->DateOfBirth)) . '</td>';
			$tbody = $tbody . '<td>' . $value->Name . '</td>';
			$tbody = $tbody . '<td>' . $value->Gender . '</td>';
			$tbody = $tbody . '<td><button onclick="editContestant('.$value->contestantId.')">Edit</button></td>';
			$tbody = $tbody . '<td><button onclick="deleteContestant('.$value->contestantId.')">Delete</button></td>';
			$tbody = $tbody . '</tr>';
		}
		echo json_encode($tbody);
		//echo json_encode(array("status" => TRUE));
	}

	public function read_contestant_by_id($id) {
		$data = $this->contest->select_contestant_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function delete_contestant($id) {
		$data = $this->contest->select_contestant_by_id($id);
		$path = $data->PhotoUrl;

		$this->contest->delete_contestant($id);
		unlink(htmlspecialchars($path));

		echo json_encode(array("status" => true));
	}

	public function upload_image() {

        $config['upload_path'] = 'assets/images/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '1024';
        $config['overwrite'] = true;
        $config['remove_spaces'] = false;

        $this->load->library('upload', $config);
        $this->upload->do_upload('file');
        $path = 'assets/images/' . $_FILES['file']['name'];

        echo json_encode($path);
	}

	public function delete_image() {
		unlink('assets/images/' . $_SERVER['file_name']);

		echo json_encode('File deleted -  '. $this->session->userdata('file_name'));
	}

	public function gallery() {
		$data['contestants'] = $this->contest->getContestants();
		$this->load->view('gallery_view', $data);
	}

	function validate() {
		$data = array();
		$data['status'] = TRUE;

		if($this->input->post('first_name') == '') {
			$data['inputerror'][] = 'first_name';
			$data['error_string'][] = 'First name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('gender') == '') {
			$data['inputerror'][] = 'genderr';
			$data['error_string'][] = 'Select a gender';
			$data['status'] = FALSE;
		}

		if($this->input->post('last_name') == '') {
			$data['inputerror'][] = 'last_name';
			$data['error_string'][] = 'Last name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('dob') == '') {
			$data['inputerror'][] = 'dob';
			$data['error_string'][] = 'DOB is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('district') == '0') {
			$data['inputerror'][] = 'district';
			$data['error_string'][] = 'Select a district';
			$data['status'] = FALSE;
		}

		if($this->input->post('address') == '') {
			$data['inputerror'][] = 'address';
			$data['error_string'][] = 'Addess is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
