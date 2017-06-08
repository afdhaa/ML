<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	function __construct() {
			parent::__construct();
			$this->load->model('M_search');
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('search');
	}

	public function coba()
	{
		$search=$this->input->post('search');
		//$search="xxx";
		// /echo date('Y');die();
		$search="rahasia ahok sekarang";
		$balik = array('messages' => array(),'isi'=> array(),'error'=> array());
		$table=$this->M_search->table($search);
		$kandidat=$this->M_search->kandidat($search);
		print_r($table);die();
		$time=$this->M_search->time($search);
		$bulan=$this->M_search->bulan($search);
		$tgl=$this->tgl($search);
		//echo $tgl;die();
		//print_r($bulan->return);die();
		if ($kandidat=="") {
			$id_kandidat=null;
		}
		elseif (!empty($kandidat)) {
			$id_kandidat=$kandidat->id_kandidat;
		}
		if ($time=="") {
			$the_time=null;
		}
		elseif (!empty($time)) {
			$the_time=$time->return;
		}
		if ($bulan=="") {
			$bulan=null;
		}
		elseif (!empty($bulan)) {
			$bulan=$bulan->return;
		}
		if (!empty($table)) {
			$tablenya=$table->table_search;
		}
		else {
			$tablenya=null;
		}
		//print_r($bulan->return);die();
		if ($tablenya=="issue") {
			$hasil=$this->M_search->cari($table->table_search,$id_kandidat,$the_time,$bulan,$tgl);

			if (!empty($hasil)) {
				$balik['messages'] = $table->table_search;

				$no=1;

				foreach ($hasil as $row => $value) {
					$output[] = array(
						"$no",
						$value->nama,
						$value->issue,
						$value->sub_issue,
						$value->tanggal,
						$value->tone
					);
					$no++;
				}
				header('Access-Control-Allow-Origin: *');
		    header("Content-Type: application/json");
				$balik['isi']= $output;
				echo json_encode($balik);
			}
		}
		else if ($tablenya=="sumkandtonetgl") {
			$hasil=$this->M_search->cari($table->table_search,$id_kandidat,$the_time,$bulan,$tgl);
			$balik['messages'] = $table->table_search;
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			$balik['isi']= $hasil;
			//print_r($hasil);
			echo json_encode($balik);
		}
		else {
			$balik['messages'] = "error";
			echo json_encode($balik);
		}

	}
	public function tgl($search)
	{
		$isi=explode(" ",$search);
		$tgl = array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
		$isinya="";
		for ($i=0; $i <count($isi);  $i++) {
			for ($j=0; $j <31 ; $j++) {
				if ($isi[$i]==$tgl[$j]) {
					$isinya=$isi[$i];
				}
			}

		}
		if ($isinya>0&&$isinya<=9) {
			return "0".$isinya;
		}
		else {
			return $isinya;
		}
	}

}
