<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller

{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Model_laporan');
    }

    public function lapproject()
    {
        $data['project'] = $this->db->get('project');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('laporan/list_project', $data);
        $this->load->view('template/footer');
    }

    public function project()
    {
        $id = $this->input->post('project');
        if ($id == "all") {
            if (isset($_POST['pdf'])) {

                $this->load->library('pdf');
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "laporan-project-all.pdf";
                $data['project'] = $this->Model_laporan->project()->result();

                $this->pdf->load_view('laporan/laporan_pdf_all', $data);
            } else if (isset($_POST['excel'])) {

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = [
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ]
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_cols = [
                    'font' => ['bold' => true], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ],
                    'fill' => array(
                        'fillType' => (\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID),
                        'startColor' => array('argb' => 'FF4F81BD')
                    )
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ]
                ];

                $noa = 2;
                $project = $this->Model_laporan->project()->result();
                foreach ($project as $p) :

                    $sheet->mergeCells('B' . $noa . ':E' . $noa);
                    $sheet->setCellValue('B' . $noa, $p->nama_project);
                    $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_col);

                    $noa = $noa + 2;
                    $sheet->mergeCells('B' . $noa . ':E' . $noa);
                    $sheet->setCellValue('B' . $noa, 'DETAIL');
                    $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_cols);

                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Nama Project');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, $p->nama_project);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Jenis Project');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, $p->jenis_project);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Kontrak');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $this->db->join('base_kontrak', 'base_kontrak.id_bKontrak = kontrak.nama_kontrak');
                    $q = $this->db->get_where('kontrak', 'id_project = ' . $p->id);
                    if ($q->num_rows() > 0) {
                        $w = $q->row()->lama . " " . $q->row()->satuan;
                    } else {
                        $w = "";
                    }
                    $sheet->setCellValue('D' . $noa, $w);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Marketing');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, $p->marketing);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':E' . $noa);
                    $sheet->setCellValue('B' . $noa, 'REQUIREMENTS');
                    $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_cols);

                    $aplikasi = $this->db->get_where('aplikasi', 'id_project =' . $p->id)->row();
                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Nama Produk');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, $aplikasi->nama_aplikasi);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa = $noa + 1;
                    $modul = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $aplikasi->id_aplikasi);
                    $as = $modul->num_rows();
                    $no = $noa - 1 + $as;
                    $ha = 0;
                    $sheet->mergeCells('B' . $noa . ':C' . $no);
                    $sheet->setCellValue('B' . $noa, 'Modul');
                    $sheet->getStyle('B' . $noa . ':C' . $no)->applyFromArray($style_row);
                    foreach ($modul->result() as $m) {
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, $m->nama_modul);
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa++;

                        $sub = $this->db->get_where('sub_modul', 'id_x_aplikasi =' . $m->id_x_aplikasi);
                        $ha = $ha + $sub->num_rows();
                    }
                    $a = $noa - 1;
                    if ($ha > 0) {
                        $te = $a + $ha;
                        $sheet->mergeCells('B' . $noa . ':C' . $te);
                        $sheet->setCellValue('B' . $noa, 'Sub Modul');
                        $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                        foreach ($modul->result() as $m) {
                            $sub = $this->db->get_where('sub_modul', 'id_x_aplikasi =' . $m->id_x_aplikasi);

                            foreach ($sub->result() as $ub) {
                                $sheet->mergeCells('D' . $noa . ':E' . $noa);
                                $sheet->setCellValue('D' . $noa, $ub->nama_sub);
                                $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                                $noa++;
                            }
                        }
                    } else {
                        $sheet->mergeCells('B' . $noa . ':C' . $noa);
                        $sheet->setCellValue('B' . $noa, 'Sub Modul');
                        $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, '');
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa = $noa + 1;
                    }


                    $sheet->mergeCells('B' . $noa . ':E' . $noa);
                    $sheet->setCellValue('B' . $noa, 'PELAKSANA');
                    $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_cols);

                    $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                    $this->db->where('pelaksana.jabatan = "penjab"');
                    $penjab = $this->db->get_where('x_pelaksana', 'id_project =' . $p->id);
                    $jmlpen = $penjab->num_rows();
                    //echo $jmlp;
                    $noa = $noa + 1;
                    if ($jmlpen > 0) {
                        $te = $noa - 1 + $jmlpen;
                        $sheet->mergeCells('B' . $noa . ':C' . $te);
                        $sheet->setCellValue('B' . $noa, 'Penanggung Jawab');
                        $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                        foreach ($penjab->result() as $pe) {
                            $sheet->mergeCells('D' . $noa . ':E' . $noa);
                            $sheet->setCellValue('D' . $noa, $pe->nama);
                            $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                            $noa++;
                        }
                    } else {
                        $sheet->mergeCells('B' . $noa . ':C' . $noa);
                        $sheet->setCellValue('B' . $noa, 'Penanggung Jawab');
                        $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, '');
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa = $noa + 1;
                    }

                    $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                    $this->db->where('pelaksana.jabatan = "pic"');
                    $pic = $this->db->get_where('x_pelaksana', 'id_project =' . $p->id);
                    $jmlpi = $pic->num_rows();

                    if ($jmlpi > 0) {
                        $te = $noa - 1 + $jmlpi;
                        $sheet->mergeCells('B' . $noa . ':C' . $te);
                        $sheet->setCellValue('B' . $noa, 'PIC');
                        $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                        foreach ($pic->result() as $pi) {
                            $sheet->mergeCells('D' . $noa . ':E' . $noa);
                            $sheet->setCellValue('D' . $noa, $pi->nama);
                            $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                            $noa++;
                        }
                    } else {
                        $sheet->mergeCells('B' . $noa . ':C' . $noa);
                        $sheet->setCellValue('B' . $noa, 'PIC');
                        $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, '');
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa = $noa + 1;
                    }

                    $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                    $this->db->where('pelaksana.jabatan = "programmer"');
                    $programmer = $this->db->get_where('x_pelaksana', 'id_project =' . $p->id);
                    $jmlpro = $programmer->num_rows();

                    if ($jmlpro > 0) {
                        $te = $noa - 1 + $jmlpro;
                        $sheet->mergeCells('B' . $noa . ':C' . $te);
                        $sheet->setCellValue('B' . $noa, 'Programmer');
                        $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                        foreach ($programmer->result() as $pr) {
                            $sheet->mergeCells('D' . $noa . ':E' . $noa);
                            $sheet->setCellValue('D' . $noa, $pr->nama);
                            $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                            $noa++;
                        }
                    } else {
                        $sheet->mergeCells('B' . $noa . ':C' . $noa);
                        $sheet->setCellValue('B' . $noa, 'Programmer');
                        $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, '');
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa = $noa + 1;
                    }

                    $noa = $noa + 2;
                endforeach;
                $writer = new Xlsx($spreadsheet);
                $filename = 'laporan-project';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');
            }
        } else if (empty($id)) {
            echo "<script>alert('Anda Belum Memilih');
            close();</script>";
        } else {

            if (isset($_POST['pdf'])) {
                $this->load->library('pdf');
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "laporan-project.pdf";
                $data['project'] = $this->Model_laporan->project($id)->row();
                $pro = $data['project']->id;
                $data['aplikasi'] = $this->Model_laporan->aplikasi($pro)->row();
                $mo =  $data['aplikasi']->id_aplikasi;
                $data['modul'] = $this->Model_laporan->modul($mo);
                $data['penjab'] = $this->Model_laporan->pelaksana($id, "penjab")->result_array();
                $data['pic'] = $this->Model_laporan->pelaksana($id, "pic")->result_array();
                $data['programmer'] = $this->Model_laporan->pelaksana($id, "programmer")->result_array();

                $this->pdf->load_view('laporan/laporan_pdf', $data);
            } else if (isset($_POST['excel'])) {

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = [
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ]
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_cols = [
                    'font' => ['bold' => true], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ],
                    'fill' => array(
                        'fillType' => (\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID),
                        'startColor' => array('argb' => 'FF4F81BD')
                    )
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ]
                ];

                $project = $this->Model_laporan->project($id)->row();
                $aplikasi = $this->Model_laporan->aplikasi($project->id)->row();
                $modul = $this->Model_laporan->modul($aplikasi->id_aplikasi);
                $penjab = $this->Model_laporan->pelaksana($id, "penjab");
                $pic = $this->Model_laporan->pelaksana($id, "pic");
                $programmer = $this->Model_laporan->pelaksana($id, "programmer");


                $sheet->mergeCells('B2:E2');
                $sheet->setCellValue('B2', $project->nama_project);
                $sheet->getStyle('B2:E2')->applyFromArray($style_col);

                $sheet->mergeCells('B4:E4');
                $sheet->setCellValue('B4', 'DETAIL');
                $sheet->getStyle('B4:E4')->applyFromArray($style_cols);

                $sheet->mergeCells('B5:C5');
                $sheet->setCellValue('B5', 'Nama Project');
                $sheet->getStyle('B5:C5')->applyFromArray($style_row);
                $sheet->mergeCells('D5:E5');
                $sheet->setCellValue('D5', $project->nama_project);
                $sheet->getStyle('D5:E5')->applyFromArray($style_row);

                $sheet->mergeCells('B6:C6');
                $sheet->setCellValue('B6', 'Jenis Project');
                $sheet->getStyle('B6:C6')->applyFromArray($style_row);
                $sheet->mergeCells('D6:E6');
                $sheet->setCellValue('D6', $project->jenis_project);
                $sheet->getStyle('D6:E6')->applyFromArray($style_row);

                $sheet->mergeCells('B7:C7');
                $sheet->setCellValue('B7', 'Kontrak');
                $sheet->getStyle('B7:C7')->applyFromArray($style_row);
                $sheet->mergeCells('D7:E7');
                $this->db->join('base_kontrak', 'base_kontrak.id_bKontrak = kontrak.nama_kontrak');
                $q = $this->db->get_where('kontrak', 'id_project = ' . $id);
                if ($q->num_rows() > 0) {
                    $w = $q->row()->lama . " " . $q->row()->satuan;
                } else {
                    $w = "";
                }
                $sheet->setCellValue('D7', $w);
                $sheet->getStyle('D7:E7')->applyFromArray($style_row);

                $sheet->mergeCells('B8:C8');
                $sheet->setCellValue('B8', 'Marketing');
                $sheet->getStyle('B8:C8')->applyFromArray($style_row);
                $sheet->mergeCells('D8:E8');
                $sheet->setCellValue('D8', $project->marketing);
                $sheet->getStyle('D8:E8')->applyFromArray($style_row);

                $sheet->mergeCells('B9:E9');
                $sheet->setCellValue('B9', 'REQUIREMENTS');
                $sheet->getStyle('B9:E9')->applyFromArray($style_cols);

                $sheet->mergeCells('B10:C10');
                $sheet->setCellValue('B10', 'Nama Produk');
                $sheet->getStyle('B10:C10')->applyFromArray($style_row);
                $sheet->mergeCells('D10:E10');
                $sheet->setCellValue('D10', $aplikasi->nama_aplikasi);
                $sheet->getStyle('D10:E10')->applyFromArray($style_row);

                $noa = 11;
                $as = $modul->num_rows();
                $no = 10 + $as;
                $ha = 0;
                $sheet->mergeCells('B11:C' . $no);
                $sheet->setCellValue('B11', 'Modul');
                $sheet->getStyle('B11:C' . $no)->applyFromArray($style_row);
                foreach ($modul->result() as $m) {
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, $m->nama_modul);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                    $noa++;

                    $sub = $this->db->get_where('sub_modul', 'id_x_aplikasi =' . $m->id_x_aplikasi);
                    $ha = $ha + $sub->num_rows();
                }
                $a = $noa - 1;
                if ($ha > 0) {
                    $te = $a + $ha;
                    $sheet->mergeCells('B' . $noa . ':C' . $te);
                    $sheet->setCellValue('B' . $noa, 'Sub Modul');
                    $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                    foreach ($modul->result() as $m) {
                        $sub = $this->db->get_where('sub_modul', 'id_x_aplikasi =' . $m->id_x_aplikasi);

                        foreach ($sub->result() as $ub) {
                            $sheet->mergeCells('D' . $noa . ':E' . $noa);
                            $sheet->setCellValue('D' . $noa, $ub->nama_sub);
                            $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                            $noa++;
                        }
                    }
                } else {
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Sub Modul');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, '');
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                    $noa = $noa + 1;
                }


                $sheet->mergeCells('B' . $noa . ':E' . $noa);
                $sheet->setCellValue('B' . $noa, 'PELAKSANA');
                $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_cols);

                $jmlpen = $penjab->num_rows();
                //echo $jmlp;
                $noa = $noa + 1;
                if ($jmlpen > 0) {
                    $te = $noa - 1 + $jmlpen;
                    $sheet->mergeCells('B' . $noa . ':C' . $te);
                    $sheet->setCellValue('B' . $noa, 'Penanggung Jawab');
                    $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                    foreach ($penjab->result() as $p) {
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, $p->nama);
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa++;
                    }
                } else {
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Penanggung Jawab');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, '');
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                    $noa = $noa + 1;
                }

                $jmlpi = $pic->num_rows();

                if ($jmlpi > 0) {
                    $te = $noa - 1 + $jmlpi;
                    $sheet->mergeCells('B' . $noa . ':C' . $te);
                    $sheet->setCellValue('B' . $noa, 'PIC');
                    $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                    foreach ($pic->result() as $p) {
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, $p->nama);
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa++;
                    }
                } else {
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'PIC');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, '');
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                    $noa = $noa + 1;
                }

                $jmlpro = $programmer->num_rows();

                if ($jmlpro > 0) {
                    $te = $noa - 1 + $jmlpro;
                    $sheet->mergeCells('B' . $noa . ':C' . $te);
                    $sheet->setCellValue('B' . $noa, 'Programmer');
                    $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                    foreach ($programmer->result() as $p) {
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, $p->nama);
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa++;
                    }
                } else {
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Programmer');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, '');
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                    $noa = $noa + 1;
                }

                $writer = new Xlsx($spreadsheet);
                $filename = 'laporan-project';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');
            }
        }
    }


    public function lapkin()
    {
        $data['programmer'] = $this->db->get_where('pelaksana', 'jabatan = "programmer"');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('laporan/list_programmer', $data);
        $this->load->view('template/footer');
    }

    public function orang()
    {
        $id = $_POST['orang'];
        if ($id == "all") {
            if (isset($_POST['pdf'])) {
                $this->load->library('pdf');
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "laporan-kinerja_all.pdf";

                $data['pelaksana'] = $this->Model_laporan->pelaksanaa()->result();
                $this->pdf->load_view('laporan/lapkin_pdf_all', $data);
            } else if (isset($_POST['excel'])) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);

                $style_col = [
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ]
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_cols = [
                    'font' => ['bold' => true], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ],
                    'fill' => array(
                        'fillType' => (\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID),
                        'startColor' => array('argb' => 'FF4F81BD')
                    )
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ]
                ];

                $pelaksana = $this->Model_laporan->pelaksanaa()->result();

                $sheet->mergeCells('A2:E2');
                $sheet->setCellValue('A2', 'LAPORAN KINERJA');
                $sheet->getStyle('A2:E2')->applyFromArray($style_col);
                $no = 4;
                foreach ($pelaksana as $pel) :
                    $sheet->setCellValue('A' . $no, 'Nama');
                    $sheet->setCellValue('B' . $no, ':');
                    $sheet->setCellValue('C' . $no, $pel->nama);

                    $no = $no + 1;
                    $sheet->setCellValue('A' . $no, 'Jabatan');
                    $sheet->setCellValue('B' . $no, ':');
                    $sheet->setCellValue('C' . $no, 'Programmer');

                    $no = $no + 2;
                    $this->db->join('project', 'project.id = x_pelaksana.id_project');
                    $this->db->join('aplikasi', 'aplikasi.id_project = project.id');
                    $project =  $this->db->get_where('x_pelaksana', 'id_pelaksana = ' . $pel->id_pelaksana);
                    foreach ($project->result() as  $pe) {

                        $sheet->mergeCells('A' . $no . ':E' . $no);
                        $sheet->setCellValue('A' . $no, $pe->nama_project . ' | ' . $pe->nama_aplikasi);
                        $sheet->getStyle('A' . $no . ':E' . $no)->applyFromArray($style_cols);

                        $no = $no + 1;
                        $sheet->mergeCells('A' . $no . ':C' . $no);
                        $sheet->setCellValue('A' . $no, 'Modul');
                        $sheet->getStyle('A' . $no . ':C' . $no)->applyFromArray($style_cols);

                        $sheet->setCellValue('D' . $no, 'Sub Modul');
                        $sheet->getStyle('D' . $no)->applyFromArray($style_cols);

                        $sheet->setCellValue('E' . $no, 'Keterangan');
                        $sheet->getStyle('E' . $no)->applyFromArray($style_cols);

                        $no = $no + 1;

                        $this->db->join('x_pelmodul', 'x_pelmodul.id_x_aplikasi = x_aplikasi.id_x_aplikasi');
                        $mod = $this->db->get_where('x_aplikasi', ['id_aplikasi  ' => $pe->id_aplikasi, 'id_pelaksana' => $pel->id_pelaksana]);
                        foreach ($mod->result() as $m) {
                            $sub = $this->db->get_where('sub_modul', 'id_x_aplikasi = ' . $m->id_x_aplikasi);
                            $jml = $sub->num_rows();
                            if ($jml > 0) {
                                $t = $jml - 1 + $no;
                                $sheet->mergeCells('A' . $no . ':C' . $t);
                                $sheet->setCellValue('A' . $no, $m->nama_modul);
                                $sheet->getStyle('A' . $no . ':C' . $t)->applyFromArray($style_row);

                                foreach ($sub->result() as $s) {
                                    $sheet->setCellValue('D' . $no, $s->nama_sub);
                                    $sheet->getStyle('D' . $no)->applyFromArray($style_row);

                                    if ($s->status == 0) {
                                        $status = "Belum Selesai";
                                    } else if ($s->status == 1) {
                                        $status = "Proses";
                                    } else {
                                        $status = "Selesai";
                                    }
                                    $sheet->setCellValue('E' . $no, $status);
                                    $sheet->getStyle('E' . $no)->applyFromArray($style_row);
                                    $no++;
                                }
                                $no = $t;
                            } else {
                                $sheet->mergeCells('A' . $no . ':C' . $no);
                                $sheet->setCellValue('A' . $no, $m->nama_modul);
                                $sheet->getStyle('A' . $no . ':C' . $no)->applyFromArray($style_row);

                                $sheet->setCellValue('D' . $no, '');
                                $sheet->getStyle('D' . $no)->applyFromArray($style_row);

                                $sheet->setCellValue('E' . $no, '');
                                $sheet->getStyle('E' . $no)->applyFromArray($style_row);
                            }
                            $no++;
                        }
                        $no = $no + 2;
                    }
                endforeach;

                $writer = new Xlsx($spreadsheet);
                $filename = 'laporan-kinerja';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');
            }
        } else if (empty($id)) {
            echo "<script>alert('Anda Belum Memilih');
            close();</script>";
        } else {
            if (isset($_POST['pdf'])) {
                $this->load->library('pdf');
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "laporan-kinerja.pdf";

                $data['pelaksana'] = $this->Model_laporan->pelaksanaa($id)->row_array();
                $data['project'] = $this->Model_laporan->pro($id)->result();

                $this->pdf->load_view('laporan/lapkin_pdf', $data);
            } else if (isset($_POST['excel'])) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);

                $style_col = [
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ]
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_cols = [
                    'font' => ['bold' => true], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ],
                    'fill' => array(
                        'fillType' => (\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID),
                        'startColor' => array('argb' => 'FF4F81BD')
                    )
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ]
                ];

                $pelaksana = $this->Model_laporan->pelaksanaa($id)->row_array();
                $project = $this->Model_laporan->pro($id)->result();

                $sheet->mergeCells('A2:E2');
                $sheet->setCellValue('A2', 'LAPORAN KINERJA');
                $sheet->getStyle('A2:E2')->applyFromArray($style_col);

                $sheet->setCellValue('A4', 'Nama');
                $sheet->setCellValue('B4', ':');
                $sheet->setCellValue('C4', $pelaksana['nama']);
                $sheet->setCellValue('A5', 'Jabatan');
                $sheet->setCellValue('B5', ':');
                $sheet->setCellValue('C5', 'Programmer');

                $no = 7;
                foreach ($project as  $pe) {

                    $sheet->mergeCells('A' . $no . ':E' . $no);
                    $sheet->setCellValue('A' . $no, $pe->nama_project . ' | ' . $pe->nama_aplikasi);
                    $sheet->getStyle('A' . $no . ':E' . $no)->applyFromArray($style_cols);

                    $no = $no + 1;
                    $sheet->mergeCells('A' . $no . ':C' . $no);
                    $sheet->setCellValue('A' . $no, 'Modul');
                    $sheet->getStyle('A' . $no . ':C' . $no)->applyFromArray($style_cols);

                    $sheet->setCellValue('D' . $no, 'Sub Modul');
                    $sheet->getStyle('D' . $no)->applyFromArray($style_cols);

                    $sheet->setCellValue('E' . $no, 'Keterangan');
                    $sheet->getStyle('E' . $no)->applyFromArray($style_cols);

                    $no = $no + 1;

                    $this->db->join('x_pelmodul', 'x_pelmodul.id_x_aplikasi = x_aplikasi.id_x_aplikasi');
                    $mod = $this->db->get_where('x_aplikasi', ['id_aplikasi  ' => $pe->id_aplikasi, 'id_pelaksana' => $pelaksana['id_pelaksana']]);
                    foreach ($mod->result() as $m) {
                        $sub = $this->db->get_where('sub_modul', 'id_x_aplikasi = ' . $m->id_x_aplikasi);
                        $jml = $sub->num_rows();
                        if ($jml > 0) {
                            $t = $jml - 1 + $no;
                            $sheet->mergeCells('A' . $no . ':C' . $t);
                            $sheet->setCellValue('A' . $no, $m->nama_modul);
                            $sheet->getStyle('A' . $no . ':C' . $t)->applyFromArray($style_row);

                            foreach ($sub->result() as $s) {
                                $sheet->setCellValue('D' . $no, $s->nama_sub);
                                $sheet->getStyle('D' . $no)->applyFromArray($style_row);

                                if ($s->status == 0) {
                                    $status = "Belum Selesai";
                                } else if ($s->status == 1) {
                                    $status = "Proses";
                                } else {
                                    $status = "Selesai";
                                }
                                $sheet->setCellValue('E' . $no, $status);
                                $sheet->getStyle('E' . $no)->applyFromArray($style_row);
                                $no++;
                            }
                            $no = $t;
                        } else {
                            $sheet->mergeCells('A' . $no . ':C' . $no);
                            $sheet->setCellValue('A' . $no, $m->nama_modul);
                            $sheet->getStyle('A' . $no . ':C' . $no)->applyFromArray($style_row);

                            $sheet->setCellValue('D' . $no, '');
                            $sheet->getStyle('D' . $no)->applyFromArray($style_row);

                            $sheet->setCellValue('E' . $no, '');
                            $sheet->getStyle('E' . $no)->applyFromArray($style_row);
                        }
                        $no++;
                    }
                    $no = $no + 2;
                }


                $writer = new Xlsx($spreadsheet);
                $filename = 'laporan-kinerja';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');
            }
        }
    }

    public function lapbug()
    {
        $data['project'] = $this->Model_laporan->project();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('laporan/list_bug', $data);
        $this->load->view('template/footer');
    }

    public function bug()
    {
        $id = $this->input->post('project');
        if ($id == "all") {
            if (isset($_POST['pdf'])) {
                $this->load->library('pdf');
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "laporan-bug.pdf";
                $data['project'] = $this->Model_laporan->project()->result();

                $this->pdf->load_view('laporan/laporan_bug_pdf_all', $data);
            } else if (isset($_POST['excel'])) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = [
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ]
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_cols = [
                    'font' => ['bold' => true], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ],
                    'fill' => array(
                        'fillType' => (\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID),
                        'startColor' => array('argb' => 'FF4F81BD')
                    )
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ]
                ];

                $project = $this->Model_laporan->project()->result();

                $noa = 2;

                foreach ($project as $pro) {

                    $sheet->mergeCells('B' . $noa . ':E' . $noa);
                    $sheet->setCellValue('B' . $noa, $pro->nama_project);
                    $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_col);

                    $noa  = $noa + 2;
                    $sheet->mergeCells('B' . $noa . ':E' . $noa);
                    $sheet->setCellValue('B' . $noa, 'DETAIL');
                    $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_cols);

                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Nama Project');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, $pro->nama_project);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa =  $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Jenis Project');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, $pro->jenis_project);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Kontrak');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $this->db->join('base_kontrak', 'base_kontrak.id_bKontrak = kontrak.nama_kontrak');
                    $q = $this->db->get_where('kontrak', 'id_project = ' . $pro->id);
                    if ($q->num_rows() > 0) {
                        $w = $q->row()->lama . " " . $q->row()->satuan;
                    } else {
                        $w = "";
                    }
                    $sheet->setCellValue('D' . $noa, $w);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Marketing');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, $pro->marketing);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa = $noa + 1;
                    $aplikasi = $this->db->get_where('aplikasi', 'id_project =' . $pro->id)->row();
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Nama Produk');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, $aplikasi->nama_aplikasi);
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);

                    $noa = $noa + 1;
                    $sheet->mergeCells('B' . $noa . ':E' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Daftar Bugs');
                    $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_cols);

                    $noa = $noa + 1;
                    $sheet->setCellValue('B' . $noa, 'Modul');
                    $sheet->getStyle('B' . $noa)->applyFromArray($style_cols);


                    $sheet->setCellValue('C' . $noa, 'Sub Modul');
                    $sheet->getStyle('C' . $noa)->applyFromArray($style_cols);

                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, 'Keterangan');
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_cols);

                    $noa = $noa + 1;

                    $modul = $this->db->get_where('x_aplikasi', 'id_aplikasi =' . $aplikasi->id_aplikasi);
                    foreach ($modul->result() as $mod) {
                        $sub =  $this->db->get_where('sub_modul', ['id_x_aplikasi  ' => $mod->id_x_aplikasi, 'keterangan != ' => '']);
                        $jml = $sub->num_rows();
                        $no = $noa - 1 + $jml;
                        // var_dump($noa, $jml);
                        if ($jml > 0) {
                            $sheet->mergeCells('B' . $noa . ':B' . $no);
                            $sheet->setCellValue('B' . $noa, $mod->nama_modul);
                            $sheet->getStyle('B' . $noa . ':B' . $no)->applyFromArray($style_row);

                            foreach ($sub->result() as $s) {
                                $sheet->setCellValue('C' . $noa, $s->nama_sub);
                                $sheet->getStyle('c' . $noa)->applyFromArray($style_row);

                                $sheet->mergeCells('D' . $noa . ':E' . $noa);
                                $sheet->setCellValue('D' . $noa, $s->keterangan);
                                $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                                $noa++;
                            }
                            $noa = $no + 1;
                        }
                    }


                    $sheet->mergeCells('B' . $noa . ':E' . $noa);
                    $sheet->setCellValue('B' . $noa, 'PELAKSANA');
                    $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_cols);

                    $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                    $this->db->where('pelaksana.jabatan = "penjab"');
                    $penjab = $this->db->get_where('x_pelaksana', 'id_project =' . $pro->id);
                    $jmlpen = $penjab->num_rows();

                    $noa = $noa + 1;
                    if ($jmlpen > 0) {
                        $te = $noa - 1 + $jmlpen;
                        $sheet->mergeCells('B' . $noa . ':C' . $te);
                        $sheet->setCellValue('B' . $noa, 'Penanggung Jawab');
                        $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                        foreach ($penjab->result() as $p) {
                            $sheet->mergeCells('D' . $noa . ':E' . $noa);
                            $sheet->setCellValue('D' . $noa, $p->nama);
                            $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                            $noa++;
                        }
                    } else {
                        $sheet->mergeCells('B' . $noa . ':C' . $noa);
                        $sheet->setCellValue('B' . $noa, 'Penanggung Jawab');
                        $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, '');
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa = $noa + 1;
                    }


                    $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                    $this->db->where('pelaksana.jabatan = "pic"');
                    $pic = $this->db->get_where('x_pelaksana', 'id_project =' . $pro->id);
                    $jmlpi = $pic->num_rows();

                    if ($jmlpi > 0) {
                        $te = $noa - 1 + $jmlpi;
                        $sheet->mergeCells('B' . $noa . ':C' . $te);
                        $sheet->setCellValue('B' . $noa, 'PIC');
                        $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                        foreach ($pic->result() as $p) {
                            $sheet->mergeCells('D' . $noa . ':E' . $noa);
                            $sheet->setCellValue('D' . $noa, $p->nama);
                            $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                            $noa++;
                        }
                    } else {
                        $sheet->mergeCells('B' . $noa . ':C' . $noa);
                        $sheet->setCellValue('B' . $noa, 'PIC');
                        $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, '');
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa = $noa + 1;
                    }


                    $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                    $this->db->where('pelaksana.jabatan = "programmer"');
                    $programmer = $this->db->get_where('x_pelaksana', 'id_project =' . $pro->id);
                    $jmlpro = $programmer->num_rows();

                    if ($jmlpro > 0) {
                        $te = $noa - 1 + $jmlpro;
                        $sheet->mergeCells('B' . $noa . ':C' . $te);
                        $sheet->setCellValue('B' . $noa, 'Programmer');
                        $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                        foreach ($programmer->result() as $p) {
                            $sheet->mergeCells('D' . $noa . ':E' . $noa);
                            $sheet->setCellValue('D' . $noa, $p->nama);
                            $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                            $noa++;
                        }
                    } else {
                        $sheet->mergeCells('B' . $noa . ':C' . $noa);
                        $sheet->setCellValue('B' . $noa, 'Programmer');
                        $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, '');
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa = $noa + 1;
                    }

                    $noa = $noa + 2;
                }

                $writer = new Xlsx($spreadsheet);
                $filename = 'laporan-project';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');
            }
        } else if (empty($id)) {
            echo "<script>alert('Anda belum memilih');
                    close(); </script>";
        } else {
            if (isset($_POST['pdf'])) {
                $this->load->library('pdf');
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "laporan-bug.pdf";
                $data['project'] = $this->Model_laporan->project($id)->row();
                $pro = $data['project']->id;
                $data['aplikasi'] = $this->Model_laporan->aplikasi($pro)->row();
                $mo =  $data['aplikasi']->id_aplikasi;
                $data['modul'] = $this->Model_laporan->modul($mo);
                $data['penjab'] = $this->Model_laporan->pelaksana($id, "penjab")->result_array();
                $data['pic'] = $this->Model_laporan->pelaksana($id, "pic")->result_array();
                $data['programmer'] = $this->Model_laporan->pelaksana($id, "programmer")->result_array();

                $this->pdf->load_view('laporan/laporan_bug_pdf', $data);
            } else if (isset($_POST['excel'])) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = [
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ]
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_cols = [
                    'font' => ['bold' => true], // Set font nya jadi bold
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ],
                    'fill' => array(
                        'fillType' => (\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID),
                        'startColor' => array('argb' => 'FF4F81BD')
                    )
                ];

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                    ]
                ];

                $project = $this->Model_laporan->project($id)->row();
                $aplikasi = $this->Model_laporan->aplikasi($project->id)->row();
                $modul = $this->Model_laporan->modul($aplikasi->id_aplikasi);
                $penjab = $this->Model_laporan->pelaksana($id, "penjab");
                $pic = $this->Model_laporan->pelaksana($id, "pic");
                $programmer = $this->Model_laporan->pelaksana($id, "programmer");


                $sheet->mergeCells('B2:E2');
                $sheet->setCellValue('B2', $project->nama_project);
                $sheet->getStyle('B2:E2')->applyFromArray($style_col);

                $sheet->mergeCells('B4:E4');
                $sheet->setCellValue('B4', 'DETAIL');
                $sheet->getStyle('B4:E4')->applyFromArray($style_cols);

                $sheet->mergeCells('B5:C5');
                $sheet->setCellValue('B5', 'Nama Project');
                $sheet->getStyle('B5:C5')->applyFromArray($style_row);
                $sheet->mergeCells('D5:E5');
                $sheet->setCellValue('D5', $project->nama_project);
                $sheet->getStyle('D5:E5')->applyFromArray($style_row);

                $sheet->mergeCells('B6:C6');
                $sheet->setCellValue('B6', 'Jenis Project');
                $sheet->getStyle('B6:C6')->applyFromArray($style_row);
                $sheet->mergeCells('D6:E6');
                $sheet->setCellValue('D6', $project->jenis_project);
                $sheet->getStyle('D6:E6')->applyFromArray($style_row);

                $sheet->mergeCells('B7:C7');
                $sheet->setCellValue('B7', 'Kontrak');
                $sheet->getStyle('B7:C7')->applyFromArray($style_row);
                $sheet->mergeCells('D7:E7');
                $this->db->join('base_kontrak', 'base_kontrak.id_bKontrak = kontrak.nama_kontrak');
                $q = $this->db->get_where('kontrak', 'id_project = ' . $id);
                if ($q->num_rows() > 0) {
                    $w = $q->row()->lama . " " . $q->row()->satuan;
                } else {
                    $w = "";
                }
                $sheet->setCellValue('D7', $w);
                $sheet->getStyle('D7:E7')->applyFromArray($style_row);

                $sheet->mergeCells('B8:C8');
                $sheet->setCellValue('B8', 'Marketing');
                $sheet->getStyle('B8:C8')->applyFromArray($style_row);
                $sheet->mergeCells('D8:E8');
                $sheet->setCellValue('D8', $project->marketing);
                $sheet->getStyle('D8:E8')->applyFromArray($style_row);

                $sheet->mergeCells('B9:C9');
                $sheet->setCellValue('B9', 'Nama Produk');
                $sheet->getStyle('B9:C9')->applyFromArray($style_row);
                $sheet->mergeCells('D9:E9');
                $sheet->setCellValue('D9', $aplikasi->nama_aplikasi);
                $sheet->getStyle('D9:E9')->applyFromArray($style_row);

                $sheet->mergeCells('B10:E10');
                $sheet->setCellValue('B10', 'Daftar Bugs');
                $sheet->getStyle('B10:E10')->applyFromArray($style_cols);


                $sheet->setCellValue('B11', 'Modul');
                $sheet->getStyle('B11')->applyFromArray($style_cols);


                $sheet->setCellValue('C11', 'Sub Modul');
                $sheet->getStyle('C11')->applyFromArray($style_cols);

                $sheet->mergeCells('D11:E11');
                $sheet->setCellValue('D11', 'Keterangan');
                $sheet->getStyle('D11:E11')->applyFromArray($style_cols);

                $noa = 12;


                foreach ($modul->result() as $mod) {
                    $sub =  $this->db->get_where('sub_modul', ['id_x_aplikasi  ' => $mod->id_x_aplikasi, 'keterangan != ' => '']);
                    $jml = $sub->num_rows();
                    $no = $noa - 1 + $jml;
                    // var_dump($noa, $jml);
                    if ($jml > 0) {
                        $sheet->mergeCells('B' . $noa . ':B' . $no);
                        $sheet->setCellValue('B' . $noa, $mod->nama_modul);
                        $sheet->getStyle('B' . $noa . ':B' . $no)->applyFromArray($style_row);

                        foreach ($sub->result() as $s) {
                            $sheet->setCellValue('C' . $noa, $s->nama_sub);
                            $sheet->getStyle('c' . $noa)->applyFromArray($style_row);

                            $sheet->mergeCells('D' . $noa . ':E' . $noa);
                            $sheet->setCellValue('D' . $noa, $s->keterangan);
                            $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                            $noa++;
                        }
                        $noa = $no + 1;
                    }
                }


                $sheet->mergeCells('B' . $noa . ':E' . $noa);
                $sheet->setCellValue('B' . $noa, 'PELAKSANA');
                $sheet->getStyle('B' . $noa . ':E' . $noa)->applyFromArray($style_cols);

                $jmlpen = $penjab->num_rows();

                $noa = $noa + 1;
                if ($jmlpen > 0) {
                    $te = $noa - 1 + $jmlpen;
                    $sheet->mergeCells('B' . $noa . ':C' . $te);
                    $sheet->setCellValue('B' . $noa, 'Penanggung Jawab');
                    $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                    foreach ($penjab->result() as $p) {
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, $p->nama);
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa++;
                    }
                } else {
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Penanggung Jawab');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, '');
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                    $noa = $noa + 1;
                }

                $jmlpi = $pic->num_rows();

                if ($jmlpi > 0) {
                    $te = $noa - 1 + $jmlpi;
                    $sheet->mergeCells('B' . $noa . ':C' . $te);
                    $sheet->setCellValue('B' . $noa, 'PIC');
                    $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                    foreach ($pic->result() as $p) {
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, $p->nama);
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa++;
                    }
                } else {
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'PIC');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, '');
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                    $noa = $noa + 1;
                }

                $jmlpro = $programmer->num_rows();

                if ($jmlpro > 0) {
                    $te = $noa - 1 + $jmlpro;
                    $sheet->mergeCells('B' . $noa . ':C' . $te);
                    $sheet->setCellValue('B' . $noa, 'Programmer');
                    $sheet->getStyle('B' . $noa . ':C' . $te)->applyFromArray($style_row);
                    foreach ($programmer->result() as $p) {
                        $sheet->mergeCells('D' . $noa . ':E' . $noa);
                        $sheet->setCellValue('D' . $noa, $p->nama);
                        $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                        $noa++;
                    }
                } else {
                    $sheet->mergeCells('B' . $noa . ':C' . $noa);
                    $sheet->setCellValue('B' . $noa, 'Programmer');
                    $sheet->getStyle('B' . $noa . ':C' . $noa)->applyFromArray($style_row);
                    $sheet->mergeCells('D' . $noa . ':E' . $noa);
                    $sheet->setCellValue('D' . $noa, '');
                    $sheet->getStyle('D' . $noa . ':E' . $noa)->applyFromArray($style_row);
                    $noa = $noa + 1;
                }

                $writer = new Xlsx($spreadsheet);
                $filename = 'laporan-project';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');
            }
        }
    }
}
