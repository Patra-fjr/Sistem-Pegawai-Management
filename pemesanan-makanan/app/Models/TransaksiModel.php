<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'no_invoice', 'user_id', 'tipe_order', 'nama_pelanggan', 'no_meja',
        'metode_bayar', 'subtotal', 'diskon', 'total', 'bayar', 'kembalian',
        'promo_code', 'status', 'catatan', 'created_at'
    ];
    protected $useTimestamps = true;
    protected $updatedField  = '';

    public function generateInvoice()
    {
        $date = date('Ymd');
        $last = $this->db->table('transaksi')
            ->like('no_invoice', "INV-{$date}", 'after')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()->getRowArray();

        if ($last) {
            $num = (int) substr($last['no_invoice'], -4) + 1;
        } else {
            $num = 1;
        }

        return "INV-{$date}-" . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    public function getPendapatanHarian($days = 14)
    {
        return $this->db->query("
            SELECT DATE(created_at) as tanggal, SUM(total) as total
            FROM transaksi
            WHERE status = 'lunas'
            AND created_at >= DATE_SUB(NOW(), INTERVAL {$days} DAY)
            GROUP BY DATE(created_at)
            ORDER BY tanggal ASC
        ")->getResultArray();
    }

    public function getSummaryToday()
    {
        return $this->db->query("
            SELECT 
                COUNT(*) as jumlah_transaksi,
                COALESCE(SUM(total), 0) as total_pendapatan,
                COALESCE(AVG(total), 0) as rata_rata
            FROM transaksi
            WHERE status = 'lunas'
            AND DATE(created_at) = CURDATE()
        ")->getRowArray();
    }

    public function getProdukTerlaris($limit = 5)
    {
        return $this->db->query("
            SELECT td.nama_menu, SUM(td.qty) as total_qty, SUM(td.subtotal) as total_omzet
            FROM transaksi_detail td
            JOIN transaksi t ON t.id = td.transaksi_id
            WHERE t.status = 'lunas'
            GROUP BY td.nama_menu
            ORDER BY total_qty DESC
            LIMIT {$limit}
        ")->getResultArray();
    }

    public function getWithDetail($id)
    {
        $trx = $this->find($id);
        if ($trx) {
            $trx['detail'] = $this->db->table('transaksi_detail')->where('transaksi_id', $id)->get()->getResultArray();
        }
        return $trx;
    }
}