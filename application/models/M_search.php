<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_search extends CI_Model {


	public function table($search)
	{
		return $this->db->query("SELECT * FROM `table_search` WHERE MATCH (text) AGAINST ('$search' IN NATURAL LANGUAGE MODE)")->row();
	}
	public function kandidat($search)
	{
		return $this->db->query("SELECT * FROM `v_julukan` WHERE MATCH (julukan) AGAINST ('$search' IN NATURAL LANGUAGE MODE)")->row();
	}

	public function time($search)
	{
		return $this->db->query("SELECT * FROM `waktu` WHERE MATCH (waktu) AGAINST ('$search' IN NATURAL LANGUAGE MODE)")->row();
	}
	public function bulan($search)
	{
		return $this->db->query("SELECT * FROM `bulan` WHERE MATCH (bulan) AGAINST ('$search' IN NATURAL LANGUAGE MODE)")->row();
	}

	public function cari($table,$id_kandidat,$the_time,$bln="",$tgl="")
	{
		//print_r($the_time);die();
		if ($id_kandidat!=NULL||$id_kandidat!="") {
			$this->db->where('id_kandidat',$id_kandidat);
		}

		if (($bln!=""||$bln!=NULL)&&($tgl!=""||$tgl!=NULL)) {
			//$date=$this->db->query("select $the_time as tgl")->row();
			$thn=date("Y");
			$cari="$thn"."-"."$bln"."-"."$tgl";
			$this->db->where('tanggal',$cari);
		}
		elseif ($bln!=""||$bln!=NULL) {
			$thn=date("Y");
			$tgl=date("dd");
			$cari="$thn"."-"."$bln"."-"."$tgl";
			$this->db->where('tanggal',$cari);
		}
		elseif ($tgl!=""||$tgl!=NULL) {
			$thn=date("Y");
			$bln=date("m");
			$cari="$thn"."-"."$bln"."-"."$tgl";
			$this->db->where('tanggal',$cari);
		}
		else if ($the_time!=""||$the_time!=NULL) {
			$date=$this->db->query("select $the_time as tgl")->row();
			//print_r($date);die();
			$this->db->where('tanggal',$date->tgl);
		}

		$this->db->order_by('id', 'DESC');
		return $this->db->get($table)->result();
	}
	public function cari_twitter($table,$id_kandidat,$the_time,$bln="",$tgl="")
	{
		if ($id_kandidat!=NULL||$id_kandidat!="") {
			$this->db->where('id_kandidat',$id_kandidat);
		}

		if (($bln!=""||$bln!=NULL)&&($tgl!=""||$tgl!=NULL)) {
			//$date=$this->db->query("select $the_time as tgl")->row();
			$thn=date("Y");
			$cari="$thn"."-"."$bln"."-"."$tgl";
			$this->db->where('tanggal',$cari);
		}
		elseif ($bln!=""||$bln!=NULL) {
			$thn=date("Y");
			$tgl=date("dd");
			$cari="$thn"."-"."$bln"."-"."$tgl";
			$this->db->where('tanggal',$cari);
		}
		elseif ($tgl!=""||$tgl!=NULL) {
			$thn=date("Y");
			$bln=date("m");
			$cari="$thn"."-"."$bln"."-"."$tgl";
			$this->db->where('tanggal',$cari);
		}
		else if ($the_time!=""||$the_time!=NULL) {
			$date=$this->db->query("select $the_time as tgl")->row();
			//print_r($date);die();
			$this->db->where('tanggal',$date->tgl);
		}

		$this->db->order_by('id', 'DESC');
		return $this->db->get($table)->result();
	}

}
