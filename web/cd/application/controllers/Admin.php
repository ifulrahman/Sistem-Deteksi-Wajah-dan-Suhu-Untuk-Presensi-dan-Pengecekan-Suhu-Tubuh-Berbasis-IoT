<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_admin');
        $this->load->model('m_api');
        $this->load->library('bcrypt');
        date_default_timezone_set("Asia/Jakarta");
    }

	
	public function index()
	{
		redirect(base_url().'admin/dashboard');
	}

	public function dashboard(){
		$data['set'] = "dashboard";
		$data['face'] = $this->m_admin->get_face_all();
		$data['devices'] = $this->m_admin->get_devices();

		$today = strtotime("today");
		$tomorrow = strtotime("tomorrow");

		$data['absensi'] = $this->m_admin->get_absensi($today,$tomorrow);

		$this->load->view('v_dashboard', $data);
	}

	public function list_users(){
		$data['set'] = "list-users";
		$data['data'] = $this->m_admin->get_users();
		$this->load->view('v_users', $data);
	}

	public function add_users(){
		$data['set'] = "add-users";
		$this->load->view('v_users', $data);
	}


	public function save_users(){
		if($this->session->userdata('userlogin')){
			$users = $this->input->post('users');
			$email = $this->input->post('email');
			$username = $this->input->post('username');
			$pass = $this->input->post('pass');
			$hash = $this->bcrypt->hash_password($pass);

	        $type = explode('.', $_FILES["image"]["name"]);
			$type = strtolower($type[count($type)-1]);
			$imgname = uniqid(rand()).'.'.$type;
			$url = "components/dist/img/".$imgname;
			if(in_array($type, array("jpg", "jpeg", "gif", "png"))){
				if(is_uploaded_file($_FILES["image"]["tmp_name"])){
					if(move_uploaded_file($_FILES["image"]["tmp_name"],$url)){
						$data = array(
				                'nama'    => $users,
				                'email'   => $email,
				                'username'=> $username,
				                'password'=> $hash,
				                'avatar'  => $imgname,
				        );
						$this->m_admin->insert_users($data);
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di simpan</div>");
					}
				}
			}else{
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di simpan, ekstensi gambar salah</div>");
			}
	        
			redirect(base_url().'admin/list_users');
		}
	}

	
	public function hapus_users($id=null){
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{ 
			$path = "";
			$filename = $this->m_admin->get_user_byid($id);
			foreach ($filename as $key) {
				$file = $key->avatar;
				$path = "components/dist/img/".$file;
			}
			
			//echo $path;

			if(file_exists($path)){
				unlink($path);
				if($this->m_admin->users_del($id)){
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di hapus</div>");
				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di hapus</div>");
				}
			}else{
				if($this->m_admin->users_del($id)){
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di hapus image gagal dihapus</div>");
				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di hapus</div>");
				}
			}

			redirect(base_url().'admin/list_users');
		}
	}


	public function edit_users($id=null){
		if($this->session->userdata('userlogin')){     // mencegah akses langsung tanpa login
			if (isset($id)) {
				$user = $this->m_admin->get_user_byid($id);
				foreach ($user as $key => $value) {
					//print_r($value);
					$data['id'] = $id;
					$data['nama'] = $value->nama;
					$data['email'] = $value->email;
					$data['username'] = $value->username;
					$data['password'] = $value->password;
					$data['avatar'] = $value->avatar;
				}
				$data['set'] = "edit-users";
				$this->load->view('v_users', $data);

			}else{
				redirect(base_url().'admin/list_users');
			}
		}
	}

	public function save_edit_users(){
		if($this->session->userdata('userlogin')){     // mencegah akses langsung tanpa login
			if (isset($_POST['id']) && isset($_POST['email'])) {
				$id = $this->input->post('id');
				$email = $this->input->post('email');
				$nama = $this->input->post('users');
				$username = $this->input->post('username');
				$pass = $this->input->post('pass');
				$hash = $this->bcrypt->hash_password($pass);


				$type = explode('.', $_FILES["image"]["name"]);
				$type = strtolower($type[count($type)-1]);
				$imgname = uniqid(rand()).'.'.$type;
				$url = "components/dist/img/".$imgname;
				if(in_array($type, array("jpg", "jpeg", "gif", "png"))){
					if(is_uploaded_file($_FILES["image"]["tmp_name"])){
						if(move_uploaded_file($_FILES["image"]["tmp_name"],$url)){
							$data = array(
					                'nama'    => $users,
					                'email'   => $email,
					                'username'=> $username,
					                'avatar'  => $imgname,
					        );
					        $file = $this->input->post('img');
							$path = "components/dist/img/".$file;

							if(file_exists($path)){
								unlink($path);
							}
							$this->m_admin->updateUser($id, $data);
							$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di simpan</div>");
						}
					}
				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di simpan, ekstensi gambar salah</div>");
				}

				if(isset($_POST['changepass'])){
					$data = array(		'email' => $email,
										'nama' => $nama,
										'username'=> $username,
						                'password'=> $hash,
				 				);
					if ($this->m_admin->updateUser($id,$data)) {
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di update</div>");
					}else{
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di update</div>");
					}
				}else{
					$data = array(		'email' => $email,
										'nama' => $nama,
										'username'=> $username,
				 				);
					if ($this->m_admin->updateUser($id,$data)) {
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di update</div>");
					}else{
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di update</div>");
					}				
				}

				redirect(base_url().'admin/list_users');
			}
		}
	}


	public function devices(){
		$data['set'] = "devices";
		$data['devices'] = $this->m_admin->get_devices();

		$this->load->view('v_devices', $data);
	}

	public function add_devices(){
		$data['set'] = "add-devices";
		$this->load->view('v_devices', $data);
	}

	public function save_devices(){
		if($this->session->userdata('userlogin')){
			$id = $this->input->post('id');
			$nama = $this->input->post('nama');

			//$duplicate = $this->m_admin->get_devices_byid_row($id);
			//$hasil = count($duplicate);


			if (false) {
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> ID Alat sudah terdaftar, ganti ID Alat</div>");
			}else{
				$data = array(
		                'nama_devices'  => $nama, 'mode'  => 'SCAN',
		        );
							
				if($this->m_admin->insert_devices($data)){
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di simpan</div>");

				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di simpan</div>");
				}
			}
	        
			redirect(base_url().'admin/devices');
		}
	}

	public function hapus_devices($id=null){
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{ 
			if($this->m_admin->devices_del($id)){
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di hapus</div>");
				$this->m_admin->del_face_by_iddev($id);
				$this->m_admin->del_absensi_by_iddev($id);
			}else{
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di hapus</div>");
			}
			
			redirect(base_url().'admin/devices');
		}
	}

	public function edit_devices($id=null){
		if($this->session->userdata('userlogin')){     // mencegah akses langsung tanpa login
			if (isset($id)) {
				
				$devices = $this->m_admin->get_devices_byid($id);
				if (isset($devices)) {
					foreach ($devices as $key => $value) {
						//print_r($value);
						$data['id'] = $value->id_devices;
						$data['nama_devices'] = $value->nama_devices;
					}
					$data['set'] = "edit-devices";
					$this->load->view('v_devices', $data);
				}
				
			}else{
				redirect(base_url().'admin/devices');
			}
		}
	}

	public function edit_devices_mode($id=null){
		if($this->session->userdata('userlogin')){     // mencegah akses langsung tanpa login
			if (isset($id)) {
				
				$devices = $this->m_admin->get_devices_byid($id);
				if (isset($devices)) {
					foreach ($devices as $key => $value) {
						//print_r($value);
						$data['id'] = $value->id_devices;
						$data['mode'] = $value->mode;
					}
					$data['set'] = "edit-devices-mode";
					$this->load->view('v_devices', $data);
				}
				
			}else{
				redirect(base_url().'admin/devices');
			}
		}
	}

	public function save_edit_devices(){
		if($this->session->userdata('userlogin')){     // mencegah akses langsung tanpa login
			if (isset($_POST['id']) && isset($_POST['nama'])) {
				$id = $this->input->post('id');
				$nama = $this->input->post('nama');

				$data = array('nama_devices' => $nama,
			 				);

				if ($this->m_admin->updateDevices($id,$data)) {
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di update</div>");
				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di update</div>");
				}
				redirect(base_url().'admin/devices');
			}
		}
	}

	public function save_edit_devices_mode(){
		if($this->session->userdata('userlogin')){     // mencegah akses langsung tanpa login
			$id = $this->input->post('id');
			$mode = $this->input->post('mode');
			
			$data = array('mode' => $mode );

			if ($this->m_admin->updateDevices($id,$data)) {
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Mode berhasil di update</div>");
			}else{
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Mode gagal di update</div>");
			}
			redirect(base_url().'admin/devices');
		}
	}



	public function face_id(){
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{
			$data['set'] = "list";
			$data['face'] = $this->m_admin->get_face_all();
			$data['devices'] = $this->m_admin->get_devices();

			$this->load->view('v_face_id', $data);
		}else{
			redirect(base_url().'login');
		}
	}

	public function add_face_id(){
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{
			if (isset($_POST['face_id']) && isset($_POST['id_devices'])) {
				$face_id = $this->input->post('face_id');
				$id_devices = $this->input->post('id_devices');
				$nama = $this->input->post('nama');
				$nim = $this->input->post('nim');
				$telp = $this->input->post('telp');
				$gender = $this->input->post('gender');
				$semester = $this->input->post('semester');
				$kelas = $this->input->post('kelas');

				$checknewID = $this->m_admin->get_face_id($id_devices);

				$x = 0;
				$z = 0;
				if (isset($checknewID)) {
					foreach ($checknewID as $key => $value) {
						if ($value->add_face_id > 0) {
							$x++;
						}
						if ($value->face_id == $face_id) {
							$z++;
						}
					}
				}

				if ($x==0) {
					if ($z==0) {
						if ($face_id > 0 && $face_id < 1000) {
							$add_face = array('id_devices' => $id_devices, 'face_id' => $face_id, 'add_face_id' => 1, 'image_name' => $nama,
										'nama' => $nama, 'telp' => $telp, 'gender' => $gender, 'semester' => $semester, 'kelas' => $kelas, 'nim' => $nim);
							if ($this->m_admin->add_face_id($add_face)) {
								$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data Face ID berhasil di input</div>");
							}else{
								$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data input Face ID</div>");
							}
						}else{
							$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Face ID tidak sesuai dengan batas user</div>");
						}
					}else{
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Face ID sudah terdaftar</div>");
					}
				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Face ID baru belum tersinkron dengan Alat</div>");
				}
			}
			redirect(base_url().'admin/face_id');
		}else{
			redirect(base_url().'login');
		}
	}

	public function edit_face($id=null){
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{
			if (isset($id)) {
				$face = $this->m_admin->get_face_byid($id);
				if (isset($face)) {
					foreach ($face as $key => $value) {
						//print_r($value);
						$data['id_face_table'] = $value->id_face_table;
						$data['id_devices'] = $value->id_devices;
						$data['nama'] = $value->nama;
						$data['nim'] = $value->nim;
						$data['telp'] = $value->telp;
						$data['semester'] = $value->semester;
						$data['gender'] = $value->gender;
						$data['kelas'] = $value->kelas;
					}
					$data['set'] = "edit-face";
					$this->load->view('v_face_id', $data);
				}else{
					redirect(base_url().'admin/dashboard');
				}
			}
		}else{
			redirect(base_url().'login');
		}
	}

	public function save_edit_face(){
		if($this->session->userdata('userlogin')){     // mencegah akses langsung tanpa login
			if (isset($_POST['id_face_table']) && isset($_POST['nama'])) {
				$id = $this->input->post('id_face_table');
				$nama = $this->input->post('nama');
				$nim = $this->input->post('nim');
				$telp = $this->input->post('telp');
				$gender = $this->input->post('gender');
				$semester = $this->input->post('semester');
				$kelas = $this->input->post('kelas');

				$data = array('nama' => $nama,
								'telp' => $telp,
								'gender' => $gender,
								'semester' => $semester,
								'kelas' => $kelas,
								'nim' => $nim
			 				);
				//echo $id;
				//print_r($data);

				if ($this->m_admin->updateFace($id,$data)) {
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di update</div>");
				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di update</div>");
				}
				redirect(base_url().'admin/face_id');
			}else{
				redirect(base_url().'admin/dashboard');
			}
		}
	}

	public function hapus_face($id=null){
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{
			if (isset($id)) {
				$del_fp = array('del_face_id' => 1);
				if ($this->m_admin->del_face_id($id,$del_fp)) {
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data Face ID di hapus (menuggu respon dari Alat)</div>");
				}
			}
			redirect(base_url().'admin/face_id');
		}else{
			redirect(base_url().'login');
		}
	}

	public function absensi(){
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{
			$today = strtotime("today");
			$tomorrow = strtotime("tomorrow");

			$waktuoperasional = $this->m_admin->waktuoperasional();
			$wktmasuk = "";
			$wktkeluar = "";
			$jam_masuk = "";
			if (isset($waktuoperasional)) {
				foreach ($waktuoperasional as $key => $value) {
					if ($value->id_waktu_operasional == 1) {
						$wktmasuk = $value->waktu_operasional;
					}
					if ($value->id_waktu_operasional == 2) {
						$wktkeluar = $value->waktu_operasional;
					}
					if ($value->id_waktu_operasional == 3) {
						$jam_masuk = $value->waktu_operasional;
					}
				}
			}

			$waktumasuk = explode("-", $wktmasuk);
			$waktukeluar = explode("-", $wktkeluar);

			$waktu_masuk_1 = "";
			if (isset($waktumasuk[0])) {
				$waktu_masuk_1 = $waktumasuk[0];
			}
			$waktu_masuk_2 = "";
			if (isset($waktumasuk[1])) {
				$waktu_masuk_2 = $waktumasuk[1];
			}

			$waktu_keluar_1 = "";
			if (isset($waktukeluar[0])) {
				$waktu_keluar_1 = $waktukeluar[0];
			}
			$waktu_keluar_2 = "";
			if (isset($waktukeluar[1])) {
				$waktu_keluar_2 = $waktukeluar[1];
			}

			if (time() > strtotime($waktu_masuk_2)) {
				// check setelah waktu masuk 2 terlewati
				$face = $this->m_admin->get_face_all();
				if (isset($face)) {
					foreach ($face as $key => $value) {
						$dt = $this->m_admin->get_absensi_by_employee_today($value->id_face_table, $today);
						if (!isset($dt)) {
							$dataAbsen = array('id_devices' => $value->id_devices, 'id_face_table' => $value->id_face_table,
											'keterangan_masuk' => "Tidak Masuk", 'absensi_masuk' => time());
							$this->m_api->insert_absensi($dataAbsen);
						}
						
					}
				}
			}

			if (time() > strtotime($waktu_keluar_2)) {
				// check setelah waktu keluar 2 terlewati
				$face = $this->m_admin->get_face_all();
				if (isset($face)) {
					foreach ($face as $key => $value) {
						$dt = $this->m_admin->get_absensi_by_employee_today($value->id_face_table, $today);
						if (isset($dt)) {
							foreach ($dt as $key => $value) {
								if ($value->keterangan_masuk != "Tidak Masuk" && $value->absensi_keluar == 0){
									$dataAbsen = array('keterangan_keluar' => "Tidak Absensi Keluar");
									$this->m_api->update_absensi($value->id_absensi,$dataAbsen);
								}
							}
						}
					}
				}
			}

			$data['set'] = "absensi";

			$data['absensi'] = $this->m_admin->get_absensi($today,$tomorrow);

			$this->load->view('v_absensi', $data);
		}else{
			redirect(base_url().'login');
		}
	}

	public function lastabsensi(){
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{
			if (isset($_POST['tanggal'])) {
				$tgl = $this->input->post('tanggal');
				//echo $tgl;
				$split1 = explode("-", $tgl);
				$x = 0;
				foreach ($split1 as $key => $value) {
					$date[$x] = $value;
					$x++;
				}

				$ts1 = strtotime($date[0]);
				$ts2 = strtotime($date[1]);

				$tgl1 = date("d-M-Y",$ts1);
				$tgl2 = date("d-M-Y",$ts2);

				$ts2 += 86400;	// tambah 1 hari (hitungan detik)

				// $data['tgl1'] = $tgl1;
				// $data['tgl2'] = $tgl2;

				if ($x==2) {		
					$data['absensi'] = $this->m_admin->get_absensi($ts1,$ts2);
					$data['tanggal'] = $tgl1 . " - " . $tgl2;
					$data['waktuabsensi'] = $tgl1 . "_" . $tgl2;

					$data['set'] = "last-absensi";
					$this->load->view('v_absensi', $data);
				}else{
					redirect(base_url().'admin/absensi');
				}				
			}else{
				redirect(base_url().'admin/absensi');
			}
		}
	}


	public function export2excel(){
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{
			if (isset($_GET['tanggal'])) {
				$tanggal = $this->input->get('tanggal');
				//echo $tanggal;

				$split = explode("_", $tanggal);
				$x = 0;
				foreach ($split as $key => $value) {
					$date[$x] = $value;
					$x++;
				}

				$ts1 = strtotime($date[0]);
				$ts2 = strtotime($date[1]);

				$ts2 += 86400;	// tambah 1 hari (hitungan detik)

				$dataAbsen = $this->m_admin->get_absensi($ts1,$ts2);

				$spreadsheet = new Spreadsheet;

				$baris = 1;

				$spreadsheet->setActiveSheetIndex(0)
				          ->setCellValue('A1', 'No')
				          ->setCellValue('B1', 'Nama')
				          ->setCellValue('C1', 'Kelas')
				          ->setCellValue('D1', 'Absensi Masuk')
				          ->setCellValue('E1', 'Ket Masuk')
				          ->setCellValue('F1', 'Suhu Masuk')
				          ->setCellValue('G1', 'Absensi Keluar')
				          ->setCellValue('H1', 'Ket Keluar')
				          ->setCellValue('I1', 'Suhu Keluar')
				          ->setCellValue('J1', 'Terlambat (menit)')
				          ->setCellValue('K1', 'Pulang Awal (menit)')
				          ->setCellValue('L1', 'Tanggal');

				$baris++;
				$nomor = 1;
				
				if (isset($dataAbsen)){
					foreach($dataAbsen as $values) {

						$masuk = date("H:i:s", $values->absensi_masuk);
						$keluar = date("H:i:s", $values->absensi_keluar);
						$tgl = date("d M Y", $values->absensi_masuk);

						$spreadsheet->setActiveSheetIndex(0)
								   ->setCellValue('A' . $baris, $nomor)
								   ->setCellValue('B' . $baris, $values->nama)
								   ->setCellValue('C' . $baris, $values->kelas)
								   ->setCellValue('D' . $baris, $masuk)
								   ->setCellValue('E' . $baris, $values->keterangan_masuk)
								   ->setCellValue('F' . $baris, $values->suhu_masuk."C")
								   ->setCellValue('G' . $baris, $keluar)
								   ->setCellValue('H' . $baris, $values->keterangan_keluar)
								   ->setCellValue('I' . $baris, $values->suhu_keluar."C")
								   ->setCellValue('J' . $baris, $values->keterlambatan)
								   ->setCellValue('K' . $baris, $values->pulang_awal)
								   ->setCellValue('L' . $baris, $tgl);

					   $baris++;
					   $nomor++;

					}
				}
				
				$writer = new Xlsx($spreadsheet);

				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="Absensi_'.$tanggal.'.xlsx"');
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
			}else{
				redirect(base_url().'admin/absensi');
			}
		}
				
     }
	
	public function setting()
	{
		if($this->session->userdata('userlogin'))     // mencegah akses langsung tanpa login
		{
			$data['set'] = "setting";
			$data['key'] = $this->m_admin->getkey();
			$data['waktuoperasional'] = $this->m_admin->waktuoperasional();
			$data['telegram'] = $this->m_admin->telegram();
			//print_r($data);
			$this->load->view('v_setting', $data);
		}else{
			redirect(base_url().'login');
		}
	}

	public function set_telegram(){
		if($this->session->userdata('userlogin')){     // mencegah akses langsung tanpa login
			if (isset($_POST['token']) && isset($_POST['idchat'])) {
				$token = $this->input->post('token');
				$idchat = $this->input->post('idchat');

				$dataarray = array('token' => $token, 'chat_id' => $idchat);

				if ($this->m_admin->updateTelegram(1,$dataarray)) {
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di update</div>");
				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di update</div>");
				}

				redirect(base_url().'admin/setting');
			}
		}else{
			redirect(base_url().'admin');
		}
	}

	public function setwaktuoperasional(){
		if($this->session->userdata('userlogin')){     // mencegah akses langsung tanpa login
			if (isset($_POST['waktu_masuk_1']) && isset($_POST['waktu_masuk_2']) && isset($_POST['waktu_keluar_1']) && isset($_POST['waktu_keluar_2']) && isset($_POST['jam_masuk'])) {
				$waktu_masuk_1 = $this->input->post('waktu_masuk_1');
				$waktu_masuk_2 = $this->input->post('waktu_masuk_2');
				$waktu_keluar_1 = $this->input->post('waktu_keluar_1');
				$waktu_keluar_2 = $this->input->post('waktu_keluar_2');
				$jam_masuk = $this->input->post('jam_masuk');

				if (strlen($waktu_masuk_1) == 5 && strlen($waktu_masuk_2) == 5 && strlen($waktu_keluar_1) == 5 && strlen($waktu_keluar_2) == 5 && strlen($jam_masuk) == 5){
					$datamasuk = array('waktu_operasional' => $waktu_masuk_1."-".$waktu_masuk_2);
					$datakeluar = array('waktu_operasional' => $waktu_keluar_1."-".$waktu_keluar_2);
					$datajammasuk = array('waktu_operasional' => $jam_masuk);

					if (strtotime($jam_masuk) >= strtotime($waktu_masuk_1) && strtotime($jam_masuk) <= strtotime($waktu_masuk_2)) {
						if ($this->m_admin->updateWaktuOperasional(1,$datamasuk)) {
							$this->m_admin->updateWaktuOperasional(2,$datakeluar);
							$this->m_admin->updateWaktuOperasional(3,$datajammasuk);
							$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di update</div>");
						}else{
							$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di update</div>");
						}
					}else{
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Salah format waktu, Jam Masuk harus diantara Waktu Masuk 1 dan Waktu Masuk 2</div>");
					}
				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Salah format waktu, contoh 07:00</div>");
				}
				redirect(base_url().'admin/setting');
			}
		}else{
			redirect(base_url().'login');
		}
	}
	
}