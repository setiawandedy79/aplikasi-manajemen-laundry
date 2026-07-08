<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    // 1. Method untuk menghitung total data (untuk pagination)
    public function count_all_transaksi($keyword = '', $pelanggan_id = null) {
        $this->db->from('transaksi_header');
        $this->db->join('pelanggan', 'pelanggan.id = transaksi_header.pelanggan_id', 'left');
        
        if (!empty($pelanggan_id)) {
            $this->db->where('transaksi_header.pelanggan_id', $pelanggan_id);
        }
        
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('transaksi_header.no_transaksi', $keyword);
            $this->db->or_like('transaksi_header.nama_pengirim', $keyword);
            $this->db->or_like('transaksi_header.nama_penerima', $keyword);
            $this->db->or_like('pelanggan.nama', $keyword);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results();
    }

    public function get_all($keyword = '', $pelanggan_id = null, $limit = null, $offset = null) {
        $this->db->select('transaksi_header.*, pelanggan.nama as nama_pelanggan, users.nama_lengkap');
        $this->db->from('transaksi_header');
        $this->db->join('pelanggan', 'pelanggan.id = transaksi_header.pelanggan_id', 'left');
        $this->db->join('users', 'users.id = transaksi_header.user_id', 'left');
        
        // Filter Unit
        if (!empty($pelanggan_id)) {
            $this->db->where('transaksi_header.pelanggan_id', $pelanggan_id);
        }
        
        // Logic Search
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('transaksi_header.no_transaksi', $keyword);
            $this->db->or_like('transaksi_header.nama_pengirim', $keyword);
            $this->db->or_like('transaksi_header.nama_penerima', $keyword);
            $this->db->or_like('pelanggan.nama', $keyword);
            $this->db->group_end();
        }
        
        $this->db->order_by('transaksi_header.id', 'DESC');
        
        // ✅ PERBAIKAN: Batasi jumlah data (Pagination)
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    public function get_header_by_id($id) {
        $this->db->select('transaksi_header.*, pelanggan.nama as nama_pelanggan, users.nama_lengkap');
        $this->db->from('transaksi_header');
        $this->db->join('pelanggan', 'pelanggan.id = transaksi_header.pelanggan_id', 'left');
        $this->db->join('users', 'users.id = transaksi_header.user_id', 'left');
        $this->db->where('transaksi_header.id', $id);
        return $this->db->get()->row();
    }

    // public function get_detail_by_transaksi($transaksi_id) {
    //     $this->db->select('transaksi_detail.*, pakaian.nama_pakaian, pakaian.kategori');
    //     $this->db->from('transaksi_detail');
    //     $this->db->join('pakaian', 'pakaian.id = transaksi_detail.pakaian_id', 'left');
    //     $this->db->where('transaksi_detail.transaksi_id', $transaksi_id);
    //     return $this->db->get()->result();
    // }
        public function get_detail_by_transaksi($transaksi_id) {
            $this->db->select('
                transaksi_detail.id, 
                transaksi_detail.pakaian_id, 
                transaksi_detail.ceklis, 
                transaksi_detail.jumlah, 
                transaksi_detail.jumlah_kg, 
                transaksi_detail.keterangan, 
                transaksi_detail.jumlah_diserahkan,
                pakaian.nama_pakaian, 
                pakaian.kategori
            ');
            $this->db->from('transaksi_detail');
            $this->db->join('pakaian', 'pakaian.id = transaksi_detail.pakaian_id', 'left');
            $this->db->where('transaksi_detail.transaksi_id', $transaksi_id);
            // ✅ TAMBAHKAN BARIS INI (ASC = A ke Z)
            $this->db->order_by('pakaian.nama_pakaian', 'ASC'); 
            return $this->db->get()->result();

        }

            /**
         * Generate Nomor Transaksi Otomatis
         * Format: MLP + YYYYMMDD + 3 digit nomor urut (001, 002, dst)
         * Contoh: MLP20260629001, MLP20260629002
         */
        public function generate_no() {
            // 1. Ambil tanggal hari ini dalam format YYYYMMDD
            $tanggal = date('Ymd'); // Contoh: 20260629
            $prefix = 'MLP' . $tanggal; // Contoh: MLP20260629
            
            // 2. Cari nomor transaksi TERAKHIR yang dibuat HARI INI
            //    Menggunakan LIKE dengan 'after' agar hanya mencari yang diawali prefix tersebut
            $this->db->select('no_transaksi');
            $this->db->like('no_transaksi', $prefix, 'after');
            $this->db->order_by('no_transaksi', 'DESC'); // Urutkan dari yang terbesar
            $this->db->limit(1);
            $query = $this->db->get('transaksi_header');
            
            // 3. Tentukan nomor urut berikutnya
            if ($query->num_rows() > 0) {
                // Jika sudah ada transaksi hari ini, ambil 3 digit terakhir dan tambah 1
                $row = $query->row();
                $last_number = (int) substr($row->no_transaksi, -3); // Ambil 3 digit terakhir
                $next_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
            } else {
                // Jika belum ada transaksi hari ini, mulai dari 001
                $next_number = '001';
            }
            
            // 4. Gabungkan prefix + nomor urut
            return $prefix . $next_number;
        }

        public function insert() {
            // 1. Ambil no_transaksi dari form
            $no_transaksi = $this->input->post('no_transaksi');
            
            // ✅ CEK DUPLIKASI (Mencegah error jika user double-click)
            $cek = $this->db->where('no_transaksi', $no_transaksi)->get('transaksi_header')->num_rows();
            if ($cek > 0) {
                // Jika nomor sudah ada di database, paksa generate nomor baru yang unik
                $no_transaksi = $this->generate_no();
            }

            // 2. Amankan pelanggan_id (dari session jika user terikat unit)
            $pelanggan_id = $this->input->post('pelanggan_id');
            $session_pelanggan = $this->session->userdata('pelanggan_id');
            if (!empty($session_pelanggan)) {
                $pelanggan_id = $session_pelanggan; 
            }

            // 3. Siapkan data header
            $header = [
                'no_transaksi'  => $no_transaksi, // Gunakan nomor yang sudah dicek
                'tanggal'       => $this->input->post('tanggal'),
                'nama_pengirim' => $this->input->post('nama_pengirim'),
                'nama_penerima' => $this->input->post('nama_penerima'),
                'pelanggan_id'  => $pelanggan_id,
                'user_id'       => $this->session->userdata('user_id'),
                'shift'         => $this->input->post('shift'),
                'jenis_laundry' => $this->input->post('jenis_laundry') ?: 'Non Infeksius'
            ];
            
            // 4. Insert ke database
            $this->db->insert('transaksi_header', $header);
            $transaksi_id = $this->db->insert_id();

            // 5. Insert detail linen (kode lama Anda tetap di bawah ini)
            $pakaian_ids = $this->input->post('pakaian_id');
            $jumlahs     = $this->input->post('jumlah');
            $jumlah_kgs  = $this->input->post('jumlah_kg');
            $ceklis      = $this->input->post('ceklis');
            $keterangans = $this->input->post('keterangan');

            if (!empty($pakaian_ids)) {
                foreach ($pakaian_ids as $key => $val) {
                    $detail = [
                        'transaksi_id'       => $transaksi_id,
                        'pakaian_id'         => $val,
                        'jumlah'             => isset($jumlahs[$key]) ? (int)$jumlahs[$key] : 0,
                        'jumlah_kg'          => isset($jumlah_kgs[$key]) ? (float)$jumlah_kgs[$key] : 0,
                        'jumlah_diserahkan'  => 0,
                        'ceklis'             => isset($ceklis[$key]) ? 1 : 0,
                        'keterangan'         => isset($keterangans[$key]) ? $keterangans[$key] : ''
                    ];
                    $this->db->insert('transaksi_detail', $detail);
                }
            }
            return $transaksi_id;
        }

    public function delete($id) {
        $this->db->where('id', $id)->delete('transaksi_detail');
        $this->db->where('id', $id)->delete('transaksi_header');
    }

    // Tambahkan method update() di bawah delete():
    public function update($id) {
        // 1. Update Header
        $header = [
            'tanggal'       => $this->input->post('tanggal'),
            'nama_pengirim' => $this->input->post('nama_pengirim'),
            'nama_penerima' => $this->input->post('nama_penerima'),
            'pelanggan_id'  => $this->input->post('pelanggan_id'),
            'shift'         => $this->input->post('shift'),
            'jenis_laundry' => $this->input->post('jenis_laundry') ?: 'Non Infeksius'
        ];
        $this->db->where('id', $id)->update('transaksi_header', $header);

        // 2. Hapus detail lama & insert yang baru
        $this->db->where('transaksi_id', $id)->delete('transaksi_detail');
        
        $pakaian_ids = $this->input->post('pakaian_id');
        $ceklis      = $this->input->post('ceklis'); // Akan menjadi array dengan key eksplisit jika View sudah diperbaiki
        $jumlah      = $this->input->post('jumlah');
        $jumlah_kg   = $this->input->post('jumlah_kg');
        $keterangan  = $this->input->post('keterangan');

        if (!empty($pakaian_ids) && is_array($pakaian_ids)) {
            foreach ($pakaian_ids as $key => $pakaian_id) {
                if (empty($pakaian_id)) continue;
                
                // ✅ LOGIKA CEKLIS YANG LEBIH AMAN
                // Cek apakah key ini ada di array $ceklis DAN nilainya benar-benar 1
                $is_checked = 0;
                if (is_array($ceklis) && isset($ceklis[$key]) && $ceklis[$key] == 1) {
                    $is_checked = 1;
                }

                $this->db->insert('transaksi_detail', [
                    'transaksi_id' => $id,
                    'pakaian_id'   => $pakaian_id,
                    'ceklis'       => $is_checked, // Simpan 1 atau 0 dengan pasti
                    'jumlah'       => isset($jumlah[$key]) ? (int)$jumlah[$key] : 0,
                    'jumlah_kg'    => isset($jumlah_kg[$key]) ? (float)$jumlah_kg[$key] : 0.00,
                    'keterangan'   => isset($keterangan[$key]) ? $keterangan[$key] : ''
                ]);
            }
        }
        return true;
    }

    public function count_all($pelanggan_id = null) {
        if (!empty($pelanggan_id)) {
            $this->db->where('pelanggan_id', $pelanggan_id);
        }
        return $this->db->count_all_results('transaksi_header');
    }

    public function get_latest($limit, $pelanggan_id = null) {
    // 🔒 Filter juga di dashboard
        if (!empty($pelanggan_id)) {
            $this->db->where('pelanggan_id', $pelanggan_id);
        }
        $this->db->order_by('id', 'DESC')->limit($limit);
        return $this->db->get('transaksi_header')->result();
    }

    // 1. Method untuk menghitung total data penyerahan
    public function count_list_penyerahan($keyword = '', $pelanggan_id = null) {
        $this->db->from('transaksi_header');
        $this->db->join('pelanggan', 'pelanggan.id = transaksi_header.pelanggan_id', 'left');
        
        if (!empty($pelanggan_id)) $this->db->where('transaksi_header.pelanggan_id', $pelanggan_id);
        
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('transaksi_header.no_transaksi', $keyword);
            $this->db->or_like('transaksi_header.nama_pengirim', $keyword);
            $this->db->or_like('transaksi_header.nama_penerima', $keyword);
            $this->db->or_like('pelanggan.nama', $keyword);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results();
    }

    public function get_list_penyerahan($keyword = '', $pelanggan_id = null, $limit = null, $offset = null) {
        $this->db->select('
            transaksi_header.*,
            pelanggan.nama as nama_pelanggan,
            SUM(transaksi_detail.jumlah) as total_jumlah_awal,
            SUM(transaksi_detail.jumlah_diserahkan) as total_jumlah_diserahkan
        ');
        $this->db->from('transaksi_header');
        $this->db->join('pelanggan', 'pelanggan.id = transaksi_header.pelanggan_id', 'left');
        $this->db->join('transaksi_detail', 'transaksi_detail.transaksi_id = transaksi_header.id', 'left');

        // Filter Unit
        if (!empty($pelanggan_id)) {
            $this->db->where('transaksi_header.pelanggan_id', $pelanggan_id);
        }

        // Logic Search
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('transaksi_header.no_transaksi', $keyword);
            $this->db->or_like('transaksi_header.nama_pengirim', $keyword);
            $this->db->or_like('transaksi_header.nama_penerima', $keyword);
            $this->db->or_like('pelanggan.nama', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by("FIELD(transaksi_header.status_serah, 'belum', 'diserahkan') ASC", '', FALSE);
        $this->db->order_by('transaksi_header.tanggal', 'DESC');
        $this->db->group_by('transaksi_header.id');
        
        // ✅ PERBAIKAN: Batasi jumlah data (Pagination)
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    public function get_detail_for_penyerahan($transaksi_id) {
        // Sebutkan kolom secara eksplisit agar tidak tertukar
        $this->db->select('
            transaksi_detail.id as detail_id,
            transaksi_detail.pakaian_id,
            transaksi_detail.ceklis,
            transaksi_detail.jumlah,
            transaksi_detail.jumlah_diserahkan,
            transaksi_detail.keterangan,
            transaksi_detail.status_kekurangan,       
            transaksi_detail.keterangan_kekurangan,   
            pakaian.nama_pakaian,
            pakaian.kategori
        ');
        $this->db->from('transaksi_detail');
        $this->db->join('pakaian', 'pakaian.id = transaksi_detail.pakaian_id', 'left');
        $this->db->where('transaksi_detail.transaksi_id', $transaksi_id);
        return $this->db->get()->result();
    }

    public function update_penyerahan($id, $nama_pengambil, $detail_data) {
        // Update Header
        $this->db->where('id', $id)->update('transaksi_header', [
            'nama_pengambil' => $nama_pengambil,
            'status_serah'   => 'diserahkan'
        ]);

        // Update Detail
        if (!empty($detail_data) && is_array($detail_data)) {
            foreach ($detail_data as $item) {
                $update = [
                    'jumlah_diserahkan' => (int)$item['jumlah'],
                    'keterangan'        => isset($item['keterangan']) ? $item['keterangan'] : ''
                ];
                
                // ✅ TAMBAHKAN: Simpan status kekurangan jika ada
                if (isset($item['status_kekurangan']) && !empty($item['status_kekurangan'])) {
                    $update['status_kekurangan'] = $item['status_kekurangan'];
                    $update['keterangan_kekurangan'] = isset($item['keterangan_kekurangan']) ? $item['keterangan_kekurangan'] : '';
                } else {
                    // Jika tidak ada kekurangan, set ke 'lunas'
                    $update['status_kekurangan'] = 'lunas';
                    $update['keterangan_kekurangan'] = null;
                }
                
                $this->db->where('id', $item['detail_id'])->update('transaksi_detail', $update);
            }
        }
        return true;
    }
    /**
     * Get item yang belum dikembalikan penuh dari transaksi sebelumnya
     */
    /**
     * Ambil linen yang belum terkirim dari transaksi sebelumnya (Hanya yang statusnya 'belum_terkirim')
     */
    public function get_pending_klaim($pelanggan_id) {
        $this->db->select('
            td.id, td.jumlah, td.jumlah_diserahkan, td.keterangan_kekurangan,
            (td.jumlah - td.jumlah_diserahkan) as kurang,
            th.no_transaksi, th.tanggal,
            pakaian.nama_pakaian, pakaian.kategori
        ');
        $this->db->from('transaksi_detail td');
        $this->db->join('transaksi_header th', 'th.id = td.transaksi_id');
        $this->db->join('pakaian', 'pakaian.id = td.pakaian_id');
        $this->db->where('th.pelanggan_id', $pelanggan_id);
        $this->db->where('td.status_kekurangan', 'belum_terkirim'); // ✅ KUNCI UTAMA: Hanya ambil yang belum terkirim
        $this->db->where('td.jumlah > td.jumlah_diserahkan', NULL, FALSE);
        $this->db->order_by('th.tanggal', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Mark klaim as lunas
     */
    public function mark_klaim_lunas($detail_id, $jumlah_kembali) {
        $this->db->where('id', $detail_id);
        $this->db->update('transaksi_detail', [
            'jumlah_dikembalikan' => $jumlah_kembali,
            'status_klaim' => 'lunas'
        ]);
    }
}