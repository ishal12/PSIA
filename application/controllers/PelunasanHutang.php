<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PelunasanHutang extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->model('Supplier_model');
        $this->load->model('Bank_model');
        $this->load->model('NotaBeli_model');
        $this->load->model('Pembelian_model');
        $this->load->model('PelunasanHutang_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    	$this->load->library('form_validation');
    	$this->load->library('cart');
        $this->load->library('session');
    }
	public function index()
	{
		$data['NoNotaBeli'] = $this->NotaBeli_model->pembayaran_kredit();
		$data['barang'] = $this->Barang_model->get_barang();
		$data['supplier'] = $this->Supplier_model->get_supplier();
		$data['bank'] = $this->Bank_model->get_bank();

		$this->load->view('layout/header');
		$this->load->view('pelunasan/pelunasanBeli', $data);
		$this->load->view('layout/footer');
	}

	public function detail_nota(){
		$NotaBeli = $this->NotaBeli_model->get_nota($_POST['noNota']);

		$sisaBayar = $NotaBeli['Total'] - $NotaBeli['Bayar'];
		//$totalBayar = $NotaBeli['Total'] - ($NotaBeli['Total'] * ($NotaBeli['DiskonPelunasan']/100));
		$totalBayar = $sisaBayar - (($sisaBayar) * ($NotaBeli['DiskonPelunasan']/100));
		
		echo json_encode(array('sisaBayar' => $sisaBayar,'diskon'=>$NotaBeli['DiskonPelunasan'], 'total'=>$NotaBeli['Total'], 'totalBayar' => $totalBayar, 'tgl'=>$NotaBeli['TanggalBatasDiskon']));
	}

	public function simpan(){
		$nota = $this->input->post('noNota');
		$tgl = $this->input->post('tgl');
		$jp = $this->input->post('jPembayaran');
		$nominal = $this->input->post('nominal');
		$disc = $this->input->post('discPelunasan');
		$bayar = $this->input->post('totalBayar');
		$idbank = $this->input->post('bank');
		$norek = $this->input->post('noRek');
		$pemelikBank = $this->input->post('namaPemilik');

		$dataSimpan = array(
			'Tanggal' => $tgl,
			'NominalSeharusnya' => $nominal,
			'DiskonPelunasan' => $disc,
			'Bayar' => $bayar,
			'JenisPembayaran' => $jp,
			'NoNotaBeli' => $nota,
			'IdBank' => $idbank,
			'NoRekening' => $norek,
			'PemilikRekening' => $pemilikBank
		);

		if($this->PelunasanHutang_model->add_pelunasan_hutang($dataSimpan)){
			header("Location: ".site_url('PelunasanHutang/index'));
		}
	}

	public function create_nota(){
		$NoNotaBeli = $this->input->post('NoNotaBeli');
		$tgl = $this->input->post('tgl');
		$customer = $this->input->post('supplier');		

		$dataNotaBeli = array(
			'NoNotaBeli' => $NoNotaBeli,
			'Tanggal' => $tgl,
			'KodeSupplier' => $customer,
			'StatusKirim' => 1,
		);

		//Jika ada pengiriman
		if($this->input->post('kirim')=='true'){
			$biayaKirim = $this->input->post('biayaKirim');
			$fob = $this->input->post('fob');

			$dataNotaBeli['OngkosKirim'] = $biayaKirim;
			$dataNotaBeli['FOB'] = $fob;
		}

		if($this->input->post('jPembayaran')=='K'){
			$jenisPembayaran = $this->input->post('jPembayaran');
			$tanggalJatuhTempo = $this->input->post('jt');
			$discPelunasan = $this->input->post('discPelunasan');
			$batasPelunasan = $this->input->post('batasPelunasan');

			$dataNotaBeli['JenisPembayaran'] = $jenisPembayaran;
			$dataNotaBeli['DiskonPelunasan'] = $discPelunasan;
			$dataNotaBeli['TanggalBatasDiskon'] = $batasPelunasan;
			$dataNotaBeli['TanggalJatuhTempo'] = $tanggalJatuhTempo;
		}
		else{
			$jenisPembayaran = $this->input->post('jPembayaran');

			$dataNotaBeli['JenisPembayaran'] = $jenisPembayaran;
		}
		if($this->input->post('disc')!=''){
			$disc = $this->input->post('disc');

			$dataNotaBeli['Diskon'] = $disc;
		}
		if($this->input->post('bank')!=''){
			$bank = $this->input->post('bank');

			$dataNotaBeli['IdBank'] = $bank;
		}

		$total = $this->input->post('total');
		$bayar = $this->input->post('bayar');

		$dataNotaBeli['Total'] = $total;
		$dataNotaBeli['Bayar'] = $bayar;


		if($this->NotaBeli_model->add_nota_beli($dataNotaBeli)){
			//Untuk mengisi data pada table pembelian
			foreach($this->cart->contents() as $item){
				$datapembelian = array(
					'NoNotaBeli' => $NoNotaBeli,
					'KodeBarang' => $item['id'],
					'Harga' => $item['price'],
					'Jumlah' => $item['qty'],
				);

				$this->Pembelian_model->add_pembelian($datapembelian);
			}
			header("Location: ".site_url('Pembelian/index'));
		}
		echo $dataNotaBeli['Tanggal'];

	}

	//untuk mengisi keranjang belanja
	public function add_cart(){
		$barang = $this->Barang_model->get_barang($_POST['id_barang']);
		$data = array(
			'id' => $barang['KodeBarang'],
			'qty' => $_POST['jumlah'],
			'price' => $_POST['harga'],
			'name' => $barang['Nama']
		);

		$this->cart->insert($data);

		echo $this->view();
	}
	public function view(){
		$output="";
		$count =0;
		foreach ($this->cart->contents() as $value){
			$count++;
			$output.='
				<tr>
					<td>'.$count.'</td>
					<td>'.$value['name'].'</td>
					<td>'.$value['qty'].'</td>
					<td>Rp. '.$value['price'].'</td>
					<td>Rp. '.$value['subtotal'].'</td>
					<td align="center ">
						<button type="button" class="btn btn-danger btn-xs hapus-barang" name="hapus" id="'.$value['rowid'].'">hapus</button>
					</td>
				</tr>
			';
		}

		$output.='
			<tr>
				<td colspan="4">Total</td>
				<td colspan="2" align="center">Rp. '.$this->cart->total().'</td>
			</tr>
			<input type="hidden" form="form_pembelian" id="idTotal" name="total" value="'.$this->cart->total().'">
		';

		if($count==0)
			$output='';

		return $output;
	}
	public function load(){
		echo $this->view();
	}
	public function remove(){
		$rowid = $_POST['row_id'];
		$data = array(
			'rowid' => $rowid,
			'qty' =>0
		);
		$this->cart->update($data);
		echo $this->view();
	}
	public function clear_cart(){
		$this->cart->destroy();
		echo $this->view();
	}
}
