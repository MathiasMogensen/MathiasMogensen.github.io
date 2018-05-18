<?php

class pagination {

    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function paginationTable($limit, $table, $product_id) {
        $this->limit = $limit;
        $this->table = $table;
        $this->product_id = $product_id;
        $sql = "SELECT COUNT(*) FROM $table WHERE product_id = $this->product_id AND deleted = 0";
        $this->total = $this->db->fetch_value($sql);
    
        // How many pages will there be
        $this->pages = ceil($this->total / $limit);
    
        // What page are we currently on?
        $this->page = min($this->pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
        )));
    
        // Calculate the offset for the query
        $this->offset = ($this->page - 1)  * $limit;
    
        $params = array(
            $this->product_id,
            $limit,
            $this->offset
        );
        $sql = "SELECT
        comment.id AS id,
        comment.content AS content,
        comment.created_at AS created_at,
        user.id AS user_id,
        user.firstname AS firstname,
        user.lastname AS lastname,
        user.avatar AS avatar
        FROM comment
        JOIN user ON user_id = user.id
        WHERE product_id = ? AND deleted = 0
        ORDER BY created_at DESC LIMIT ? OFFSET ?";

        return $this->db->fetch_array($sql, $params);
    }
    public function paginationLinks() {
        // Some information to display to the user
        $this->start = $this->offset + 1;
        $this->end = min(($this->offset + $this->limit), $this->total);
    
        if ($this->total > 0) {
            // The "back" link
            $this->prevlink = ($this->page > 1) ? '<li><a class="pagination-link" href="details.php?p='. $this->product_id .'&page=' . ($this->page - 1) . '" title="Previous page"><i class="fas fa-angle-left"></i></a></li>' : '<li><span class="pagination-link disabled"><i class="fas fa-angle-left"></i></span></li>';
        
            // The "forward" link
            $this->nextlink = ($this->page < $this->pages) ? '<li><a class="pagination-link" href="details.php?p='. $this->product_id .'&page=' . ($this->page + 1) . '" title="Next page"><i class="fas fa-angle-right"></i></a></li>' : '<li><span class="pagination-link disabled"><i class="fas fa-angle-right"></i></span></li>';
        
            // Display the paging information
            $html = "<ul class='pagination'>$this->prevlink";
            for ($i = 1; $i <= $this->pages; $i++) {
                if (isset($_GET['page']) && $_GET['page'] == $i) {
                    $html .= "<li><a class='pagination-link pagination-active' href='details.php?p=". $this->product_id ."&page=". $i ."'>". $i ."</a></li>";
                } else {
                    $html .= "<li><a class='pagination-link' href='details.php?p=". $this->product_id ."&page=". $i ."'>". $i ."</a></li>";
                }
            }
            $html .= "$this->nextlink </ul>";
            echo $html;
        }
    }
}