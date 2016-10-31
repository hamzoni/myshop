<?php
class product_c extends general_c{
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function insert_record($name,$price,$sale,$ava,$ntr,$type,$dp,$dc) {
		$this->db->query("INSERT INTO `$this->tbl`(name,price,sale,avatar_img,nutrition_img,type,display,description) 
			VALUES (:nm,:prc,:sl,:av,:nr,:tp,:dp,:dc)");
		$this->db->bind(':nm',$name);
		$this->db->bind(':prc',$price);
		$this->db->bind(':sl',$sale);
		$this->db->bind(':av',$ava);
		$this->db->bind(':nr',$ntr);
		$this->db->bind(':tp',$type);
		$this->db->bind(':dp',$dp);
		$this->db->bind(':dc',$dc);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->lastInsertId();
	}
	public function select_record($limit , $offset) {
		$this->db->query("SELECT * FROM `$this->tbl` LIMIT $limit OFFSET $offset");
		$rows = $this->db->resultset();
		return $rows;
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
					'ntr'=>'nutrition_img','p_type'=>'type','p_display'=>'display','f_dscrp'=>'description'];
		if(is_null($dt_arr['ava'])) unset($colQr_k['ava']);
		if(is_null($dt_arr['ntr'])) unset($colQr_k['ntr']);
		$colQr_v = []; 
		$c = 0;
		foreach ($colQr_k as $key => $value) {
			$colQr_v[$c] = $value."='".$dt_arr[$key]."'";
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
}