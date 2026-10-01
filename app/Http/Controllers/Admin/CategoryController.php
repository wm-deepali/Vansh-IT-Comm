<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class CategoryController extends Controller
{
    // ✅ List Page
    public function index(Request $request)
    {
        $query = Category::with('parent', 'children')->withCount('products');

        $parentCategories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->type == 'category') {

            $query->whereNull('parent_id');

        } elseif ($request->type == 'subcategory') {

            $query->whereNotNull('parent_id');

            if ($request->filled('category_id')) {
                $query->where('parent_id', $request->category_id);
            }
        }

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedColumns = ['id', 'name', 'sort_order', 'status', 'is_popular'];

        if (in_array($sortBy, $allowedColumns)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        $categories = $query
            ->paginate(10)
            ->appends($request->all());

        return view('admin.categories.index', compact(
            'categories',
            'parentCategories'
        ));
    }

    // ✅ Create
    public function create()
    {
        $parents = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.categories.create', compact('parents'));
    }

    /**
     * ✅ Compress & store an uploaded image as WebP.
     * Downscales to max width (never upscales), re-encodes as WebP.
     */
    private function compressAndStore(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 1200,
        int $quality = 80
    ): string {
        $manager = ImageManager::usingDriver(Driver::class);

        $image = $manager->decode($file);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $path = trim($folder, '/') . '/' . Str::uuid() . '.webp';

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    // Shared validation rules (soft-delete aware)
    private function rules(?int $ignoreId = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->ignore($ignoreId)
                    ->whereNull('deleted_at'),
            ],
            'sub_title' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:60',
            'parent_id' => [
                'nullable',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
                Rule::notIn([$ignoreId]),
            ],
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|in:0,1',
            'is_popular' => 'nullable|in:0,1',
            'is_featured' => 'nullable|in:0,1',
            'show_in_navbar' => 'nullable|in:0,1',
        ];
    }

    // ✅ Store
    public function store(Request $request)
    {
        $request->validate($this->rules());

        $image = $request->hasFile('image')
            ? $this->compressAndStore($request->file('image'), 'categories', 800, 80)
            : null;

        $parentId = $request->parent_id ?: null;

        Category::create([
            'name' => $request->name,
            'sub_title' => $request->sub_title,
            'icon' => $request->icon,
            'slug' => Str::slug($request->slug ?: $request->name),

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'image' => $image,

            'parent_id' => $parentId,
            'is_sub_category' => $parentId ? 1 : 0,

            'is_popular' => $request->is_popular ?? 0,
            'is_featured' => $request->is_featured ?? 0,
            'show_in_navbar' => $request->show_in_navbar ?? 0,

            'added_by' => 'admin',
            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category Added Successfully');
    }

    // ✅ Edit
    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->orderBy('name')
            ->get();

        $redirect = $request->redirect;

        return view('admin.categories.edit', compact(
            'category',
            'parents',
            'redirect'
        ));
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate($this->rules($category->id));

        $image = $category->image;

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $image = $this->compressAndStore($request->file('image'), 'categories', 800, 80);
        }

        $parentId = $request->parent_id ?: null;

        $category->update([
            'name' => $request->name,
            'sub_title' => $request->sub_title,
            'icon' => $request->icon,
            'slug' => $request->slug ? Str::slug($request->slug) : $category->slug,

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'image' => $image,

            'parent_id' => $parentId,
            'is_sub_category' => $parentId ? 1 : 0,

            'is_popular' => $request->is_popular ?? 0,
            'is_featured' => $request->is_featured ?? 0,
            'show_in_navbar' => $request->show_in_navbar ?? 0,

            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect($request->redirect ?? route('admin.categories.index'))
            ->with('success', 'Category Updated Successfully');
    }

    // ✅ Delete (soft delete – image is kept so the category can be restored)
    public function destroy($id)
    {
        $category = Category::withCount(['children', 'products'])->findOrFail($id);

        if ($category->children_count > 0) {
            return response()->json(['message' => 'Delete or move its sub categories first.'], 422);
        }

        if ($category->products_count > 0) {
            return response()->json(['message' => 'This category has products assigned. Reassign them first.'], 422);
        }

        $category->delete();

        return response()->json(['message' => 'Category Deleted Successfully']);
    }

    public function import()
    {
        return view('admin.categories.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:text/plain,text/csv,application/vnd.ms-excel'
        ]);

        try {
            Excel::import(new CategoryImport, $request->file('file'));

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Categories imported successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadSample()
    {
        $headers = [
            'name',
            'sub_title',
            'image_name',
            'parent_category',
            'meta_title',
            'meta_description',
            'is_popular',
            'is_featured',
            'status',
            'sort_order'
        ];

        $sampleRow = [
            'Laptops',
            'Refurbished & new laptops with 12-month warranty',
            'laptops.jpg',
            '',
            'Laptops',
            'Buy refurbished and new laptops',
            '1',
            '1',
            '1',
            '1'
        ];

        $response = new StreamedResponse(function () use ($headers, $sampleRow) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            fputcsv($handle, $sampleRow);
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=category_import_sample.csv');

        return $response;
    }

    public function uploadImagesZip(Request $request)
    {
        $request->validate([
            'zip_file' => 'required|mimes:zip'
        ]);

        try {
            $zip = new ZipArchive();

            if ($zip->open($request->file('zip_file')->getRealPath()) === true) {

                $extractPath = storage_path('app/public/categories');

                if (!file_exists($extractPath)) {
                    mkdir($extractPath, 0777, true);
                }

                $zip->extractTo($extractPath);
                $zip->close();

                return back()->with('success', 'Category images uploaded successfully.');
            }

            return back()->with('error', 'Unable to extract ZIP file.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadParentCategoryReference()
    {
        $categories = Category::whereNull('parent_id')
            ->orderBy('id')
            ->get(['id', 'name']);

        $response = new StreamedResponse(function () use ($categories) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['id', 'category_name']);

            foreach ($categories as $category) {
                fputcsv($handle, [$category->id, $category->name]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=parent_category_reference.csv');

        return $response;
    }
}