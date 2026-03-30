<?php

class database
{
    public $dsn;
    public $conn;

    function __construct()
    {
        $this->conn = mysqli_connect(HOST, HOST_USER, HOST_PASSWORD) or die($this->error_sql_log('Database Connect Fail<br />' . $this->error()));
        mysqli_set_charset($this->conn, "utf8") or die($this->error_sql_log('Database Query Fail<br />' . $this->error()));
        mysqli_select_db($this->conn, HOST_DATABASE) or die($this->error_sql_log('Database Select DB Fail<br />' . $this->error()));

    }

    function error_sql_log($s_data)
    {
        $data = explode("<br />", $s_data);
        $s_error_text = "ERROR : MySql query failed\tIP : " . $_SERVER['REMOTE_ADDR'] . " \tDATE/TIME : " . date("d/m/Y H:I:s") . " h\r\n";
        $s_error_text .= "SQL ERROR : " . $data['0'] . "\r\n";
        $s_error_text .= "MSG ERROR : " . $data['1'] . "\r\n\r\n";
        $s_error = fopen(LOG_PATH . DS . "log_sql_" . date('dMY') . ".txt", 'a+');
        fwrite($s_error, $s_error_text);
        fclose($s_error);
        return $s_data;
    }

    function error()
    {
        return mysqli_error();
    }

    function js_thai_encode($data = array())
    {
        if (is_array($data)) {
            foreach ($data as $a => $b) {
                if (is_array($data[$a])) {
                    $data[$a] = $this->js_thai_encode($data[$a]);
                }
            }
        }
        return $data;
    }

    function object2array($object)
    {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        } else {
            $array = $object;
        }
        return $array;
    }

    public function CreateID($tbl = false, $field = false, $where = '')
    {
        $sql = 'select MAX(' . $field . ') AS Code FROM ' . $tbl;
        if (!empty($where)) {
            $sql = $sql . ' WHERE ' . $where;
        }
        $sql = $sql . ' ORDER BY ' . $field . ' DESC';
        $query = $this->query($sql);
        if ($row = $this->fetch($query)) {
            $num = (int)$row->Code;
            $num++;
            $id = $num;
        } else {
            $id = '1';
        }
        return $id;
    }

    function query($sql)
    {
        $res = mysqli_query($this->conn, $sql) or die($this->error_sql_log($sql . '<br />' . $this->error()));
        return $res;
    }

    function fetch($res)
    {
        return mysqli_fetch_object($res);
    }

    function result($tbl, $where = NULL, $order = NULL, $limit = NULL, $field = '*', $group = NULL)
    {
        $f = $this->_field($field);
        $w = (!is_null($where)) ? $this->_where($where) : '';
        $o = (!is_null($order)) ? $this->_order($order) : '';
        $g = (!is_null($group)) ? $this->_group($group) : '';
        $l = (!is_null($limit)) ? $this->_limit($limit) : '';

        $sql = "SELECT {$f} FROM {$tbl} {$w} {$g} {$o} {$l}";
        $res = $this->query($sql);
        $num = $this->num($res);

        if ($num == 0) {
            return FALSE;
        } else {
            while ($row = $this->fetch($res))
                $tmp[] = $row;

            return $tmp;
        }
    }

    function _field($field)
    {
        if (is_array($field)) {
            $f = implode(', ', $field);
        } else {
            $f = $field;
        }

        return $f;
    }

    function _where($where)
    {
        $w = ' WHERE ';

        if (is_array($where)) {
            foreach ($where as $k => $v) {
                if (!$this->_operator($k) && is_null($where[$k]))
                    $k .= ' IS NULL';

                if (!is_null($v) && !$this->_sql_option($v)) {
                    if (!$this->_operator($k))
                        $k .= ' =';

                    $v = ' ' . $this->_escape($v);
                }

                if (!$this->_operator($k) && $this->_sql_option($v))
                    $tmp[] = $k . ' ' . $v;
                else
                    if ($this->_sql_option2($v)) {
                        $tmp[] = $k;
                    } else {
                        $tmp[] = $k . $v;
                    }
            }
            if ($tmp)
                $w .= implode(' AND ', $tmp);
            else
                $w = ' ';
        } else {
            $w .= $where;
        }

        return $w;
    }

    function _operator($str)
    {
        $str = trim($str);
        if (!preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str)) {
            return FALSE;
        }

        return TRUE;
    }

    function _sql_option($where)
    {
        if ('IN' == substr($where, 0, 2) || 'BETWEEN' == substr($where, 0, 7) || 'LIKE' == substr($where, 0, 4) || '>' == substr($where, 0, 1) || '<' == substr($where, 0, 1))
            return true;
        else
            return false;
    }

    function _escape($str)
    {
        switch (gettype($str)) {
            case 'string'  :
                $str = "'" . ($str) . "'";
                break;
            case 'boolean' :
                $str = ($str === FALSE) ? 0 : 1;
                break;
            default        :
                $str = ($str === NULL) ? 'NULL' : $str;
                break;
        }

        return $str;
    }

    function _sql_option2($where)
    {
        if ('KRON2KRON' == substr($where, 2, 9))
            return true;
        else
            return false;
    }

    function _order($order)
    {
        $o = ' ORDER BY ';

        if (is_array($order)) {
            foreach ($order as $k => $v)
                $tmp[] = $k . ' ' . $v;

            $o .= implode(', ', $tmp);
        } else {
            $o .= $order;
        }

        return $o;
    }

    function _group($group)
    {
        $o = ' GROUP BY ';
        /*
        if(is_array($group))
        {
            foreach($group as $k => $v)
                $tmp[] = $k.' '.$v;

            $o .= implode(', ', $tmp);
        }
        else
        {*/
        $o .= $group;
        /*}*/

        return $o;
    }

    function _limit($limit)
    {
        $l = ' LIMIT ';

        if (is_array($limit)) {
            foreach ($limit as $k => $v)
                $tmp[] = $k . ', ' . $v;

            $l .= implode(', ', $tmp);
        } else {
            $l .= $limit;
        }

        return $l;
    }

    function num($res)
    {
        return mysqli_num_rows($res);
    }

    function record($tbl, $where = NULL, $field = '*')
    {

        $f = $this->_field($field);
        $w = (!is_null($where)) ? $this->_where($where) : '';

        $sql = "SELECT {$f} FROM {$tbl} {$w}";


        $res = $this->query($sql);

        $num = $this->num($res);

        if ($num == 0) {
            return FALSE;
        } else {
            return $this->fetch($res);
        }
    }

    function begin()
    {
        $this->query("BEGIN");
    }

    function commit()
    {
        $this->query("COMMIT");
    }

    function rollback()
    {
        $this->query("ROLLBACK");
    }

    function sum($tbl, $where = NULL, $field = NULL)
    {

        $w = (!is_null($where)) ? $this->_where($where) : '';
        $sql = "SELECT SUM($field) AS cnt FROM {$tbl} {$w} ";
        $res = $this->query($sql);
        $row = $this->fetch($res);
        return $row->cnt ? $row->cnt : 0;
    }

    function countRow($tbl, $where = NULL, $group = NULL)
    {
        $w = (!is_null($where)) ? $this->_where($where) : '';
        $g = (!is_null($group)) ? $this->_group($group) : '';

        $sql = "SELECT COUNT(*) AS cnt FROM {$tbl} {$w} {$g}";
        $res = $this->query($sql);
        $row = $this->fetch($res);
        return $row->cnt;
    }

    function id()
    {
        return mysqli_insert_id();
    }

    function insert($tbl, $data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $field[] = $k;
                $value[] = $this->_escape($v);
            }

            $insert = "(" . implode(', ', $field) . ") VALUES (" . implode(', ', $value) . ")";
        } else {
            $insert = " VALUES {$data}";
        }

        return $this->query("INSERT INTO {$tbl} {$insert}");
    }

    function update($tbl, $data, $where = NULL)
    {
        $w = (!is_null($where)) ? $this->_where($where) : '';

        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $set[] = $k . ' = ' . $this->_escape($v);
            }

            $update = implode(', ', $set);
        } else {
            $update = $data;
        }

        return $this->query("UPDATE {$tbl} SET {$update} {$w}");
    }

    function delete($tbl, $where = NULL)
    {
        $w = (!is_null($where)) ? $this->_where($where) : '';
        return $this->query("DELETE FROM {$tbl} {$w}");
    }


}

?>