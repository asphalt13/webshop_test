<?php

include "classes.php";

$view = new view;
$com = new com;

$view->print_html_page_start("Purchase");
$view->print_html_buy_div($com->get_buy_value());
$view->print_html_page_end();

?>