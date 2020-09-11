<?php

include "classes.php";

$view = new view;
$com = new com;

$search_field_id = "search_field_1";
$table_id = "table_1";

$view->print_html_page_start("Web shop", true, $search_field_id, $table_id);
$view->print_html_webshop_table($search_field_id, $table_id);
$view->print_html_page_end();

?>
