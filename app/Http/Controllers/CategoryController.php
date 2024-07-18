<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has("search")) {
            $query->where("nama", "like", "%" . $request->search . "%");
        }

        if (
            $request->filled("status") &&
            in_array($request->status, ["0", "1"])
        ) {
            $query->where("status", $request->status);
        }

        // Pagination
        $categories = $query->paginate(10);

        return view("pages.kategori", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama" => "required|string|max:255",
            "status" => "required|boolean",
        ]);

        $categoryData = $request->only(["nama"]);
        $categoryData["status"] = 0;

        Category::create($categoryData);
        return redirect()
            ->route("kategori.index")
            ->with("success", "Category created successfully.");
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            "nama" => "required|string|max:255",
            "status" => "required|boolean",
        ]);

        $category->update($request->only(["nama", "status"]));
        return redirect()
            ->route("kategori.index")
            ->with("success", "Category updated successfully.");
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()
            ->route("kategori.index")
            ->with("success", "Category deleted successfully.");
    }

    public function toggleStatus(Category $category)
    {
        $category->status = !$category->status;
        $category->save();
        return redirect()
            ->route("kategori.index")
            ->with("success", "Category status updated successfully.");
    }
}
