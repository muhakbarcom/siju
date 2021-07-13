<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Detail_transaksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth(); 
        $this->layout->auth_privilege($c_url);
        $this->load->model('Detail_transaksi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'detail_transaksi?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'detail_transaksi?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'detail_transaksi';
            $config['first_url'] = base_url() . 'detail_transaksi';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Detail_transaksi_model->total_rows($q);
        $detail_transaksi = $this->Detail_transaksi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'detail_transaksi_data' => $detail_transaksi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title'] = 'Detail Transaksi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Detail Transaksi' => '',
        ];

        $data['page'] = 'detail_transaksi/detail_transaksi_list';
        $this->load->view('template/backend', $data);
    }

    public function read($id) 
    {
        $row = $this->Detail_transaksi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kode_transaksi' => $row->kode_transaksi,
		'jumlah_transaksi' => $row->jumlah_transaksi,
		'nama_transaksi' => $row->nama_transaksi,
		'kode_dtl_transaksi' => $row->kode_dtl_transaksi,
	    );
        $data['title'] = 'Detail Transaksi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'detail_transaksi/detail_transaksi_read';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('detail_transaksi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('detail_transaksi/create_action'),
	    'kode_transaksi' => set_value('kode_transaksi'),
	    'jumlah_transaksi' => set_value('jumlah_transaksi'),
	    'nama_transaksi' => set_value('nama_transaksi'),
	    'kode_dtl_transaksi' => set_value('kode_dtl_transaksi'),
	);
        $data['title'] = 'Detail Transaksi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'detail_transaksi/detail_transaksi_form';
        $this->load->view('template/backend', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'jumlah_transaksi' => $this->input->post('jumlah_transaksi',TRUE),
		'nama_transaksi' => $this->input->post('nama_transaksi',TRUE),
		'kode_dtl_transaksi' => $this->input->post('kode_dtl_transaksi',TRUE),
	    );

            $this->Detail_transaksi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('detail_transaksi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Detail_transaksi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('detail_transaksi/update_action'),
		'kode_transaksi' => set_value('kode_transaksi', $row->kode_transaksi),
		'jumlah_transaksi' => set_value('jumlah_transaksi', $row->jumlah_transaksi),
		'nama_transaksi' => set_value('nama_transaksi', $row->nama_transaksi),
		'kode_dtl_transaksi' => set_value('kode_dtl_transaksi', $row->kode_dtl_transaksi),
	    );
            $data['title'] = 'Detail Transaksi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'detail_transaksi/detail_transaksi_form';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('detail_transaksi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_transaksi', TRUE));
        } else {
            $data = array(
		'jumlah_transaksi' => $this->input->post('jumlah_transaksi',TRUE),
		'nama_transaksi' => $this->input->post('nama_transaksi',TRUE),
		'kode_dtl_transaksi' => $this->input->post('kode_dtl_transaksi',TRUE),
	    );

            $this->Detail_transaksi_model->update($this->input->post('kode_transaksi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('detail_transaksi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Detail_transaksi_model->get_by_id($id);

        if ($row) {
            $this->Detail_transaksi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('detail_transaksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('detail_transaksi'));
        }
    }

    public function deletebulk(){
        $delete = $this->Detail_transaksi_model->deletebulk();
        if($delete){
            $this->session->set_flashdata('message', 'Delete Record Success');
        }else{
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }
   
    public function _rules() 
    {
	$this->form_validation->set_rules('jumlah_transaksi', 'jumlah transaksi', 'trim|required');
	$this->form_validation->set_rules('nama_transaksi', 'nama transaksi', 'trim|required');
	$this->form_validation->set_rules('kode_dtl_transaksi', 'kode dtl transaksi', 'trim|required');

	$this->form_validation->set_rules('kode_transaksi', 'kode_transaksi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Detail_transaksi.php */
/* Location: ./application/controllers/Detail_transaksi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-13 15:08:31 */
/* http://harviacode.com */