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

    public function generate_no() {
        $prefix = 'MLP';
        $date   = date('Ymd');
        $this->db->like('no_transaksi', $prefix . $date);
        $this->db->order_by('id', 'DESC');
        $last = $this->db->get('transaksi_header')->row();
        
        if ($last) {
            $num = (int) substr($last->no_transaksi, -4) + 1;
        } else {
            $num = 1;
        }
        return $prefix . $date . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

        public function insert() {
                 $header = [
                'no_transaksi'  => $this->input->post('no_transaksi'),
                'tanggal'       => $this->input->post('tanggal'),
                'nama_pengirim' => $this->input->post('nama_pengirim'),
                'nama_penerima' => $this->input->post('nama_penerima'),
                'pelanggan_id'  => $this->input->post('pelanggan_id'),
                'user_id'       => $this->session->userdata('user_id'),
                'shift'         => $this->input->post('shift'),
                'jenis_laundry' => $this->input->post('jenis_laundry') ?: 'Non Infeksius' // ✅ TAMBAHAN
            ];
            
            $this->db->insert('transaksi_header', $header);
            $transaksi_id = $this->db->insert_id(); // 🔑 Ambil ID header yang baru

            $pakaian_ids = $this->input->post('pakaian_id');
            $ceklis      = $this->input->post('ceklis');
            $jumlah      = $this->input->post('jumlah');
            $jumlah_kg     = $this->input->post('jumlah_kg'); // ✅ TAMBAHAN
            $keterangan  = $this->input->post('keterangan');

            if (!empty($pakaian_ids) && is_array($pakaian_ids)) {
                foreach ($pakaian_ids as $key => $pakaian_id) {
                    if (empty($pakaian_id)) continue;
                    
                    $this->db->insert('transaksi_detail', [
                        'transaksi_id' => $transaksi_id,
                        'pakaian_id'   => $pakaian_id,
                        'ceklis'       => isset($ceklis[$key]) ? (int)$ceklis[$key] : 0,
                        'jumlah'       => isset($jumlah[$key]) ? (int)$jumlah[$key] : 0,
                        'jumlah_kg'    => isset($jumlah_kg[$key]) ? (float)$jumlah_kg[$key] : 0.00, // ✅ SIMPAN KG
                        'keterangan'   => isset($keterangan[$key]) ? $keterangan[$key] : ''
                    ]);
                }
            }
            
            return $transaksi_id; // 🔑 Kembalikan ID agar controller bisa redirect
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
            'jenis_laundry' => $this->input->post('jenis_laundry') ?: 'Non Infeksius' // ✅ TAMBAHAN
        ];
        $this->db->where('id', $id)->update('transaksi_header', $header);
        
        // 2. Hapus detail lama & insert yang baru
        $this->db->where('transaksi_id', $id)->delete('transaksi_detail');
        
        $pakaian_ids = $this->input->post('pakaian_id');
        $ceklis      = $this->input->post('ceklis');
        $jumlah      = $this->input->post('jumlah');
        $jumlah_kg     = $this->input->post('jumlah_kg'); // ✅ TAMBAHAN
        $keterangan  = $this->input->post('keterangan');
        
        if (!empty($pakaian_ids) && is_array($pakaian_ids)) {
            foreach ($pakaian_ids as $key => $pakaian_id) {
                if (empty($pakaian_id)) continue;
                $this->db->insert('transaksi_detail', [
                    'transaksi_id' => $id,
                    'pakaian_id'   => $pakaian_id,
                    'ceklis'       => isset($ceklis[$key]) ? (int)$ceklis[$key] : 0,
                    'jumlah'       => isset($jumlah[$key]) ? (int)$jumlah[$key] : 0,
                    'jumlah_kg'    => isset($jumlah_kg[$key]) ? (float)$jumlah_kg[$key] : 0.00, // ✅ UPDATE KG
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
                    $this->db->where('id', $item['detail_id'])->update('transaksi_detail', [
                        'jumlah_diserahkan' => (int)$item['jumlah'], // ⚠️ Koma di sini WAJIB ada!
                        'keterangan'        => $item['keterangan']
                    ]);
                }
            }
            return true;
    }
}