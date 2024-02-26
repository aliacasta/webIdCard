<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdCardRequest;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FillPDFController extends Controller
{
    public function store(StoreIdCardRequest $request) {
        
        // Menyimpan foto yang diunggah
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/foto', $fileName); // simpan di storage/app/public/foto
        $fotoPath = 'storage/foto/' . $fileName; // path foto untuk ditampilkan

        //Mengambil nilai dari inputan
        $nama = $request->post('nama');
        $penempatan = "MAGANG | " . $request->post('penempatan');
        $foto = $fotoPath;
        $instansi = $request->post('asal');
        $noHp = $request->post('noHp');
        $kode = $request->post('kode');

        // Menyimpan url untuk barcode
        $url = "http://118.97.163.52:8182/magang/tracking-pengajuan?kode_pengajuan=".$kode;
        $barcodePath = $this->generateBarcode($url);

        // $outputfile = public_path().'id_card.pdf';
        $nama_id_card = strtolower($nama);
        $outputfile = public_path() . '\filled_id_cards\id_card_'.$nama_id_card.'.pdf';
        $this->fillPDF(public_path().'\master\id_card.pdf', $outputfile, $nama, $penempatan, $instansi, $noHp, $barcodePath, $foto);

        // return response()->file($outputfile);
        return response()->json(['success' => true, 'pdfUrl' => asset('filled_id_cards/' . basename($outputfile))]);
    }

    public function generateBarcode($url) {

        $barcodeContent = QrCode::format('png')->size(200)->generate($url);

        // Menyimpan QR code sebagai gambar PNG
        $barcodePath = public_path('qrcode.png');

        // Simpan barcode sebagai gambar PNG
        $barcodePath = public_path('barcode.png');
        file_put_contents($barcodePath, $barcodeContent);

        return $barcodePath;
    }

    public function fillPDF($file, $outputfile, $nama, $penempatan, $instansi, $noHp, $barcode, $foto) {
        
        /* -------- HALAMAN PERTAMA -------- */

        $fpdi = new FPDI;
        $fpdi->setSourceFile($file);
        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
        $fpdi->useTemplate($template);

        //Nama
        $top1 = 23.2;
        $right1 = 3.7;
        $nama = strtoupper($nama);
        $fpdi->SetFont("helvetica","B",12);
        $fpdi->SetTextColor(255,255,255);
        $fpdi->Text($right1,$top1,$nama);

        //Asal Universitas atau Sekolah
        $top2 = 32.5;
        $right2 = 3.7;
        $instansi = strtoupper($instansi);
        $fpdi->SetFont("helvetica","B",10);
        $fpdi->SetTextColor(10,64,71);
        $fpdi->Text($right2,$top2,$instansi);

        // Load and display photo
        $fpdi->Image($foto, 2, 37, 41.5, 63.61);

        //Penempatan
        $top2 = 108;
        $right2 = 3.7;
        $fpdi->SetFont("helvetica","B",11);
        $fpdi->SetTextColor(255,255,255);
        $fpdi->Text($right2,$top2,$penempatan);

        // Memuat dan menampilkan barcode
        $barcodeX = 49.6;
        $barcodeY = 80.8;
        $fpdi->Image($barcode, $barcodeX, $barcodeY, 16);


        /* -------- HALAMAN KEDUA -------- */

        $fpdi->setSourceFile($file);
        $template = $fpdi->importPage(2);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
        $fpdi->useTemplate($template);

        //Nomor hp
        $top2 = 74.7;
        $right2 = 18.7;
        $fpdi->SetFont("helvetica","",9);
        $fpdi->SetTextColor(255,255,255);
        $fpdi->Text($right2,$top2,$noHp);

        // Memuat dan menampilkan barcode
        $barcodeX = 24.55;
        $barcodeY = 80;
        $fpdi->Image($barcode, $barcodeX, $barcodeY, 26);

        return $fpdi->Output($outputfile, 'F');
    }
}
