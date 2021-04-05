<?php

//test-test

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Dokter extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    public function index_get()
    {
        // json response array
        $response = array("error" => FALSE);
        //menerima parameter get
            $stmt = $this->db->query("SELECT * from paket");
            if (($stmt->num_rows()) > 0) {
                // user ada
                $response["error"] = FALSE;
                $response["paket"] = $stmt->result();
                $this->response($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Maaf Belum Ada Paket Tersedia";
                $this->response($response);
            }
        
    }

    public function allDokter_get()
    {
        // json response array
        $response = array("error" => FALSE);
        //menerima parameter get
        $stmt = $this->db->query("SELECT * from dokter_praktek left join kategori on dokter_praktek.id_kategori = kategori.id_kategori");
        if (($stmt->num_rows()) > 0) {
            // user ada
            $response["error"] = FALSE;
            $response["dokter"] = $stmt->result();
            $this->response($response);
        } else {
            $response["error"] = TRUE;
            $response["error_msg"] = "Maaf Belum Ada Data Tersedia";
            $this->response($response);
        }
        
    }


}
?>