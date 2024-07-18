<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = "barang"; // Ensure this matches your migration table name

    protected $fillable = ["kategori_id", "nama", "deskripsi", "status"];

    public function kategori()
    {
        return $this->belongsTo(Category::class, "kategori_id");
    }
}
