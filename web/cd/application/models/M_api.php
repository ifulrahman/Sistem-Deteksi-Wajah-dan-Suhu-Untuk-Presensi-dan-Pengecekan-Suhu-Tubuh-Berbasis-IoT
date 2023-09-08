<?php
class M_api extends CI_Model {
        
	function getmode($iddev){
		$query = $this->db->where('id_devices',$iddev);
        $q = $this->db->get('devices');
        $data = $q->result();
        
        return $data;
	}

	function getkey(){
		$query = $this->db->where('id_key',1);
        $q = $this->db->get('secret_key');
        $data = $q->result();
        
        return $data;
	}

	function getdevice($iddev){
		$query = $this->db->where('id_devices',$iddev);
        $q = $this->db->get('devices');
        $data = $q->result();
        
        return $data;
	}


	function insert_histori($data){
		$this->db->insert('histori', $data);
       return TRUE;
	}


	function waktuoperasional(){
        $this->db->select('*');
        $this->db->from('waktu_operasional');
        $this->db->limit(3);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function insert_absensi($data){
		$this->db->insert('absensi', $data);
       return TRUE;
	}


	function get_absensi($ket,$today,$tomorrow){
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->where("keterangan", $ket);
        $this->db->where("absensi_masuk >=", $today);
        $this->db->where("absensi_masuk <", $tomorrow);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }


    function update_absensi($id_absensi, $data){
        $this->db->where('id_absensi', $id_absensi);
        $this->db->update('absensi', $data);

        return TRUE;
    }

    function getFIDdelete_by_iddev($iddev){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where("id_devices", $iddev);
        $this->db->where("del_face_id", 1);
        $this->db->order_by('face_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getFIDdelete_by_iddev_face_id($iddev, $face_id){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where("id_devices", $iddev);
        $this->db->where("face_id", $face_id);
        $this->db->order_by('face_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function del_face_by_id_face_table($id){
        $this->db->where('id_face_table', $id);
        $this->db->delete('face');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function del_histori_by_id_face_table($id){
        $this->db->where('id_face_table', $id);
        $this->db->delete('histori');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }


    function del_absensi_by_id_face_table($id_face_table){
        $this->db->where('id_face_table', $id_face_table);
        $this->db->delete('absensi');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function getFIDadd($iddev){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where("id_devices", $iddev);
        $this->db->where("add_face_id", 1);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function update_add_face_id($id, $data){
        $this->db->where('id_face_table', $id);
        $this->db->update('face', $data);

        return TRUE;
    }

    function checkface($iddev, $face_id){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where("id_devices", $iddev);
        $this->db->where("face_id", $face_id);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getFIDbyIDdev($iddev){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where("id_devices", $iddev);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function checkuid($iddev, $uid){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where("id_devices", $iddev);
        $this->db->where("uid", $uid);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getSetRFID(){
        $this->db->select('*');
        $this->db->from('set_rfid');
        $this->db->where("id_set", 1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function updateSetRFID($data){
        $this->db->where('id_set', 1);
        $this->db->update('set_rfid', $data);

        return TRUE;
    }

}

?>