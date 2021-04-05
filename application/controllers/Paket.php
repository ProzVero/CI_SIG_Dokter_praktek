<?php

//test-test

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Paket extends REST_Controller {

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

    public function menu_get()
    {
        // json response array
        $response = array("error" => FALSE);
        //menerima parameter get
        $harga = $this->get('harga');
        if (!empty($harga)) {
            $stmt = $this->db->query("SELECT * from menu WHERE harga = '$harga'");
            if (($stmt->num_rows()) > 0) {
                // user ada
                $response["error"] = FALSE;
                $response["menu"] = $stmt->result();
                $this->response($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Maaf Belum Ada Menu Tersedia di Paket Ini";
                $this->response($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Harga kosong";
            $this->response($response);
        }
        
    }

    public function tambahcart_post()
    {
        // json response array
        $response = array("error" => FALSE);
        // menerima parameter POST ( nama, email, password )
        $id_user = $this->post('id_user');
        $id_menu = $this->post('id_menu');
        $nama = $this->post('nama');
        $qty = $this->post('qty');
        $harga = $this->post('harga');
        $gambar = $this->post('gambar');

        if (!empty($id_user) && !empty($id_menu)) {
            $data = array(
                'id_user' => $id_user,
                'id_menu' => $id_menu,
                'nama' => $nama,
                'qty' => $qty,
                'harga' => $harga,
                'gambar' => $gambar
                );
            $result = $this->db->insert('cart',$data);
            if ($result) {
                // simpan cart berhasil
                $response["error"] = FALSE;
                $this->response($response);
            } else {
                // gagal menyimpan user
                $response["error"] = TRUE;
                $response["error_msg"] = "Failed to Add Cart";
    
                $this->response($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Masih ada data yang kosong";
    
            $this->response($response);
        }
        
    }

    public function cart_get()
    {
        // json response array
        $response = array("error" => FALSE);
        //menerima parameter get
        $id_user = $this->get('id_user');
        if (!empty($id_user)) {
            $stmt = $this->db->query("SELECT * from cart WHERE id_user = '$id_user'");
            if (($stmt->num_rows()) > 0) {
                // user ada
                $response["error"] = FALSE;
                $response["cart"] = $stmt->result();
                $this->response($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Maaf Belum Ada Cart yang Anda Tambahkan";
                $this->response($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "id_user kosong";
            $this->response($response);
        }
        
    }

    public function deletecart_get()
    {
        // json response array
        $response = array("error" => FALSE);
        //menerima parameter get
        $id_cart = $this->get('id_cart');
        if (!empty($id_cart)) {
            $this->db->where('id_cart', $id_cart);
            $Delete = $this->db->delete('cart');
            if ($Delete) {
                // delete berhasil
                $response["error"] = FALSE;
                $this->response($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Gagal Menghapus cart";
                $this->response($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "id_cart kosong";
            $this->response($response);
        }
        
    }

    public function deleteorder_get()
    {
        // json response array
        $response = array("error" => FALSE);
        //menerima parameter get
        $id_order = $this->get('id_order');
        if (!empty($id_order)) {
            $this->db->where('id_order', $id_order);
            $order = $this->db->get('order')->row('status');
            if ($order=="Selesai" || $order=="Dibatalkan") {
                $this->db->where('id_order', $id_order);
                $Delete = $this->db->delete('order');
                if ($Delete) {
                    // delete berhasil
                    $this->db->where('id_order', $id_order);
                    $this->db->delete('order_detail');
                    $response["error"] = FALSE;
                    $this->response($response);
                } else {
                    $response["error"] = TRUE;
                    $response["error_msg"] = "Gagal Menghapus order";
                    $this->response($response);
                }
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Maaf Tidak Dapat Menghapus Pesanan";
                $this->response($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "id_order kosong";
            $this->response($response);
        }
        
    }

    public function buatpesanan_post()
    {
        // json response array
        $response = array("error" => FALSE);
        // menerima parameter POST ( nama, email, password )
        $id_user = $this->post('id_user');
        $nama = $this->post('nama');
        $mobile = $this->post('mobile');
        $alamat = $this->post('alamat');
        $pesan = $this->post('pesan');
        $qty = $this->post('jumlah');
        $harga = $this->post('harga');
        $jarak = $this->post('jarak');
        $ongkos = $this->post('ongkos');
        $metode = $this->post('metode');
        $total_bayar = $this->post('total_bayar');

        if (!empty($id_user)) {
            $kodeOrder = $this->kodeOrder($id_user);
            date_default_timezone_set('Asia/Shanghai');
            $waktu = time();
            $data = array(
                'id_order' => $kodeOrder,
                'id_user' => $id_user,
                'nama' => $nama,
                'no_hp' => $mobile,
                'alamat' => $alamat,
                'pesan' => $pesan,
                'jumlah' => $qty,
                'harga' => $harga,
                'jarak' => $jarak,
                'ongkos' => $ongkos,
                'metode' => $metode,
                'total_bayar' => $total_bayar,
                'waktu' => $waktu,
                'status' => "Menunggu",
                'pembayaran' => "Belum Lunas"
                );
            $result = $this->db->insert('order',$data);
            if ($result) {
                // tambah pesanan berhasil
                $order_detail = $this->db->get_where('cart',['id_user' => $id_user])->result_array();
                $data2 = array();
                $index = 0;
                foreach ($order_detail as $cart) {
                    array_push($data2, array(
                        'id_order' => $kodeOrder,
                        'id_user' => $id_user,
                        'id_menu' => $cart['id_menu'],
                        'nama' => $cart['nama'],
                        'qty' => $cart['qty'],
                        'harga' => $cart['harga'],
                        'gambar' => $cart['gambar']
                    ));
                    $index++;
                }
                $result2 = $this->db->insert_batch('order_detail',$data2);
                if ($result2) {
                    $this->db->where('id_user', $id_user);
                    $Delete = $this->db->delete('cart');

                    require APPPATH . 'views/vendor/autoload.php';

                    $options = array(
                        'cluster' => 'ap1',
                        'useTLS' => true
                    );
                    $pusher = new Pusher\Pusher(
                        '75eaeb008359f0e16ae9',
                        '579bd959a31653039dac',
                        '1080607',
                        $options
                    );

                    $data['message'] = 'paket2';
                    $pusher->trigger('pesanan', 'my-event', $data);
                }
                $response["error"] = FALSE;
                $this->response($response);
            } else {
                // gagal menyimpan user
                $response["error"] = TRUE;
                $response["error_msg"] = "Gagal Membuat Pesanan";
    
                $this->response($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Masih ada data yang kosong";
    
            $this->response($response);
        }
        
    }

    public function order_get()
    {
        // json response array
        $response = array("error" => FALSE);
        //menerima parameter get
        $id_user = $this->get('id_user');
        if (!empty($id_user)) {
            $this->db->order_by('waktu', 'DESC');
            $this->db->where('id_user', $id_user);
            $stmt = $this->db->get('order');
            
            if (($stmt->num_rows()) > 0) {
                // user ada
                $response["error"] = FALSE;
                $response["order"] = $stmt->result();
                $this->response($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Maaf Belum Ada Pesanan yang dibuat";
                $this->response($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "id_user kosong";
            $this->response($response);
        }
        
    }

    public function orderbyid_get()
    {
        // json response array
        $response = array("error" => FALSE);
        //menerima parameter get
        $id_order = $this->get('id_order');
        if (!empty($id_order)) {
            $this->db->where('id_order', $id_order);
            $stmt = $this->db->get('order');
            $stmt2 = $this->db->get_where('order_detail',['id_order'=>$id_order]);
            if (($stmt->num_rows()) > 0 && ($stmt2->num_rows()) > 0) {
                // user ada
                $response["error"] = FALSE;
                $response["order"] = $stmt->result();
                $response["order_detail"] = $stmt2->result();
                $this->response($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Maaf Belum Ada Pesanan yang dibuat";
                $this->response($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "id_user kosong";
            $this->response($response);
        }
        
    }

    public function updatestruk_post()
    {
        // json response array
        $response = array("error" => FALSE);
        // menerima parameter POST ( nama, email, password )
        $id_order = $this->post('id_order');
        $image = base64_decode($this->post('image'));

        if (!empty($id_order) && !empty($image)) {
            $image_name = md5(uniqid(rand(), true));
            //rename file name with random number
            $filename = $image_name . '.' . 'png';
            //image uploading folder path
            $path = "Image/Struk/".$filename;
            // image is bind and upload to respective folde
            file_put_contents($path, $image);
            
            $data = array('gambar' => $filename);

            $this->db->where('id_order', $id_order);
            $update = $this->db->update('order',$data);
            if ($update) {
                // simpan cart berhasil

                require APPPATH . 'views/vendor/autoload.php';

                    $options = array(
                        'cluster' => 'ap1',
                        'useTLS' => true
                    );
                    $pusher = new Pusher\Pusher(
                        '75eaeb008359f0e16ae9',
                        '579bd959a31653039dac',
                        '1080607',
                        $options
                    );

                    $data['message'] = $id_order;
                    $pusher->trigger('pesanan', 'my-event', $data);
                    
                $response["error"] = FALSE;
                $this->response($response);
            } else {
                // gagal menyimpan user
                $response["error"] = TRUE;
                $response["error_msg"] = "Gagal Upload Bukti Transaksi";
    
                $this->response($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Masih ada data yang kosong";
    
            $this->response($response);
        }
        
    }

    public function kodeOrder($id_user)
    {   
        $a = 0;
        $kode = substr($id_user,4);
        do {
            date_default_timezone_set('Asia/Shanghai');
            $random = 'PSN'.$kode.time();
            $this->db->where('id_order', $random);
            $stmt = $this->db->get('order');
            if ($stmt->num_rows() <> 0) {
                $a = 0;
            }else {
                $a = 1;
            }
        } while ($a < 1);
        return $random;
    }

}
?>