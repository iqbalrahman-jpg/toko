<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with("kategori");

        // Search by name
        if ($request->has("search")) {
            $query->where("nama", "like", "%" . $request->search . "%");
        }

        // Filter by status
        if (
            $request->filled("status") &&
            in_array($request->status, ["0", "1"])
        ) {
            $query->where("status", $request->status);
        }

        if ($request->filled("kategori_id")) {
            $query->where("kategori_id", $request->kategori_id);
        }

        // Pagination
        $barang = $query->paginate(10);

        // Get all categories for the form
        $categories = Category::all();

        return view("pages.barang", compact("barang", "categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "kategori_id" => "required|exists:categories,id",
            "nama" => "required|string|max:255",
            "deskripsi" => "nullable|string",
        ]);

        // Set default status to disabled (0)
        $barangData = $request->only(["kategori_id", "nama", "deskripsi"]);
        $barangData["status"] = 0;

        Barang::create($barangData);
        return redirect()
            ->route("barang.index")
            ->with("success", "Barang created successfully.");
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            "kategori_id" => "required|exists:categories,id",
            "nama" => "required|string|max:255",
            "deskripsi" => "nullable|string",
            "status" => "required|boolean",
        ]);

        $barang->update(
            $request->only(["kategori_id", "nama", "deskripsi", "status"])
        );
        return redirect()
            ->route("barang.index")
            ->with("success", "Barang updated successfully.");
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()
            ->route("barang.index")
            ->with("success", "Barang deleted successfully.");
    }

    public function toggleStatus(Barang $barang)
    {
        $barang->status = !$barang->status;
        $barang->save();
        return redirect()
            ->route("barang.index")
            ->with("success", "Barang status updated successfully.");
    }
}
