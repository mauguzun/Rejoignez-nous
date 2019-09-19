<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Crud extends CI_Model
{



    function get_all($table,$where = null ,$order = NULL,$order_value = 'DESC',$select = NULL ,$limit = NULL,$start = 0 )
    {
        if ($where) {
            $this->db->where($where);
        }
        if ($order) {
            $this->db->order_by($order,$order_value);
        }
        if ($select) {
            $this->db->select($select);
        }

        $query = ($limit) ? $this->db->get($table,$limit,$start):
        $this->db->get($table);

        return $query->result_array();
    }
    /**
    *
    * @param array $where
    * @param string $table
    *
    * @return
    */
    function get_row($where,$table)
    {

        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    /**
    * insert new row ,pass array
    * @param array $value
    * @param string  $table
    *
    * @return int insert id ;
    */
    function add( $value, $table)
    {
        $this->db->insert($table,$value);
        return $this->db->insert_id();
    }
    /**
    *
    * @param multiarra $value
    * @param string $table
    *
    * @return
    */
    function add_many($value , $table)
    {

        foreach ($value as $one) {
            $this->add($one,$table);
        }
        // $this->db->insert_batch($table,$value);
    }

    /**
    *
    * @param string $where_column
    * @param array $where_in_array
    * @param string $table
    * @param array $where
    * @param array $order
    * @param string $select
    * @param int $limit
    * @param int $start
    *
    * @return array
    */
    function get_where_in($where_column ,$where_in_array,$table ,$where = NULL ,$order = NULL ,$select = NUll ,$limit = NULL ,$start = NULL )
    {


        $this->db->where_in($where_column, $where_in_array);

        if ($where) {
            $this->db->where($where);
        }
        if ($order) {
            $this->db->order_by(key($order),$order[key($order)]);
        }
        if ($select) {
            $this->db->select($select);
        }

        $query = ($limit) ? $this->db->get($table,$limit,$start):
        $this->db->get($table);

        return $query->result_array();
    }

    /**
    *
    * update row in db
    * @param array $where
    * @param array $data
    * @param string $table
    *
    * @return
    */
    function update( $where = NULL , $data, $table)
    {
        if ($where)
        $this->db->where($where);

        return $this->db->update($table,$data);
    }
    /**
    *
    * @param array $data
    * @param string $table
    *
    * @return
    */
    function update_or_insert($data,$table)
    {
    	
        $this->db->replace($table, $data);
    }


    /**
    *
    * @param string $id
    * @param string $column
    * @param string $table
    *
    * @return array
    */
    function get_array( $id,$column,$table)
    {
        $array = [];
        foreach ($this->Crud->get_all($table) as $row) {
            $array[$row[$id]] = $row[$column];
        }
        return $array;
    }

    /**
    *
    * @param array $where
    * @param string $table
    *
    * @return
    */
    function delete( $where,  $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    /**
    *
    * @param array $array
    * @param array|null $req
    *
    * @return
    */
    function clearArray($array,$req = NULL)
    {
        if ($array == null )
        return FALSE;

        foreach ($array as $key=>&$value) {
            $value = trim($value);
            if (is_array($req) && in_array($key,$req)) {
                if ($value == "") {
                    return FALSE;
                }

            }
        }
        return $array;
    }

    /**
    *
    * @param array $like ,'column,value'
    * @param string $table
    *
    * @return
    */
    function get_like( $like, $table ,$where = NULL )
    {
        if ($where)
        $this->db->where($where);


        $this->db->like($like);
        $query = $this->db->get($table);


        return $query->result_array();
    }


    /**
    *
    * @param string $table
    * @param arrray $tablesAndJoin
    * @param string $selectAs
    * @param array $order
    * @param string $group_by
    * @param undefined $where
    * @param undefined $limit
    * @param undefined $start
    *
    * @return
    */
    function get_joins( $table,  $tablesAndJoin ,$selectAs = "*",$order = NULL ,$group_by = NULL,$where = NULL,$limit = NULL,$start = 0)
    {



        $this->db->select($selectAs);


        foreach ($tablesAndJoin as $key=>$value) {
            $this->db->join($key, $value ,"LEFT");
        }


        if ($order)
        $this->db->order_by(key($order),$order[key($order)]);

        if ($group_by)
        $this->db->group_by($group_by);

        if ($where)
        $this->db->where($where);



        $query = ($limit) ? $this->db->get($table,$limit):  $this->db->get($table);


        return $query->result_array();
    }


    function get_joins_count( $table,  $tablesAndJoin ,$selectAs = "*",$order = NULL ,$group_by = NULL,$where = NULL,$limit = NULL,$start = 0)
    {



        $this->db->select($selectAs);


        foreach ($tablesAndJoin as $key=>$value) {
            $this->db->join($key, $value ,"LEFT");
        }


        if ($order)
        $this->db->order_by(key($order),$order[key($order)]);

        if ($group_by)
        $this->db->group_by($group_by);

        if ($where)
        $this->db->where($where);

		$temp_db = clone $this->db;
        $data = [
            'count'=>$temp_db->get($table)->num_rows(),
            'data'=> ($limit) ? $this->db->get($table,$limit,$start):  $this->db->get($table)
        ];
        $data['data'] = $data['data']->result_array();


        return $data;
    }
    /**
    *
    * @param string $table
    * @param arrray $tablesAndJoin
    * @param string $selectAs
    * @param array $order
    * @param array $group_by
    * @param string $where_column
    * @param array $where_array
    * @param undefined $limit
    * @param undefined $start
    *
    * @return
    */
    function get_joins_where_in( $table,  $tablesAndJoin ,$selectAs = "*",$order = NULL ,
        $group_by = NULL,$where_column = NULL ,$where_array = NULL,$limit = NULL,$start = 0 )
    {



        $this->db->select($selectAs);


        foreach ($tablesAndJoin as $key=>$value) {
            $this->db->join($key, $value ,"LEFT");
        }


        if ($order)
        $this->db->order_by(key($order),$order[key($order)]);

        if ($group_by)
        $this->db->group_by($group_by);

        if ($where_column && $where_column)
        $this->db->where_in($where_column , $where_array);


        $query = ($limit) ? $this->db->get($table):
        $this->db->get($table);


        return $query->result_array();
    }

}