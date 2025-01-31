<?php

    /**
     * https://www.binaryboxtuts.com/php-tutorials/codeigniter-3-simple-crud-step-by-step-tutorial/
     */
    class Test_model extends CI_Model
    {
        private $tableName = "test";

        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Get Count All Records
         */
        public function count()
        {
            return $this->db->from($this->table_name)->count_all_results();
        }

        /**
         * Destroy or Remove a record in the database
         */
        public function delete($id)
        {
            return $this->db->delete($this->table_name, array('id' => $id));
        }

        /*
          Get an specific record from the database
        */
        public function get($id)
        {
            return $this->db->get_where($this->table_name, ['id' => $id])->row();
        }

        /*
            Get all the records from the database
        */
        public function get_all()
        {
            return $this->db->get($this->table_name)->result();
        }

        /*
            Store the record in the database
        */
        public function store($data = array())
        {
            return $result = $this->db->insert($this->table_name, $data);
        }

        /*
            Update or Modify a record in the database
        */
        public function update($id, $data = array())
        {
            return $this->db->where('id', $id)->update($this->table_name, $data);
        }

        public function call_sp($sp_name)
        {
            return $this->db->query("CALL " . $sp_name)->result();
        }
    }
