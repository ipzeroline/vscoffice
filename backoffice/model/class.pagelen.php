<?php

/*
$pl  = $load->library('pagelen');

$cnt = $brd->db->countRow('tbl's name');
$len = $pl->countRow($cnt);

$board = $brd->postList($len);
<?=$pl->render('page.php?');? >
*/

class pagelen
{
    var $Pagelen = 10;
    var $end_page = 3;
    var $Page;
    var $total;
    var $first_title = 'First';
    var $last_title = 'Last';
    var $prev_title = 'Back';
    var $go_title = 'Next';


    function pagelen()
    {
        if (file_exists(CONFIG_PATH . DS . 'pagelen' . EXT)) {
            require CONFIG_PATH . DS . 'pagelen' . EXT;
        }

        $this->initialize($PL);
        $this->Page = $_GET['p'];
    }

    function initialize($params = array())
    {
        if (count($params) > 0) {
            foreach ($params as $key => $val) {
                if (isset($this->$key)) $this->$key = $val;
            }
        }
    }

    function countRow($num)
    {
        $this->total = ceil($num / $this->Pagelen);

        if (empty($this->Page)) $this->Page = 1;

        $goto = ($this->Page - 1) * $this->Pagelen;

        $len = array($goto => $this->Pagelen);

        return $len;
    }

    function render($uri)
    {
        $start = $this->Page - $this->Range;

        if ($start <= 1) $start = 1;

        $end = $this->end_page;


        if ($end >= $this->total) $end = $this->total;

        $p = '';


        /// ��͹˹��
        if ($this->Page > 1) {
            $back = $this->Page - 1;
            $p .= '<li><a href="' . $uri . 'p=' . $back . '" title="' . $this->prev_title . '"  class="font1 linkC1">&laquo; Back&nbsp;</a></li>';
        } else {
            $p .= '<li><a href="#" title="' . $this->prev_title . '"  class="font1 linkC1">&laquo; Back&nbsp;</a></li>';
        }
        /// ˹���á
        if ($this->Page > $this->end_page + 1) {
            $p .= '<li><a href="' . $uri . 'p=1" title="' . $this->first_title . '"  class="font1 linkC1">1</a></li>';
        }
        if ($this->Page > $this->end_page + 2) {
            $p .= '<li><a href="#">...</a></li>';
        }

        // �ʴ�˹��
        $start = $this->Page - $this->end_page;
        if ($this->Page <= $this->end_page) {
            $start = 1;
        }
        $stop = $this->Page + $this->end_page;
        if ($stop >= $this->total) {
            $stop = $this->total;
        }
        for ($i = $start; $i <= $stop; $i++) {
            if ($i == $this->Page)
                $p .= '<li class="active"><a href="#">' . $i . '</a></li>';
            else
                $p .= '<li><a href="' . $uri . 'p=' . $i . '" title="' . $i . '" class="font1 linkC1">' . $i . '</a></li>';
        }


        // �ش����
        if ($this->Page + $this->end_page < $this->total - 1) {
            $p .= '<li><a href="#">...</a></li>';
        }
        if ($this->Page < $this->total - $this->end_page) {
            $p .= '<li><a href="' . $uri . 'p=' . $this->total . '" title="' . $this->last_title . '"  class="font1 linkC1">' . $this->total . '</a></li>';
        }

        /// �Ѵ�
        if ($this->Page < $this->total) {
            $next = $this->Page + 1;
            $p .= '<li><a href="' . $uri . 'p=' . $next . '" title="' . $this->go_title . '"  class="font1 linkC1">&nbsp;Next &raquo;</a></li>';
        } else {
            $p .= '<li><a href="#" title="' . $this->go_title . '"  class="font1 linkC1">&nbsp;Next &raquo;</a></li>';
        }


        $render = '<div class="pagination pagination-centered"><ul >' . $p . '</ul></div>';

        return $render;
    }
}

?>