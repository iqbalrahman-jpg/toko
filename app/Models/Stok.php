<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = "stok";

    protected $fillable = [
        "kategori_id",
        "barang_id",
        "stok",
        "harga_beli",
        "keterangan",
        "tanggal",
        "status",
    ];

    public function kategori()
    {
        return $this->belongsTo(Category::class, "kategori_id");
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, "barang_id");
    }
}
