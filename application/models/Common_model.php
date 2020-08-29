<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

     public function listData($table, $where)
    {
    	$this->db->from($table);
    	$this->db->where($where);
    	return $this->db->get()->result_array();
    }
    
    public function addData($table, $data)
    {
        $this->db->insert($table, $data);
        $last_insertid = $this->db->insert_id();
        return $last_insertid;
    }
    public function updateData($table, $data, $where)
    {
        $this->db->where($where);
        $query = $this->db->update($table,$data);
        return $query;
    }
    public function deleteData($table, $where)
    {
        $this->db->where($where);
        $query = $this->db->delete($table);
        return $query;
    }
    public function whereArray($table, $array, $select = "*", $join = [], $orderBy = "", $having = "", $groupBy = "",$limit = [], $sort = 'asc') {
        $this->db->select($select);
        $this->db->from($table);
        foreach ($array as $key => $value) {
            $this->db->where($key, $value);
        }
        foreach ($join as $table => $joinWhere) {
            $this->db->join($table, $joinWhere, 'left');
        }
        if (count($limit) > 0) {
            $this->db->limit($limit['limit'], $limit['start']);
        }
        if ($orderBy) {
            $this->db->order_by($orderBy, $sort);
        }
        if ($having) {
            $this->db->having($having);
        }
        if ($groupBy) {
            $this->db->group_by($groupBy);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function whereArrayLimit($table, $array, $select = "*",$limit = [],$join = [], $orderBy = "", $having = "", $groupBy = "", $sort = 'ASC')
    {
        $this->db->select($select);
        $this->db->from($table);
        foreach ($array as $key => $value) {
            $this->db->where($key, $value);
        }
         foreach ($join as $table => $joinWhere) {
            $this->db->join($table, $joinWhere);
        }
        if (count($limit) > 0) {
            $this->db->limit($limit['limit'], $limit['start']);
        }
        if ($orderBy) {
            $this->db->order_by($orderBy, $sort);
        }
        if ($having) {
            $this->db->having($having);
        }
        if ($groupBy) {
            $this->db->group_by($groupBy);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function searchData($table, $where,$attribute, $like, $limit = '',$select = "*", $orderBy = "")
    {
        $this->db->select($select);
        $this->db->from($table);
        foreach ($where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->like($attribute,$like);
        
        if(!empty($limit)){
            $this->db->limit($limit);    
        }
        
        if ($orderBy) {
            $this->db->order_by($orderBy, 'ASC');
        }
        
        $query = $this->db->get()->result_array();
        return $query;
    }
}