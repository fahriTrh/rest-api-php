<?php

require_once 'koneksi.php';

class Mahasiswa
{

    // function untuk mendapatkan semua data mahasiswa
    public function get_mhss()
    {
        global $mysqli;
        $query = "SELECT * FROM tbl_mahasiswa";

        // siapkan tempat data
        $data = [];

        // lakukan query
        $result = $mysqli->query($query);

        // isi satu persatu data yang didapat ke tempat data
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }

        // buat response dengan array
        $response = [
            'status' => 1,
            'message' => 'Get List Mahasiswa Successfully',
            'data' => $data
        ];

        // tampilkan data dengan function json_encode()
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // function untuk mendapatkan satu data mahasiswa spesifik
    public function get_mhs($id = 0)
    {
        global $mysqli;
        $data = [];

        // akan  menjadi query jika tidak ada id yang dikirimkan, dan akan mendapatkan semua data
        $query = "SELECT * FROM tbl_mahasiswa";

        // jika id != 0 maka perbarui nilai query untuk hanya mendapat satu data 
        if ($id != 0) {
            $query = "SELECT * FROM tbl_mahasiswa WHERE id=$id";
        }

        // lakukan query
        $result = $mysqli->query($query);

        // isi variabel data dengan nilai yang didapat
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }

        // buat response dengan array
        $response = [
            'status' => 1,
            'message' => 'Get Mahasiswa Successfully',
            'data' => $data
        ];

        header('Content-Type: application/json');
        echo json_encode($response);

    }


    // function untuk menambahkan mahasiswa baru ke database
    public function insert_mhs()
    {
        global $mysqli;
        // array untuk memeriksa data dari $_POST
        $arr_check_post = [
            'nim' => '',
            'jk' => '',
            'alamat' => '',
            'jurusan' => ''
        ];

        // berapa banyak kunci dalam array $_POST yang juga ada dalam arr_check_post
        $hitung = count(array_intersect_key($_POST, $arr_check_post));
        
        // jika sesuai
        if ($hitung == count($arr_check_post)) {
            // buat query
            $result = mysqli_query($mysqli, "INSERT INTO tbl_mahasiswa SET
                        nim = '$_POST[nim]',
                        nama = '$_POST[nama]',
                        jk = '$_POST[jk]',
                        alamat = '$_POST[alamat]',
                        jurusan = '$_POST[jurusan]'
                    ");

            // coba untuk menjalankan query

            // jika query berhasil kembalikan response & message success
            if ($result) {
                $response = [
                    'status' => 1,
                    'message' => 'Mahasiswa Added Successfully'
                ];
            } // jika query gagal kembalikan response & message failed
                else {
                    $response = [
                        'status' => 0,
                        'message' => 'Mahasiswa Addition Failed.'
                    ];
                }

        } // jika tidak sesuai
            else {
                $response = [
                  'status' => 0,
                  'message' => 'Parameter Do Not Match'  
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response);
    }

    // function untuk megupdate data mahasiswa
    public function update_mhs($id)
    {
        global $mysqli;
        // array untuk memeriksa data $_POST
        $arr_check_post = [
            'nim' => '',
            'nama' => '',
            'jk' => '',
            'alamat' => '',
            'jurusan' => ''
        ];

        // berapa banyak kunci dalam array $_POST yang juga ada dalam arr_check_post
        $hitung = count(array_intersect_key($_POST, $arr_check_post));

        // jika sesuai
        if ($hitung == count($arr_check_post)) {
            // buat query
            $result = mysqli_query($mysqli, "UPDATE tbl_mahasiswa SET
                nim = '$_POST[nim]',
                nama = '$_POST[nama]',
                jk   = '$_POST[jk]',
                alamat = '$_POST[alamat]',
                jurusan = '$_POST[jurusan]'
                WHERE id='$id'
            ");

            // coba jalankan query
            // jika berhasil
            if ($result) {
                $response = [
                    'status' => 1,
                    'message' => 'Mahasiswa Updated Successfully' 
                ];
            } //jika gagal
            else {
                $response = [
                    'status' => 0,
                    'message' => 'Mahasiswa Updation Failded'
                ];
            }
        } // jika tidak sesuai
            else {
                $response = [
                    'status' => 0,
                    'message' => 'Parameter Do not Match'
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response);

    }

    // function untuk menghapus mahasiswa berdasarkan id
    public function delete_mhs($id)
    {
        global $mysqli;
        // buat query untuk menghapus data
        $query = "DELETE FROM tbl_mahasiswa WHERE id=".$id;

        // coba jalankan query
        // jika berhasil
        if (mysqli_query($mysqli, $query)) {
            $response = [
                'status' => 1,
                'message' => 'Mahasiswa Deleted Successfully.'
            ];
        } // jika gagal
            else {
                $response = [
                    'status' => 0,
                    'message' => 'Mahasiswa Deletion Failed.'
                ];   
            }
            header('Content-Type: application/json');
            echo json_encode($response);
    }
     
}