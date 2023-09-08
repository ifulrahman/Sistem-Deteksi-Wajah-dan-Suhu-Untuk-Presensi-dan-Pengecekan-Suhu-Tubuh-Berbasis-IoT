<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_admin');
        $this->load->model('m_api');
        date_default_timezone_set("Asia/Jakarta");
    }

	public function index()
	{
		$notif = array('status' => 'test', 'ket' => 'REST API for Device');
		echo json_encode($notif);
	}

	public function getmode(){
		if (isset($_POST['key']) && isset($_POST['iddev'])) {
			$key = $this->input->post('key');
			$cekkey = $this->m_api->getkey();

			if($cekkey[0]->key == $key){
				$iddev = $this->input->post('iddev');

				$data = $this->m_api->getmode($iddev);
				if (isset($data)) {
					$mode = "-";
					foreach ($data as $key => $value) {
						$mode = $value->mode;
					}
					if ($mode == "-") {
						$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
						echo json_encode($notif);
					}else{
						if ($mode == "DEL") {
							$face_id = 0;
							$id_face_table = 0;
							$nama = "";
							$del = $this->m_api->getFIDdelete_by_iddev($iddev);
							if (isset($del)) {
								foreach ($del as $key => $value) {
									$face_id = $value->face_id;
									$id_face_table = $value->id_face_table;
									$nama = $value->nama;
								}
							}
							if ($face_id > 0) {
								$notif = array('status' => $mode, 'ket' => 'Hapus Face ID', 'nama' => $nama, 'face_id' => $face_id);
								echo json_encode($notif);
								//$this->m_api->del_face_by_id_face_table($id_face_table);
							}else{
								$notif = array('status' => '-', 'ket' => '-');
								echo json_encode($notif);
							}
						}
						else if ($mode == "ADD") {
							$face_id = 0;
							$id_face_table = 0;
							$nama = "";
							$add = $this->m_api->getFIDadd($iddev);
							if (isset($add)) {
								foreach ($add as $key => $value) {
									$face_id = $value->face_id;
									$id_face_table = $value->id_face_table;
									$nama = $value->nama;
								}
							}
							if ($face_id > 0) {
								$notif = array('status' => $mode, 'ket' => 'Tambah Face ID', 'nama' => $nama, 'face_id' => $face_id);
								echo json_encode($notif);
								//$dataadd = array('add_face_id' => 0, );
								//$this->m_api->update_add_face_id($id_face_table, $dataadd);
							}else{
								$notif = array('status' => '-', 'ket' => '-');
								echo json_encode($notif);
							}
						}
						else{
							$notif = array('status' => "SCAN", 'ket' => 'SCAN Face ID');
							echo json_encode($notif);
						}
					}
				}else{
					$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
					echo json_encode($notif);
				}
			}else{
				$notif = array('status' => 'error', 'ket' => 'salah secret key');
				echo json_encode($notif);
			}
		}else{
			$notif = array('status' => 'error', 'ket' => 'salah parameter');
			echo json_encode($notif);
		}
	}

	public function addfaceid(){
		if (isset($_POST['key']) && isset($_POST['iddev'])) {
			$key = $this->input->post('key');
			$cekkey = $this->m_api->getkey();

			if($cekkey[0]->key == $key){
				$iddev = $this->input->post('iddev');

				$data = $this->m_api->getmode($iddev);
				if (isset($data)) {
					$mode = "ADD";
					$c = 0;
					foreach ($data as $key => $value) {
						$c++;
					}
					if ($c == 0) {
						$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
						echo json_encode($notif);
					}else{
						if ($mode == "ADD") {
							$face_id = 0;
							$id_face_table = 0;
							$nama = "";
							$image_name = "";

							$add = $this->m_api->getFIDadd($iddev);
							if (isset($add)) {
								foreach ($add as $key => $value) {
									$face_id = $value->face_id;
									$id_face_table = $value->id_face_table;
									$nama = $value->nama;
									$image_name = $value->image_name;
								}
							}
							if ($face_id > 0) {
								$notif = array('status' => $mode, 'ket' => 'Tambah Face ID', 'nama' => $nama, 'face_id' => $face_id, 'image' => $image_name);
								echo json_encode($notif);
							}else{
								$notif = array('status' => '-', 'ket' => '-');
								echo json_encode($notif);
							}
						}
					}
				}else{
					$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
					echo json_encode($notif);
				}
			}else{
				$notif = array('status' => 'error', 'ket' => 'salah secret key');
				echo json_encode($notif);
			}
		}else{
			$notif = array('status' => 'error', 'ket' => 'salah parameter');
			echo json_encode($notif);
		}
	}

	public function delfaceid(){
		if (isset($_POST['key']) && isset($_POST['iddev'])) {
			$key = $this->input->post('key');
			$cekkey = $this->m_api->getkey();

			if($cekkey[0]->key == $key){
				$iddev = $this->input->post('iddev');

				$data = $this->m_api->getmode($iddev);
				if (isset($data)) {
					$mode = "DEL";
					$c = 0;
					foreach ($data as $key => $value) {
						$c++;
					}
					if ($c == 0) {
						$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
						echo json_encode($notif);
					}else{
						if ($mode == "DEL") {
							$face_id = 0;
							$id_face_table = 0;
							$nama = "";
							$image_name = "";
							$del = $this->m_api->getFIDdelete_by_iddev($iddev);
							if (isset($del)) {
								foreach ($del as $key => $value) {
									$face_id = $value->face_id;
									$id_face_table = $value->id_face_table;
									$nama = $value->nama;
									$image_name = $value->image_name;
								}
							}
							if ($face_id > 0) {
								$notif = array('status' => $mode, 'ket' => 'Hapus Face ID', 'nama' => $nama, 'face_id' => $face_id, 'image' => $image_name);
								echo json_encode($notif);
							}else{
								$notif = array('status' => '-', 'ket' => '-');
								echo json_encode($notif);
							}
						}
					}
				}else{
					$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
					echo json_encode($notif);
				}
			}else{
				$notif = array('status' => 'error', 'ket' => 'salah secret key');
				echo json_encode($notif);
			}
		}else{
			$notif = array('status' => 'error', 'ket' => 'salah parameter');
			echo json_encode($notif);
		}
	}

	public function confirm(){
		$c = 0;
		if (isset($_POST['confirm_add']) && isset($_POST['iddev']) && isset($_POST['key'])) {
			$key = $this->input->post('key');
			$cekkey = $this->m_api->getkey();

			if($cekkey[0]->key == $key){
				$iddev = $this->input->post('iddev');

				$device = $this->m_api->getdevice($iddev);
				$count = 0;

				foreach ($device as $key => $value) {
					$count++;
				}

				if ($count > 0) {
					$id = $this->input->post('confirm_add');
					$add = $this->m_api->getFIDadd($iddev);

					$face_id = 0;
					$id_face_table = 0;
					$nama = "";

					if (isset($add)) {
						foreach ($add as $key => $value) {
							$face_id = $value->face_id;
							$id_face_table = $value->id_face_table;
							$nama = $value->nama;
						}
					}
					if ($face_id == $id) {
						$dataadd = array('add_face_id' => 0, );
						$this->m_api->update_add_face_id($id_face_table, $dataadd);
						$notif = array('status' => 'ADD', 'ket' => 'Confirm ADD Face ID', 'nama' => $nama, 'face_id' => $face_id);
						echo json_encode($notif);
					}else{
						$notif = array('status' => '-', 'ket' => '-');
						echo json_encode($notif);
					}
				}else{
					$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
					echo json_encode($notif);
				}
			}else{
				$notif = array('status' => 'error', 'ket' => 'salah secret key');
				echo json_encode($notif);
			}
			$c++;
		}

		if (isset($_POST['confirm_del']) && isset($_POST['iddev']) && isset($_POST['key'])) {
			$key = $this->input->post('key');
			$cekkey = $this->m_api->getkey();

			if($cekkey[0]->key == $key){
				$iddev = $this->input->post('iddev');

				$device = $this->m_api->getdevice($iddev);
				$count = 0;

				foreach ($device as $key => $value) {
					$count++;
				}

				if ($count > 0) {
					$id = $this->input->post('confirm_del');
					$del = $this->m_api->getFIDdelete_by_iddev_face_id($iddev, $id);

					$face_id = 0;
					$id_face_table = 0;
					$nama = "";

					if (isset($del)) {
						foreach ($del as $key => $value) {
							$face_id = $value->face_id;
							$id_face_table = $value->id_face_table;
							$nama = $value->nama;
						}
					}

					if ($face_id == $id) {
						$this->m_api->del_face_by_id_face_table($id_face_table);
						$this->m_api->del_absensi_by_id_face_table($id_face_table);

						$notif = array('status' => 'DEL', 'ket' => 'Confirm DEL Face ID', 'nama' => $nama, 'face_id' => $face_id);
						echo json_encode($notif);
					}else{
						$notif = array('status' => '-', 'ket' => '-');
						echo json_encode($notif);
					}
				}else{
					$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
					echo json_encode($notif);
				}
			}else{
				$notif = array('status' => 'error', 'ket' => 'salah secret key');
				echo json_encode($notif);
			}
			$c++;
		}

		if ($c == 0) {
			$notif = array('status' => 'error', 'ket' => 'salah parameter');
			echo json_encode($notif);
		}
	}


	public function absensi(){
		if (isset($_POST['key']) && isset($_POST['iddev']) && isset($_POST['faceid'])) {
			$key = $this->input->post('key');
			$cekkey = $this->m_api->getkey();

			if($cekkey[0]->key == $key){
				$iddev = $this->input->post('iddev');
				$faceid = $this->input->post('faceid');
				$suhu = $this->input->post('suhu');

				$cekface = $this->m_api->checkface($iddev,$faceid);
				$countface = 0;
				$face_id = 0;
				$id_face_table = 0;
				$nama = "";
				$waktux = Date("H:i:s d-M-Y",time());

				if (isset($cekface)) {
					foreach ($cekface as $key => $value) {
						$countface++;
						$face_id = $value->face_id;
						$id_face_table = $value->id_face_table;
						$nama = $value->nama;
					}
				}

				$device = $this->m_api->getdevice($iddev);
				$count = 0;
				foreach ($device as $key => $value) {
					$count++;
				}

				if ($count > 0) {
					if ($countface > 0) {
						$waktu = $this->m_api->waktuoperasional();
						if (isset($waktu)) {
							foreach ($waktu as $key => $value) {
								if ($value->id_waktu_operasional == 1) {
									$masuk = $value->waktu_operasional;
								}
								if ($value->id_waktu_operasional == 2) {
									$keluar = $value->waktu_operasional;
								}
								if ($value->id_waktu_operasional == 3) {
									$jam_masuk = $value->waktu_operasional;
								}
							}
						}else{
							$notif = array('status' => 'error', 'ket' => 'error waktu operasional');
							echo json_encode($notif);
						}
						if (isset($masuk) && isset($keluar) && isset($jam_masuk)) {
							$masuk = explode("-", $masuk);
							$keluar = explode("-", $keluar);
							if (isset($masuk[0]) && isset($masuk[1]) && isset($keluar[0]) && isset($keluar[1])) {
								$masuk1 = strtotime($masuk[0]);
								$masuk2 = strtotime($masuk[1]);
								$keluar1 = strtotime($keluar[0]);
								$keluar2 = strtotime($keluar[1]);
		

								$today = strtotime("today");
								$tomorrow = strtotime("tomorrow");

								$checkStatusAbsensi = $this->m_admin->get_absensi_by_employee_today($id_face_table,$today);

								$id_absensi = 0;
								$flag_absensi = "";
								$absensi_keluar = 0;
								if (isset($checkStatusAbsensi)) {
									foreach ($checkStatusAbsensi as $key => $value) {
										$id_absensi = $value->id_absensi;
										$flag_absensi = $value->keterangan_masuk;
										$absensi_keluar = $value->absensi_keluar;
									}
								}

								if ($id_absensi == 0) {
									$TypeAbsensi = "masuk";

									if (time() < $masuk1) {
										// waktu kurang dr jam yang di tetapkan
										$notif = array('status' => 'error', 'ket' => 'Diluar waktu masuk');
										echo json_encode($notif);
									}else if (time() >= $masuk1 && time() <= strtotime($jam_masuk)) {
										// absensi masuk
										$ket = "Masuk";
										$data = array('id_devices' => $iddev, 'id_face_table' => $id_face_table,
														'keterangan_masuk' => $ket, 'absensi_masuk' => time(), 'flag_masuk' => 'Absensi Face', 'suhu_masuk' => $suhu);
										if ($this->m_api->insert_absensi($data)) {
											$notif = array('status' => 'success', 'ket' => $ket, 'nama' => $nama, 'waktu' => $waktux);
											echo json_encode($notif);
											$this->send_telegram("ABSENSI MASUK\n\nTgl/jam : ".$waktux."\nNama : ".$nama);
										}else{
											$notif = array('status' => 'error', 'ket' => 'gagal insert absensi');
											echo json_encode($notif);
										}
									}else if (time() >= strtotime($jam_masuk) && time() <= $masuk2) {
										// absensi masuk telat
										$ket = "Masuk Terlambat";
										$telat = intval((time() - strtotime($jam_masuk)) / 60);
										$data = array('id_devices' => $iddev, 'id_face_table' => $id_face_table,
														'keterangan_masuk' => $ket, 'absensi_masuk' => time(), 'flag_masuk' => 'Absensi Face', 'keterlambatan' => $telat, 'suhu_masuk' => $suhu);
										if ($this->m_api->insert_absensi($data)) {
											$notif = array('status' => 'success', 'ket' => $ket, 'nama' => $nama, 'waktu' => $waktux);
											echo json_encode($notif);
											$this->send_telegram("ABSENSI MASUK\n\nTgl/jam : ".$waktux."\nNama : ".$nama);
										}else{
											$notif = array('status' => 'error', 'ket' => 'gagal insert absensi');
											echo json_encode($notif);
										}
									}else if (time() > $masuk2) {
										// tidak bisa absensi masuk
										$notif = array('status' => 'error', 'ket' => 'Tidak Bisa Absensi Masuk');
										echo json_encode($notif);
									}else{
										$notif = array('status' => 'error', 'ket' => 'error');
										echo json_encode($notif);
									}
								}else{
									if ($flag_absensi == "Tidak Masuk") {
										$notif = array('status' => 'error', 'ket' => 'Tidak Masuk Kerja');
										echo json_encode($notif);
									}else{
										$TypeAbsensi = "keluar";

										if (time() > $masuk2) {
											if (time() < $keluar1) {
												// keluar lebih awal
												if ($absensi_keluar == 0) {
													$ket = "Keluar Lebih Awal";
													$awal = intval((time() - $keluar1) / 60);
													$data = array('keterangan_keluar' => $ket, 'absensi_keluar' => time(), 'flag_keluar' => 'Absensi Face', 'pulang_awal' => $awal, 'suhu_keluar' => $suhu);
													if ($this->m_api->update_absensi($id_absensi,$data)) {
														$notif = array('status' => 'success', 'ket' => $ket, 'nama' => $nama, 'waktu' => $waktux);
														echo json_encode($notif);
														$this->send_telegram("ABSENSI KELUAR\n\nTgl/jam : ".$waktux."\nNama : ".$nama);
													}else{
														$notif = array('status' => 'error', 'ket' => 'gagal insert absensi');
														echo json_encode($notif);
													}
												}else{
													$notif = array('status' => 'error', 'ket' => 'Sudah Absen Keluar');
													echo json_encode($notif);
												}
											}else if (time() >= $keluar1 && time() <= $keluar2) {
												// absensi keluar
												if ($absensi_keluar == 0) {
													$ket = "Keluar";
													$data = array('keterangan_keluar' => $ket, 'absensi_keluar' => time(), 'flag_keluar' => 'Absensi Face', 'suhu_keluar' => $suhu);
													if ($this->m_api->update_absensi($id_absensi,$data)) {
														$notif = array('status' => 'success', 'ket' => $ket, 'nama' => $nama, 'waktu' => $waktux);
														echo json_encode($notif);
														$this->send_telegram("ABSENSI KELUAR\n\nTgl/jam : ".$waktux."\nNama : ".$nama);
													}else{
														$notif = array('status' => 'error', 'ket' => 'gagal insert absensi');
														echo json_encode($notif);
													}
												}else{
													$notif = array('status' => 'error', 'ket' => 'Sudah Absen Keluar');
													echo json_encode($notif);
												}
											}else if (time() > $keluar2) {
												// tidak bisa absensi keluar
												$notif = array('status' => 'error', 'ket' => 'Tidak Bisa Absensi Keluar');
												echo json_encode($notif);
											}else{
												$notif = array('status' => 'error', 'ket' => 'error');
												echo json_encode($notif);
											}
										}else{
											$notif = array('status' => 'error', 'ket' => 'Sudah Absen Masuk');
											echo json_encode($notif);
										}
									}
								}
							}else{
								$notif = array('status' => 'error', 'ket' => 'error format waktu');
								echo json_encode($notif);
							}
						}else{
							$notif = array('status' => 'error', 'ket' => 'error waktu');
							echo json_encode($notif);
						}
					}else{
						$notif = array('status' => 'failed', 'ket' => 'face ID tidak ada');
						echo json_encode($notif);
					}
				}else{
					$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
					echo json_encode($notif);
				}
			}else{
				$notif = array('status' => 'error', 'ket' => 'salah secret key');
				echo json_encode($notif);
			}
		}else{
			$notif = array('status' => 'error', 'ket' => 'salah parameter');
			echo json_encode($notif);
		}
	}


	public function listfaceid(){
		if (isset($_POST['key']) && isset($_POST['iddev'])){
			$key = $this->input->post('key');
			$cekkey = $this->m_api->getkey();

			if($cekkey[0]->key == $key){
				$iddev = $this->input->post('iddev');

				$device = $this->m_api->getdevice($iddev);
				$count = 0;
				foreach ($device as $key => $value) {
					$count++;
				}

				if ($count > 0) {
					$listFace = $this->m_api->getFIDbyIDdev($iddev);
					$FaceID = [];
					$namaID = [];
					$s = 0;
					if (isset($listFace)) {
						foreach ($listFace as $key => $value) {
							$FaceID[$s] = $value->face_id;
							$namaID[$s] = $value->nama;
							$s++;
						}
					}

					$dataList = array('id' => $FaceID, 'nama' => $namaID);

					echo json_encode($dataList);
				}else{
					$notif = array('status' => 'error', 'ket' => 'id device tidak terdaftar');
					echo json_encode($notif);
				}
			}else{
				$notif = array('status' => 'error', 'ket' => 'salah secret key');
				echo json_encode($notif);
			}
		}else{
			$notif = array('status' => 'error', 'ket' => 'salah parameter');
			echo json_encode($notif);
		}
	}


	private function send_telegram($pesan = null){
		if ($pesan != null){
			$data = $this->m_admin->telegram();

			$token = "";
			$chatId = "";

			//print_r($data);

			foreach ($data as $key => $value) {
				$token = $value->token;
				$chatId = $value->chat_id;
			}

			if ($token != "" && $chatId != "") {
				$path = "https://api.telegram.org/bot".$token;

				$url = $path."/sendmessage";

				$data=array('chat_id'=>$chatId,'text'=>$pesan);
				$options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
				$context=stream_context_create($options);
				$result=file_get_contents($url,false,$context);
		        
		        //print_r($result);
			}
		}
	}


	public function tes_telegram(){
		$data = $this->m_admin->telegram();

		$token = "";
		$chatId = "";

		//print_r($data);

		foreach ($data as $key => $value) {
			$token = $value->token;
			$chatId = $value->chat_id;
		}

		if ($token != "" && $chatId != "") {
			$path = "https://api.telegram.org/bot".$token;
			
			$message = "Testing Telegram Bot dari sistem absensi";

			$url = $path."/sendmessage";

			$data=array('chat_id'=>$chatId,'text'=>$message);
			$options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
			$context=stream_context_create($options);
			$result=file_get_contents($url,false,$context);
	        
	        print_r($result);
		}else{
			echo "Tokken dan ID Chat Telegram belum di isi";
		}	
	}

}
