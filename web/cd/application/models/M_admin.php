<?php
class M_admin extends CI_Model {

    function get_users(){
        $this->db->select('*');
        $this->db->from('user');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function insert_users($data){
       $this->db->insert('user', $data);
       return TRUE;
    }

    function users_del($id) {
        $this->db->where('id_user', $id);
        $this->db->delete('user');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }


    function updateUser($id,$data){
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);

        return TRUE;
    }

    function get_user_byid($id) {
        $query = $this->db->where('id_user',$id);
        $q = $this->db->get('user');
        $data = $q->result();
        
        return $data;
    }


    function get_devices_byid($id) {
        $query = $this->db->where('id_devices',$id);
        $q = $this->db->get('devices');
        $data = $q->result();
        
        return $data;
    }

    function get_devices(){
        $this->db->select('*');
        $this->db->from('devices');
        $this->db->order_by('id_devices', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    function insert_devices($data){
       $this->db->insert('devices', $data);
       return TRUE;
    }

    function devices_del($id) {
        $this->db->where('id_devices', $id);
        $this->db->delete('devices');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }
    
    function updateDevices($id,$data){
        $this->db->where('id_devices', $id);
        $this->db->update('devices', $data);

        return TRUE;
    }


    function empty_data(){
        $this->db->truncate('histori');
        return TRUE;
    }

    function get_face_all(){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->order_by('face_id', 'desc');
        //$this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }


    function get_face_id($id_devices){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where('id_devices',$id_devices);
        $this->db->order_by('face_id', 'desc');
        //$this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function add_face_id($data){
        $this->db->insert('face', $data);
        return TRUE;
    }

    function del_face_id($id,$data){
        $this->db->where('id_face_table', $id);
        $this->db->update('face', $data);

        return TRUE;
    }

    function get_face_byid($id){
        $query = $this->db->where('id_face_table',$id);
        $q = $this->db->get('face');
        $data = $q->result();
        
        return $data;
    }

    function updateFace($id,$data){
        $this->db->where('id_face_table', $id);
        $this->db->update('face', $data);

        return TRUE;
    }

    function del_face_by_iddev($id_devices){
        $this->db->where('id_devices', $id_devices);
        $this->db->delete('face');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function del_absensi_by_iddev($id_devices){
        $this->db->where('id_devices', $id_devices);
        $this->db->delete('absensi');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function del_histori_by_iddev($id_devices){
        $this->db->where('id_devices', $id_devices);
        $this->db->delete('histori');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function get_absensi($today,$tomorrow){
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('devices','absensi.id_devices=devices.id_devices','inner');
        $this->db->join('face','absensi.id_face_table=face.id_face_table','inner');
        $this->db->where("absensi_masuk >=", $today);
        $this->db->where("absensi_masuk <", $tomorrow);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }


    function get_history(){
        $this->db->select('*');
        $this->db->from('histori');
        $this->db->join('face', 'face.id_face_table=histori.id_face_table', 'inner');
        $this->db->join('devices', 'devices.id_devices=histori.id_devices', 'inner');
        $this->db->order_by('id_histori', 'desc');
        $this->db->limit(500);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getkey(){
        $query = $this->db->where('id_key',1);
        $q = $this->db->get('secret_key');
        $data = $q->result();
        
        return $data;
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

    function updateWaktuOperasional($id,$data){
        $this->db->where('id_waktu_operasional', $id);
        $this->db->update('waktu_operasional', $data);

        return TRUE;
    }

    function get_absensi_by_employee_today($id_face_table, $today){
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->where("id_face_table", $id_face_table);
        $this->db->where("absensi_masuk >=", $today);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function telegram(){
        $this->db->select('*');
        $this->db->from('telegram');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function updateTelegram($id,$data){
        $this->db->where('id_telegram', $id);
        $this->db->update('telegram', $data);

        return TRUE;
    }
}

?>