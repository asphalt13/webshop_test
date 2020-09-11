<?php

//adatok tárolása és lekérdezése
////////////////////////////////

class database{

	//tárolt adatokat tartalmazza, és adja vissza

	public function get_all_data(){
		
		$return_array = array(
			array(
				"id" => 1,
				"name" => "Samsung Galaxy S7",
				"price" => 1000
			),
			array(
				"id" => 2,
				"name" => "Apple IPhone 6",
				"price" => 2000
			),
			array(
				"id" => 3,
				"name" => "Lenovo Tab 4",
				"price" => 3000
			),
			array(
				"id" => 4,
				"name" => "Aple IPad 2",
				"price" => 4000
			),
			array(
				"id" => 5,
				"name" => "Asus ROG GZ700",
				"price" => 5000
			)
		);
		
		return $return_array;
		
	}
	
	//feltétel szerint a kért adatsorokat adja vissza
	
	public function get_data_rows_by_condition($col, $value, $exact_result = false){
		
		$all_data = $this->get_all_data();
		
		$rows = array();
		
		if(!empty($all_data)){
			foreach($all_data as $data_row){
				
				if($exact_result){
					if(isset($data_row[$col]) && $value === $data_row[$col])
						$rows[] = $data_row;
				}
				else{
					if(isset($data_row[$col]) && strpos($data_row[$col], $value) !== false)
						$rows[] = $data_row;
				}
				
			}
		}
		
		return $rows;
		
	}

}


//html megjelenítés
///////////////////

class view{
	
	//elkészíti a táblázat html kódját
	
	private function get_html_webshop_table($search_field_id, $table_id){
		
		$all_data = array();
		$database = new database;
		
		$all_data = $database->get_all_data();
		
		$col_1_width = "40%";
		$col_2_width = "30%";
		$col_3_width = "30%";
		
		$col_1_name = "Product";
		$col_2_name = "Price";
		$col_3_name = "Actions";
		
		$search_placeholder = "Search";
		
		$buy_text = "Buy";
		
		$table = "
			<p>
				<input id=\"".$search_field_id."\" type=\"text\" name=\"search\" placeholder=\"".$search_placeholder."\"/>
			</p>
			<table>
				<thead>
					<tr>
						<th style=\"width: ".$col_1_width."\">
							".$col_1_name."
						</th>
						<th style=\"width: ".$col_2_width."\">
							".$col_2_name."
						</th>
						<th style=\"width: ".$col_3_width."\">
							".$col_3_name."
						</th>
					</tr>
				</thead>
				<tbody id=\"".$table_id."\">
		";
		
		if(!empty($all_data)){
			foreach($all_data as $data_row){
				
				$table .= "
					<tr>
						<td style=\"width: ".$col_1_width."\">
							".$data_row['name']."
						</td>
						<td style=\"width: ".$col_2_width."\">
							".$data_row['price']."
						</td>
						<td style=\"width: ".$col_3_width."\">
							<a href=\"buy.php?buy_id=".$data_row['id']."\" target=\"_blank\">".$buy_text."</a>
						</td>
					</tr>
				";
				
			}
		}
		
		$table .= "
				</tbody>
			</table>
		";
		
		return $table;
		
	}
	
	//elkészíti a vétel visszaigazoló div-et
	
	private function get_html_buy_div($buy_id){
		
		$database = new database;
		
		$product_rows = $database->get_data_rows_by_condition("id", $buy_id);
		$product_row = reset($product_rows);
		
		$purchase_text = "Thank you for your purchase!";
		$selected_product_text = "Selected product: ";
		
		$buy_div = "
			<div>
				".$purchase_text."
				<br/>
				".$selected_product_text.$product_row['name']."
			</div>
		";
		
		return $buy_div;
		
	}
	
	//elkészíti az ajax/jquery-t betöltő kódot
	
	private function get_ajax(){
		
		$script = "
			<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
		";
		
		return $script;
		
	}
	
	//elkészíti az ajaxos kereső scriptet
	
	private function get_search_script_code($search_field_id, $table_id){
		
		$script = "
			<script>
				$(document).ready(function(){
				  $(\"#".$search_field_id."\").on(\"keyup\", function() {
					var value = $(this).val().toLowerCase();
					$(\"#".$table_id." tr\").filter(function() {
					  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				  });
				});
			</script>
		";
		
		return $script;
		
	}
	
	//elkészíti az oldal kezdetének html kódját
	
	private function get_html_page_start($title, $with_search_script = false, $search_field_id = "", $table_id = ""){

		$search_script = ($with_search_script) ? $this->get_ajax().$this->get_search_script_code($search_field_id, $table_id) : "";

		$page_start = "
			<!DOCTYPE html>
			<html>
				<head>
					<title>".$title."</title>
					".$search_script."
					<link rel=\"stylesheet\" href=\"main.css\">
				</head>
				<body>
		";
		
		return $page_start;
		
	}
	
	//elkészíti az oldal végének html kódját
	
	private function get_html_page_end(){
		
		$page_end = "
				</body>
			</html>
		";
		
		return $page_end;
		
	}
	
	//printeli a táblázatot
	
	public function print_html_webshop_table($search_field_id, $table_id){

		echo($this->get_html_webshop_table($search_field_id, $table_id));
		
	}
	
	//printeli a vétel visszaigazoló div-et
	
	public function print_html_buy_div($buy_id){
		
		echo($this->get_html_buy_div($buy_id));
		
	}
	
	//printeli az oldal kezdetét
	
	public function print_html_page_start($title, $with_search_script = false, $search_field_id = "", $table_id = ""){
		
		echo($this->get_html_page_start($title, $with_search_script, $search_field_id, $table_id));
		
	}
	
	//printeli az oldal végét
	
	public function print_html_page_end(){
		
		echo($this->get_html_page_end());
		
	}
	
}


//kommunikáció
//////////////

class com{
	
	public function get_buy_value(){
		
		$buy_value = (isset($_GET["buy_id"]) && !empty($_GET["buy_id"])) ? $_GET["buy_id"] : "";
			
		return $buy_value;
		
	}
	
}

//fejlesztési lehetőségek
/////////////////////////

//DB integráció: a database osztályban mysqli class használata az adatbázis elérésre, fv-eket át lehet alakítani/ki lehet bővíteni ehhez

//login: felhasználók tárolása, bejelentkezési felület, ott SESSION-be menteni hash-elt azonosítót, figyelő fv, ami ellenőrzi az azonosító 
//meglétét és helyességét, ennek alapján kontrollálja az oldalak tartalmát

//security (frontend-backend): a frontend metódusokon keresztül jövő adatokat ellenörző fv-en keresztül vizsgálni, adatbázisba szintén csak
//ellenőrző fv-en keresztül engedni adatot

//többnyelvűség: szövegek konstansokból történő használata nyelvenkénti lang_nyelv.php-kből

//email küldés: ha a felhasználók regisztráltak, akkor az e-mail címükre mehet mail fv-el buy.php-ról, akár megerősítő link, ott válasz
//lekezelése, addig a db-ben a megrendelés várakozó státuszba

?>