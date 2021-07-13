<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth(); 
        $this->layout->auth_privilege($c_url);
        $this->load->model('Transaksi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'transaksi?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'transaksi?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'transaksi';
            $config['first_url'] = base_url() . 'transaksi';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Transaksi_model->total_rows($q);
        $transaksi = $this->Transaksi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'transaksi_data' => $transaksi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title'] = 'Transaksi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Transaksi' => '',
        ];

        $data['page'] = 'transaksi/transaksi_list';
        $this->load->view('template/backend', $data);
    }

    public function read($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kode_barang' => $row->kode_barang,
		'id_barang' => $row->id_barang,
		'harga_barang' => $row->harga_barang,
		'quantity' => $row->quantity,
		'total_bayar' => $row->total_bayar,
		'tanggal_penjualan' => $row->tanggal_penjualan,
		'pendapatan' => $row->pendapatan,
	    );
        $data['title'] = 'Transaksi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'transaksi/transaksi_read';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('transaksi/create_action'),
	    'kode_barang' => set_value('kode_barang'),
	    'id_barang' => set_value('id_barang'),
	    'harga_barang' => set_value('harga_barang'),
	    'quantity' => set_value('quantity'),
	    'total_bayar' => set_value('total_bayar'),
	    'tanggal_penjualan' => set_value('tanggal_penjualan'),
	    'pendapatan' => set_value('pendapatan'),
	);
        $data['title'] = 'Transaksi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'transaksi/transaksi_form';
        $this->load->view('template/backend', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_barang' => $this->input->post('id_barang',TRUE),
		'harga_barang' => $this->input->post('harga_barang',TRUE),
		'quantity' => $this->input->post('quantity',TRUE),
		'total_bayar' => $this->input->post('total_bayar',TRUE),
		'tanggal_penjualan' => $this->input->post('tanggal_penjualan',TRUE),
		'pendapatan' => $this->input->post('pendapatan',TRUE),
	    );

            $this->Transaksi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('transaksi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('transaksi/update_action'),
		'kode_barang' => set_value('kode_barang', $row->kode_barang),
		'id_barang' => set_value('id_barang', $row->id_barang),
		'harga_barang' => set_value('harga_barang', $row->harga_barang),
		'quantity' => set_value('quantity', $row->quantity),
		'total_bayar' => set_value('total_bayar', $row->total_bayar),
		'tanggal_penjualan' => set_value('tanggal_penjualan', $row->tanggal_penjualan),
		'pendapatan' => set_value('pendapatan', $row->pendapatan),
	    );
            $data['title'] = 'Transaksi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'transaksi/transaksi_form';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_barang', TRUE));
        } else {
            $data = array(
		'id_barang' => $this->input->post('id_barang',TRUE),
		'harga_barang' => $this->input->post('harga_barang',TRUE),
		'quantity' => $this->input->post('quantity',TRUE),
		'total_bayar' => $this->input->post('total_bayar',TRUE),
		'tanggal_penjualan' => $this->input->post('tanggal_penjualan',TRUE),
		'pendapatan' => $this->input->post('pendapatan',TRUE),
	    );

            $this->Transaksi_model->update($this->input->post('kode_barang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('transaksi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);

        if ($row) {
            $this->Transaksi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('transaksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi'));
        }
    }

    public function deletebulk(){
        $delete = $this->Transaksi_model->deletebulk();
        if($delete){
            $this->session->set_flashdata('message', 'Delete Record Success');
        }else{
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }
   
    public function _rules() 
    {
	$this->form_validation->set_rules('id_barang', 'id barang', 'trim|required');
	$this->form_validation->set_rules('harga_barang', 'harga barang', 'trim|required');
	$this->form_validation->set_rules('quantity', 'quantity', 'trim|required');
	$this->form_validation->set_rules('total_bayar', 'total bayar', 'trim|required');
	$this->form_validation->set_rules('tanggal_penjualan', 'tanggal penjualan', 'trim|required');
	$this->form_validation->set_rules('pendapatan', 'pendapatan', 'trim|required');

	$this->form_validation->set_rules('kode_barang', 'kode_barang', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-13 15:40:53 */
/* http://harviacode.com */