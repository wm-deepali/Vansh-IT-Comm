<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\CompressesImages;

class BlogController extends Controller
{
    use CompressesImages;

    public function index()
    {
        $blogs = Blog::latest()->get();

        return view('admin.blogs.index', compact('blogs'));
    }


    public function create()
    {
        return view('admin.blogs.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required',
            'content'          => 'required',
            'slug'             => 'nullable|string|max:255',
            'tags'             => 'nullable|string|max:500',
            'read_time'        => 'nullable|integer|min:1|max:120',
            'author_name'      => 'nullable|string|max:100',
            'author_role'      => 'nullable|string|max:100',
            'image'            => 'nullable|image|max:4096',
            'author_image'     => 'nullable|image|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $slug = $this->uniqueSlug($request->title, $request->slug);

        $imageName = null;

        if ($request->hasFile('image')) {
            // Blog featured image — wide banner-style, similar to deal banners
            $imageName = $this->compressAndStore(
                $request->file('image'),
                'blogs',
                1200,
                80
            );
        }

        $authorImage = null;

        if ($request->hasFile('author_image')) {
            $authorImage = $this->compressAndStore(
                $request->file('author_image'),
                'blog-authors',
                300,
                80
            );
        }

        Blog::create([
            'title'             => $request->title,
            'slug'              => $slug,
            'tags'              => $this->parseTags($request->tags),
            'read_time'         => $request->read_time,
            'image'             => $imageName,
            'short_description' => $request->short_description,
            'content'           => $request->content,
            'author_name'       => $request->author_name,
            'author_role'       => $request->author_role,
            'author_image'      => $authorImage,
            'meta_title'        => $request->meta_title,
            'meta_description'  => $request->meta_description,
            'show_home'         => $request->show_home ? 1 : 0,
            'status'            => $request->status ? 1 : 0,
        ]);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog Added Successfully');
    }


    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return view('admin.blogs.edit', compact('blog'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title'            => 'required',
            'content'          => 'required',
            'slug'             => 'nullable|string|max:255',
            'tags'             => 'nullable|string|max:500',
            'read_time'        => 'nullable|integer|min:1|max:120',
            'author_name'      => 'nullable|string|max:100',
            'author_role'      => 'nullable|string|max:100',
            'image'            => 'nullable|image|max:4096',
            'author_image'     => 'nullable|image|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $blog = Blog::findOrFail($id);

        // Keep the existing slug unless the admin typed a different one
        $slug = $blog->slug;
        if ($request->filled('slug') && $request->slug !== $blog->slug) {
            $slug = $this->uniqueSlug($request->title, $request->slug, $blog->id);
        } elseif (empty($slug)) {
            $slug = $this->uniqueSlug($request->title, null, $blog->id);
        }

        $imageName = $blog->image;

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }

            $imageName = $this->compressAndStore(
                $request->file('image'),
                'blogs',
                1200,
                80
            );
        }

        $authorImage = $blog->author_image;

        if ($request->hasFile('author_image')) {
            if ($blog->author_image) {
                Storage::disk('public')->delete($blog->author_image);
            }

            $authorImage = $this->compressAndStore(
                $request->file('author_image'),
                'blog-authors',
                300,
                80
            );
        }

        $blog->update([
            'title'             => $request->title,
            'slug'              => $slug,
            'tags'              => $this->parseTags($request->tags),
            'read_time'         => $request->read_time,
            'image'             => $imageName,
            'short_description' => $request->short_description,
            'content'           => $request->content,
            'author_name'       => $request->author_name,
            'author_role'       => $request->author_role,
            'author_image'      => $authorImage,
            'meta_title'        => $request->meta_title,
            'meta_description'  => $request->meta_description,
            'show_home'         => $request->show_home ? 1 : 0,
            'status'            => $request->status ? 1 : 0,
        ]);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog Updated Successfully');
    }


    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        if ($blog->author_image) {
            Storage::disk('public')->delete($blog->author_image);
        }

        $blog->delete();

        return response()->json([
            'message' => 'Blog Deleted Successfully'
        ]);
    }


    /**
     * "a, b, a ,c" => ['a', 'b', 'c'] (or null when empty)
     */
    private function parseTags(?string $tags): ?array
    {
        if (!$tags) {
            return null;
        }

        $list = array_values(array_unique(array_filter(array_map('trim', explode(',', $tags)))));

        return $list ?: null;
    }

    /**
     * Builds a slug from the manual value (or title) and makes it unique.
     */
    private function uniqueSlug(string $title, ?string $manual = null, ?int $ignoreId = null): string
    {
        $source = $manual ?: $title;
        $base   = Str::slug($source);

        if (empty($base)) {
            $base = str_replace(' ', '-', $source);
        }

        $slug = $base;
        $i    = 2;

        while (
            Blog::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

}