<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\DynamicPage;

class DynamicPageController extends Controller
{
    public function index()
    {
        $pages = DynamicPage::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        // Clean the slug before validating so "About Us" becomes "about-us"
        $request->merge(['page_name' => Str::slug($request->page_name)]);

        $request->validate($this->rules());

        DynamicPage::create($this->data($request));

        return redirect()->route('admin.pages.index')->with('success', 'Page Created');
    }

    public function edit($id)
    {
        $page = DynamicPage::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = DynamicPage::findOrFail($id);

        $request->merge(['page_name' => Str::slug($request->page_name)]);

        $request->validate($this->rules($id));

        $page->update($this->data($request));

        return redirect()->route('admin.pages.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        DynamicPage::destroy($id);
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    private function rules($id = null): array
    {
        return [
            'page_name'        => ['required', 'string', 'max:100', Rule::unique('dynamic_pages', 'page_name')->ignore($id)],
            'heading'          => 'required|string|max:255',
            'content'          => 'required',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status'           => 'required|in:active,block',
            'show_in_policies' => 'nullable|boolean',
            'sort_order'       => 'nullable|integer|min:0',
            'icon'             => ['nullable', 'regex:/^fa-[a-z0-9-]+$/'],
            'badge'            => 'nullable|string|max:40',
            'summary'          => 'nullable|string|max:300',
        ];
    }

    private function data(Request $request): array
    {
        return [
            'page_name'        => $request->page_name,
            'heading'          => $request->heading,
            'content'          => $request->content,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status'           => $request->status,
            'show_in_policies' => $request->boolean('show_in_policies'),
            'sort_order'       => $request->sort_order ?? 0,
            'icon'             => $request->icon ?: null,
            'badge'            => $request->badge ?: null,
            'summary'          => $request->summary ?: null,
        ];
    }
}