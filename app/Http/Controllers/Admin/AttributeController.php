<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    private const TYPES = ['button', 'dropdown', 'image', 'color_swatch', 'radio'];

    private function rules(): array
    {
        return [
            'name'           => 'required|max:255',
            'icon'           => 'nullable|string|max:100',
            'type'           => 'required|in:' . implode(',', self::TYPES),
            'has_values'     => 'required|boolean',
            'status'         => 'required|boolean',
            'show_in_navbar' => 'required|boolean',
        ];
    }

    public function index()
    {
        $attributes = Attribute::latest()->paginate(20);

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $types = self::TYPES;

        return view('admin.attributes.create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        Attribute::create([
            'name'           => $data['name'],
            'slug'           => Str::slug($data['name']),
            'icon'           => $data['icon'] ?? null,
            'type'           => $data['type'],
            'has_values'     => $data['has_values'],
            'status'         => $data['status'],
            'show_in_navbar' => $data['show_in_navbar'],
        ]);

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute created successfully.');
    }

    public function edit(Attribute $attribute)
    {
        $types = self::TYPES;

        return view('admin.attributes.edit', compact('attribute', 'types'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->validate($this->rules());

        $attribute->update([
            'name'           => $data['name'],
            'slug'           => Str::slug($data['name']),
            'icon'           => $data['icon'] ?? null,
            'type'           => $data['type'],
            'has_values'     => $data['has_values'],
            'status'         => $data['status'],
            'show_in_navbar' => $data['show_in_navbar'],
        ]);

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully.');
    }

    public function destroy(Request $request, Attribute $attribute)
    {
        $attribute->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'Attribute deleted successfully.']);
        }

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully.');
    }
}