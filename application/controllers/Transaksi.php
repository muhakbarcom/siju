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
        $this->load->model('Detail_transaksi_model');
        $this->load->model('Barang_model');
        $this->load->model('Keranjang_model');
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
		'id_transaksi' => $row->id_transaksi,
		'status_transaksi' => $row->status_transaksi,
		'total_bayar' => $row->total_bayar,
		'tanggal_transaksi' => $row->tanggal_transaksi,
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
            'action' => site_url('keranjang/create_action'),
	    'id_transaksi' => set_value('id_transaksi'),
	    'status_transaksi' => set_value('status_transaksi'),
	    'total_bayar' => set_value('total_bayar'),
	    'tanggal_transaksi' => set_value('tanggal_transaksi'),
	);
        $data['title'] = 'Transaksi';
        $data['barang'] = $this->db->query("select * from barang")->result();
        $data['keranjang'] = $this->db->query("select * from keranjang")->result();
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'transaksi/pesan';
        $this->load->view('template/backend', $data);
    }
    public function nota($idtrx) 
    {
        $transaksi= $this->db->query("select id_transaksi,total_bayar,tanggal_transaksi from transaksi where id_transaksi=$idtrx")->row();
        $data = array(
            'button' => 'Create',
            'action' => site_url('keranjang/create_action'),
	    'id_transaksi' => $transaksi->id_transaksi,
	    'total_bayar' =>  $transaksi->total_bayar,
	    'tanggal_transaksi' => $transaksi->tanggal_transaksi,
	);
        $data['title'] = 'Transaksi';
        $data['detail'] = $this->db->query("select * from detail_transaksi where id_transaksi=$idtrx")->result();
     
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'keranjang/nota';
        $this->load->view('template/backend', $data);
    }
    public function printnota($idtrx) 
    {
        $transaksi= $this->db->query("select id_transaksi,total_bayar,tanggal_transaksi from transaksi where id_transaksi=$idtrx")->row();
        $data = array(
            'button' => 'Create',
            'action' => site_url('keranjang/create_action'),
	    'id_transaksi' => $transaksi->id_transaksi,
	    'total_bayar' =>  $transaksi->total_bayar,
	    'tanggal_transaksi' => $transaksi->tanggal_transaksi,
	);
        $data['title'] = 'Transaksi';
        $data['detail'] = $this->db->query("select * from detail_transaksi where id_transaksi=$idtrx")->result();
     
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'keranjang/nota_print';
        $this->load->view('template/backend', $data);
    }
    
    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            //$this->create();
            echo "oke";
        } else {
            // ambil data keranjang
            $keranjang_row = $this->db->query("SELECT sum(total_harga) as total from keranjang")->row();
            // insert data sewa
            $data = array(
                'tanggal_transaksi' => date('Y-m-d'),
                // 'tgl_pengembalian' => $this->input->post('tgl_pengembalian', TRUE),
                // 'denda' => $this->input->post('denda', TRUE),
                'total_bayar' => $keranjang_row->total,
                
            );
            $insert_id = $this->Transaksi_model->insert($data);


            // insert data detail_sewa
            $keranjang = $this->Keranjang_model->get_all();
            foreach ($keranjang as $k) {
                $data = array(
                    'id_transaksi' => $insert_id,
                    'id_barang' => $k->id_barang,
                    'quantity' => $k->qty,
                    'total' => $k->total_harga,
                );
                $this->Detail_transaksi_model->insert($data);
            }

            $this->Keranjang_model->delete_all();

            $this->session->set_flashdata('success', 'Create Record Success');
            redirect ("transaksi/nota/".$insert_id);
        }
    }
    
    public function update($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('transaksi/update_action'),
		'id_transaksi' => set_value('id_transaksi', $row->id_transaksi),
		'status_transaksi' => set_value('status_transaksi', $row->status_transaksi),
		'total_bayar' => set_value('total_bayar', $row->total_bayar),
		'tanggal_transaksi' => set_value('tanggal_transaksi', $row->tanggal_transaksi),
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
            $this->update($this->input->post('id_transaksi', TRUE));
        } else {
            $data = array(
		'status_transaksi' => $this->input->post('status_transaksi',TRUE),
		'total_bayar' => $this->input->post('total_bayar',TRUE),
		'tanggal_transaksi' => $this->input->post('tanggal_transaksi',TRUE),
	    );

            $this->Transaksi_model->update($this->input->post('id_transaksi', TRUE), $data);
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
	

	$this->form_validation->set_rules('id_transaksi', 'id_transaksi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-16 07:39:50 */
/* http://harviacode.com */