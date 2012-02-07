<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class main extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
	
	function get($table=NULL) 
	{
        $query = $this->db->get($table);
        return $query->result();
	}
	
    function get_one($table=NULL, $where=NULL)
    {
    	if($where) { $this->db->where($where); }
        $query = $this->db->get($table);
        return $query->row();
    }

	function get_orderby($table=NULL, $orderby=NULL, $where=NULL)

	{
		if($where) { $this->db->where($where); }
		$this->db->order_by($orderby);
        $query = $this->db->get($table);
        return $query->result();
	}
	
	function get_where($table=NULL, $where=NULL)
	{
		if($where) { $this->db->where($where); }
        $query = $this->db->get($table);
        return $query->result();
	}
	
	function get_where_limit($table=NULL, $where=NULL, $limit=NULL) 
	{
		if($where) { $this->db->where($where); }
		if($limit) { $this->db->limit($limit); }
		
        $query = $this->db->get($table);
        return $query->result();
	}
	
}
