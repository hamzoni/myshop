<?php
class product_c extends general_c{
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function insert_record($d) {
		$c = ["",""];
		end($d);
		$lk = key($d);

		if ($d['store_id'] == 0) $d['store_id'] = null;
		foreach ($d as $k => $v) {
			$c[0] .= $k.($k == $lk ? "" : ",");
			$c[1] .= ":".$k.($k == $lk ? "" : ",");
		}
		$queryStr = "INSERT INTO `$this->tbl`(".$c[0].") VALUES (".$c[1].")";
		$this->db->query($queryStr);
		foreach ($d as $k => $v) $this->db->bind(':'.$k,$v);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->rowCount();
	}
	public function select_record($limit , $offset, $whereAt = null) {
		if ($whereAt == null) {
			$queryStr = "SELECT $this->tbl.*, stores.store_name 
						FROM `$this->tbl` 
						LEFT JOIN stores ON $this->tbl.store_id = stores.id 
						ORDER BY post_date DESC LIMIT 
						:limit OFFSET :offset";
		} else {
			$queryStr = "(SELECT $this->tbl.*, stores.store_name 
						FROM `$this->tbl` WHERE id = $whereAt 
						LEFT JOIN stores ON products.store_id = stores.id 
						ORDER BY post_date DESC LIMIT :limit OFFSET :offset) 
						UNION ALL (SELECT * FROM `$this->tbl` WHERE id < $whereAt 
						ORDER BY post_date DESC LIMIT :limit OFFSET :offset)";
		}
		// $queryStr = "SELECT products.*, stores.store_name
		// 			FROM products 
		// 			LEFT JOIN stores ON products.store_id = stores.id";
		$this->db->query($queryStr);
		$this->db->bind(":limit",$limit);
		$this->db->bind(":offset",$offset);
		$rows = $this->db->resultset();
		return $rows;
	}
	public function select_specificRow($field, $p_id) {
		$queryStr = "SELECT $field FROM `$this->tbl` WHERE id = $p_id";
		$this->db->query($queryStr);
		return $this->db->single();
	}
	public function update_display($id_arr, $upd_val) {
		if (count($id_arr) > 1) {
			$queryStr = "CASE id ";
			for ($i = 0; $i < count($id_arr); $i++) {
				$queryStr .= "WHEN $id_arr[$i] THEN $upd_val[$i] ";
				if ($i == count($id_arr) - 1) {
					$queryStr .= "ELSE display END WHERE id 
								IN (".implode(",",$id_arr).")";
				}
			}
			$queryStr = "UPDATE `$this->tbl` SET display = $queryStr";
			$this->db->query($queryStr);
		} else {
			$queryStr = "UPDATE `$this->tbl` SET `display` = '$upd_val[0]' WHERE `$this->tbl`.`id` = $id_arr[0];";
			$this->db->query($queryStr);
		}
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return ($this->db->rowCount() !== count($id_arr) ? '0' : '1');
	}
	public function delete_record($id_arr,$bsurl) {
		if (count($id_arr) > 1) {
			$queryStr = "id IN (".implode(",",$id_arr).")";
		} else {
			$queryStr = "id=".$id_arr[0];
		}
		$hrefLink = 'http://'.$_SERVER['HTTP_HOST'].$bsurl;

		$queryStr = "DELETE FROM `$this->tbl` WHERE $queryStr";
		$this->db->query($queryStr);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return ($this->db->rowCount() !== count($id_arr) ? '0' : '1');
	}
	
	public function update_product($dt_arr) {
		$colQr_k = ['p_name'=>'name','p_price'=>'price','p_sale'=>'sale','ava'=>'avatar_img',
					'ntr'=>'nutrition_img','p_type'=>'type','p_display'=>'display','f_dscrp'=>'description','p_store'=>'store_id'];
		if(@is_null($dt_arr['ava'])) unset($colQr_k['ava']);
		if(@is_null($dt_arr['ntr'])) unset($colQr_k['ntr']);
		$colQr_v = []; 
		$c = 0;
		foreach ($colQr_k as $key => $value) {
			if (@is_null($dt_arr[$key])) {
				$colQr_v[$c] = $value." = NULL";
			} else {
				$colQr_v[$c] = $value." ='".$dt_arr[$key]."'";
			}
			$c++;
		}
		$queryStr = "UPDATE `$this->tbl`
					SET ".join(",",$colQr_v)." WHERE id=".$dt_arr['id'];
		$this->db->query($queryStr);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return (0 == $this->db->rowCount() ? 0 : 1);
	}
	public function get_all_imgUrl($field) {
		$queryStr = "SELECT `$field` FROM `$this->tbl`";
		$this->db->query($queryStr);
		$rows = $this->db->resultset();
		return $rows;
	}
}