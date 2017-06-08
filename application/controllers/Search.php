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
		//$search="rahasia ahok";
		$balik = array('messages' => array(),'isi'=> array(),'error'=> array(),'twitter'=> array(),'issue'=> array());
		$table=$this->M_search->table($search);
		$kandidat=$this->M_search->kandidat($search);
		// /print_r($table);die();
		$time=$this->M_search->time($search);
		$bulan=$this->M_search->bulan($search);
		$tgl=$this->tgl($search);
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
		if ($kandidat!==""||$kandidat!==NULL) {
			//echo "string";die();
			$balik['messages'] = "oke";
			$hasiltwitter=$this->M_search->cari_twitter("sumkandtonetgl",$id_kandidat,$the_time,$bulan,$tgl);
			$hasilissue=$this->M_search->cari("issue",$id_kandidat,$the_time,$bulan,$tgl);
			$no=1;
			foreach ($hasilissue as $row => $value) {
				$output[] = array(
					"$no",
					$value->issue,
					$value->sub_issue,
					$value->tone,
					$value->jml
				);
				$no++;
			}
			if (!empty($hasilissue&&$hasiltwitter)) {

				header('Access-Control-Allow-Origin: *');
		    header("Content-Type: application/json");
				$balik['issue']= $output;
				$balik['twitter']= $hasiltwitter;
				echo json_encode($balik);

			}
			elseif (!empty($hasilissue)) {
				header('Access-Control-Allow-Origin: *');
		    header("Content-Type: application/json");
				$balik['issue']= $output;
				$balik['twitter']= "kosong";
				echo json_encode($balik);
			}
			elseif (!empty($hasiltwitter)) {
				header('Access-Control-Allow-Origin: *');
		    header("Content-Type: application/json");
				$balik['issue']= "kosong";
				$balik['twitter']= $hasiltwitter;
				echo json_encode($balik);
			}
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
