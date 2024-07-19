<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Category;
use App\Models\Barang;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $query = Stok::with(["kategori", "barang"]);

        // Search by nama barang
        if ($request->has("search")) {
            $query->whereHas("barang", function ($q) use ($request) {
                $q->where("nama", "like", "%" . $request->search . "%");
            });
        }

        // Filter by status
        if (
            $request->filled("status") &&
            in_array($request->status, ["0", "1"])
        ) {
            $query->where("status", $request->status);
        }

        // Filter by kategori
        if ($request->filled("kategori_id")) {
            $query->where("kategori_id", $request->kategori_id);
        }

        // Filter by stok availability
        if ($request->filled("stok_availability")) {
            if ($request->stok_availability == "available") {
                $query->where("stok", ">", 0);
            } elseif ($request->stok_availability == "empty") {
                $query->where("stok", "=", 0);
            }
        }

        // Filter by date
        if ($request->filled("date")) {
            $query->whereDate("tanggal", $request->date);
        }

        // Pagination
        $stok = $query->paginate(10);

        // Get all categories and barang for the form
        $categories = Category::all();
        $barang = Barang::all();

        return view("pages.stok", compact("stok", "categories", "barang"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "kategori_id" => "required|exists:categories,id",
            "barang_id" => "required|exists:barang,id",
            "stok" => "required|integer",
            "harga_beli" => "required|numeric",
            "keterangan" => "nullable|string",
            "tanggal" => "required|date",
        ]);

        Stok::create($request->all());
        return redirect()
            ->route("stok.index")
            ->with("success", "Stok created successfully.");
    }

    public function update(Request $request, Stok $stok)
    {
        $request->validate([
            "kategori_id" => "required|exists:categories,id",
            "barang_id" => "required|exists:barang,id",
            "stok" => "required|integer",
            "harga_beli" => "required|numeric",
            "keterangan" => "nullable|string",
            "tanggal" => "required|date",
            "status" => "required|boolean",
        ]);

        $stok->update($request->all());
        return redirect()
            ->route("stok.index")
            ->with("success", "Stok updated successfully.");
    }

    public function destroy(Stok $stok)
    {
        $stok->delete();
        return redirect()
            ->route("stok.index")
            ->with("success", "Stok deleted successfully.");
    }

    public function toggleStatus(Stok $stok)
    {
        $stok->status = !$stok->status;
        $stok->save();
        return redirect()
            ->route("stok.index")
            ->with("success", "Stok status updated successfully.");
    }
}
