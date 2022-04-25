<?php
class Custom_Query_model extends grocery_CRUD_Model {
 
    private $query_str = '';
 
    function __construct() {
        parent::__construct();
 
    }
 
    function get_list() {
        
        $query = $this->db->query($this->query_str);
 
        $results_array = $query->result();
        return $results_array;
    }
 
    public function set_custom_query($query_str) {
        $this->query_str = $query_str;
    }
 
    /* Adding this does the trick for limiting the results per page! */
    function limit($value, $offset = ''){
        $this->query_str .= ' LIMIT '.($offset ? $offset.', ' : '').$value;
    }
 
    /* This method is to count the results of your query. If you don't add this
     * the total results on 'Displaying 1 to n of x items' can be wrong, 'cause 
     * grocery will get the total amount of rows from the table */
    function get_total_results() {
        return count($this->get_list());
    }

}