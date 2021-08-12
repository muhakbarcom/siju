<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class View_penjualan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth(); 
        $this->layout->auth_privilege($c_url);
        $this->load->model('View_penjualan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'view_penjualan?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'view_penjualan?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'view_penjualan';
            $config['first_url'] = base_url() . 'view_penjualan';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        
        $dari =  $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        if ($dari) {
            $config['total_rows'] = $this->View_penjualan_model->total_rows_laporan($q,$dari,$sampai);
            $view_penjualan = $this->View_penjualan_model->get_limit_data_laporan($config['per_page'], $start, $q,$dari,$sampai);
        } else {
            $config['total_rows'] = $this->View_penjualan_model->total_rows($q);
            $view_penjualan = $this->View_penjualan_model->get_limit_data($config['per_page'], $start, $q);
        }
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'view_penjualan_data' => $view_penjualan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title'] = 'View Penjualan';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'View Penjualan' => '',
        ];

        $data['page'] = 'view_penjualan/view_penjualan_list';
        $this->load->view('template/backend', $data);
    }

    public function read($id) 
    {
        $row = $this->View_penjualan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'tanggal_transaksi' => $row->tanggal_transaksi,
		'total_pendapatan' => $row->total_pendapatan,
	    );
        $data['title'] = 'View Penjualan';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'view_penjualan/view_penjualan_read';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('view_penjualan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('view_penjualan/create_action'),
	    'tanggal_transaksi' => set_value('tanggal_transaksi'),
	    'total_pendapatan' => set_value('total_pendapatan'),
	);
        $data['title'] = 'View Penjualan';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'view_penjualan/view_penjualan_form';
        $this->load->view('template/backend', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'tanggal_transaksi' => $this->input->post('tanggal_transaksi',TRUE),
		'total_pendapatan' => $this->input->post('total_pendapatan',TRUE),
	    );

            $this->View_penjualan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('view_penjualan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->View_penjualan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('view_penjualan/update_action'),
		'tanggal_transaksi' => set_value('tanggal_transaksi', $row->tanggal_transaksi),
		'total_pendapatan' => set_value('total_pendapatan', $row->total_pendapatan),
	    );
            $data['title'] = 'View Penjualan';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'view_penjualan/view_penjualan_form';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('view_penjualan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('', TRUE));
        } else {
            $data = array(
		'tanggal_transaksi' => $this->input->post('tanggal_transaksi',TRUE),
		'total_pendapatan' => $this->input->post('total_pendapatan',TRUE),
	    );

            $this->View_penjualan_model->update($this->input->post('', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('view_penjualan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->View_penjualan_model->get_by_id($id);

        if ($row) {
            $this->View_penjualan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('view_penjualan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('view_penjualan'));
        }
    }

    public function deletebulk(){
        $delete = $this->View_penjualan_model->deletebulk();
        if($delete){
            $this->session->set_flashdata('message', 'Delete Record Success');
        }else{
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }
   
    public function _rules() 
    {
	$this->form_validation->set_rules('tanggal_transaksi', 'tanggal transaksi', 'trim|required');
	$this->form_validation->set_rules('total_pendapatan', 'total pendapatan', 'trim|required|numeric');

	$this->form_validation->set_rules('', '', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "view_penjualan.xls";
        $judul = "view_penjualan";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Transaksi");
	xlsWriteLabel($tablehead, $kolomhead++, "Total Pendapatan");

	foreach ($this->View_penjualan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_transaksi);
	    xlsWriteNumber($tablebody, $kolombody++, $data->total_pendapatan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=view_penjualan.doc");

        $data = array(
            'view_penjualan_data' => $this->View_penjualan_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('view_penjualan/view_penjualan_doc',$data);
    }

  public function printdoc(){
        $data = array(
            'view_penjualan_data' => $this->View_penjualan_model->get_all(),
            'start' => 0
        );
        $this->load->view('view_penjualan/view_penjualan_print', $data);
    }

}

/* End of file View_penjualan.php */
/* Location: ./application/controllers/View_penjualan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-18 10:03:08 */
/* http://harviacode.com */