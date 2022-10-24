<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Mahasiswamodel', 'model');
    }

    public function index_get()
    {
        $data = $this->model->getMahasiswa();
        $this->set_response([
            'status' => TRUE,
            'code' => 200,
            'message' => 'Success',
            'data'   => $data,
        ], REST_Controller::HTTP_OK);
    }

    public function sendmail_post()
    {
        $from_email = $this->post('email');
        $this->load->library('email');
        $this->email->from('info@cloudjaa.com', 'Cloudjaa');
        $this->email->to($from_email);
        $this->email->subject('Informasi Penting dari Cloudjaa');
        $this->email->message("
            <center style='border: 4px solid #5F4EFF; border-radius: 8px;' >
                <h1 style='color: #5F4EFF;'>Selamat Datang di Cloudjaa</h1>
                <img src='https://img.freepik.com/free-vector/woman-receiving-mail-reading-letter_74855-5964.jpg?w=1060&t=st=1666582667~exp=1666583267~hmac=e20c2a15465dee8132d2867988e1e31b18f4434b318beca04270c80c5ca1b9a7'>
                <p style='font-weight: bold; font-size: 16px'>Terima kasih telah mendaftarkan diri untuk menggunakan layanan kami. Silahkan menekan tombol dibawah ini untuk melakukan verifikasi.</p>
                <button style='color: #FFFFFF; font-weight: bold; background-color: #5F4EFF; text-align : center; padding:8px;text-decoration: none;display: inline-block; font-size: 16px;'>Verifikasi</button>
                <p style=' font-weight: bold; font-size: 16px'>Kami siap melayani Anda!</p>
                <br>
            </center>
        ");

        if ($this->email->send()) {
            $this->set_response([
                'status' => TRUE,
                'code' => 200,
                'message' => 'Email informasi penting berhasil dikirim, silahkan periksa inbox email Anda!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => FALSE,
                'code' => 404,
                'message' => 'Gagal mengirimkan email informasi!'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
