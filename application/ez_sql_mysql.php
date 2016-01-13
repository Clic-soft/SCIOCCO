<?php

$ezsql_mysql_str = array
    (1 => 'Require $dbuser and $dbpassword to connect to a database server', 2 => 'Error establishing mySQL database connection. Correct user/password? Correct hostname? Database server running?', 3 => 'Require $dbname to select a database', 4 => 'mySQL database connection is not active', 5 => 'Unexpected error while trying to select database');
if (!function_exists('mysql_connect'))
    die('<b>Fatal Error:</b> ezSQL_mysql requires mySQL Lib to be compiled and or linked in to the PHP engine');if (!class_exists('ezSQLcore'))
    die('<b>Fatal Error:</b> ezSQL_mysql requires ezSQLcore (ez_sql_core.php) to be included/loaded before it can be used')

    

;class ezSQL_mysql extends ezSQLcore {

    var $dbuser = false;
    var $dbpassword = false;
    var $dbname = false;
    var $dbhost = false;

    function ezSQL_mysql($dbuser = '', $dbpassword = '', $dbname = '', $dbhost = 'localhost') {
        $this->dbuser = $dbuser;
        $this->dbpassword = $dbpassword;
        $this->dbname = $dbname;
        $this->dbhost = $dbhost;
    }

    function quick_connect($dbuser = '', $dbpassword = '', $dbname = '', $dbhost = 'localhost') {
        $return_val = false;
        if (!$this->connect($dbuser, $dbpassword, $dbhost, true))
            ;else if (!$this->select($dbname))
            ;
        else
            $return_val = true;return $return_val;
    }

    function connect($dbuser = '', $dbpassword = '', $dbhost = 'localhost') {
        global $ezsql_mysql_str;
        $return_val = false;
        if (!$dbuser) {
            $this->register_error($ezsql_mysql_str[1] . ' in ' . __FILE__ . ' on line ' . __LINE__);
            $this->show_errors ? trigger_error($ezsql_mysql_str[1], E_USER_WARNING) : null;
        } else if (!$this->dbh = @mysql_connect($dbhost, $dbuser, $dbpassword, true)) {
            $this->register_error($ezsql_mysql_str[2] . ' in ' . __FILE__ . ' on line ' . __LINE__);
            $this->show_errors ? trigger_error($ezsql_mysql_str[2], E_USER_WARNING) : null;
        } else {
            $this->dbuser = $dbuser;
            $this->dbpassword = $dbpassword;
            $this->dbhost = $dbhost;
            $return_val = true;
        }
        return $return_val;
    }

    function select($dbname = '') {
        global $ezsql_mysql_str;
        $return_val = false;
        if (!$dbname) {
            $this->register_error($ezsql_mysql_str[3] . ' in ' . __FILE__ . ' on line ' . __LINE__);
            $this->show_errors ? trigger_error($ezsql_mysql_str[3], E_USER_WARNING) : null;
        } else if (!$this->dbh) {
            $this->register_error($ezsql_mysql_str[4] . ' in ' . __FILE__ . ' on line ' . __LINE__);
            $this->show_errors ? trigger_error($ezsql_mysql_str[4], E_USER_WARNING) : null;
        } else if (!@mysql_select_db($dbname, $this->dbh)) {
            if (!$str = @mysql_error($this->dbh))
                $str = $ezsql_mysql_str[5];$this->register_error($str . ' in ' . __FILE__ . ' on line ' . __LINE__);
            $this->show_errors ? trigger_error($str, E_USER_WARNING) : null;
        }
        else {
            $this->dbname = $dbname;
            $return_val = true;
        }
        return $return_val;
    }

    function escape($str) {
        return mysql_escape_string(stripslashes($str));
    }

    function sysdate() {
        return'NOW()';
    }

    function query($query) {
        $return_val = 0;
        $this->flush();
        $query = trim($query);
        $this->func_call = "\$db->query(\"$query\")";
        $this->last_query = $query;
        $this->num_queries++;
        if ($cache = $this->get_cache($query)) {
            return $cache;
        }
        if (!isset($this->dbh) || !$this->dbh) {
            $this->connect($this->dbuser, $this->dbpassword, $this->dbhost);
            $this->select($this->dbname);
        }
        $this->result = @mysql_query($query, $this->dbh);
        if ($str = @mysql_error($this->dbh)) {
            $is_insert = true;
            $this->register_error($str);
            $this->show_errors ? trigger_error($str, E_USER_WARNING) : null;
            return false;
        }
        $is_insert = false;
        if (preg_match("/^(insert|delete|update|replace)\s+/i", $query)) {
            $this->rows_affected = @mysql_affected_rows();
            if (preg_match("/^(insert|replace)\s+/i", $query)) {
                $this->insert_id = @mysql_insert_id($this->dbh);
            }
            $return_val = $this->rows_affected;
        } else {
            $i = 0;
            while ($i < @mysql_num_fields($this->result)) {
                $this->col_info[$i] = @mysql_fetch_field($this->result);
                $i++;
            }
            $num_rows = 0;
            while ($row = @mysql_fetch_object($this->result)) {
                $this->last_result[$num_rows] = $row;
                $num_rows++;
            }@mysql_free_result($this->result);
            $this->num_rows = $num_rows;
            $return_val = $this->num_rows;
        }
        $this->store_cache($query, $is_insert);
        $this->trace || $this->debug_all ? $this->debug() : null;
        return $return_val;
    }

}

?>