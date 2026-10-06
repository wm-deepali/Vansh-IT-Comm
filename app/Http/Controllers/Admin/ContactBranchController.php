<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactBranch;

class ContactBranchController extends Controller
{
    private const DEFAULT_ICON = 'fa-solid fa-store';

    /*
    |--------------------------------------------------
    | INDEX
    |--------------------------------------------------
    */
    public function index()
    {
        $branches = ContactBranch::orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10);

        return view('admin.contact-branches.index', compact('branches'));
    }

    /*
    |--------------------------------------------------
    | CREATE
    |--------------------------------------------------
    */
    public function create()
    {
        return view('admin.contact-branches.create');
    }

    /*
    |--------------------------------------------------
    | STORE (ADD MORE SUPPORT)
    |--------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|array|min:1',
            'title.*'         => 'required|string|max:255',
            'subtitle.*'      => 'nullable|string|max:255',
            'phone.*'         => 'nullable|string|max:50',
            'email.*'         => 'nullable|email|max:150',
            'address.*'       => 'nullable|string|max:1000',
            'working_hours.*' => 'nullable|string|max:255',
            'icon.*'          => ['nullable', 'string', 'max:100', 'regex:/^[a-z0-9\- ]+$/i'],
            'status.*'        => 'nullable|in:0,1',
            'sort_order.*'    => 'nullable|integer|min:0',
        ]);

        foreach ($request->title as $key => $title) {

            ContactBranch::create([
                'title'         => $title,
                'subtitle'      => $request->subtitle[$key] ?? null,
                'address'       => $request->address[$key] ?? null,
                'phone'         => $request->phone[$key] ?? null,
                'email'         => $request->email[$key] ?? null,
                'working_hours' => $request->working_hours[$key] ?? null,
                'icon'          => ($request->icon[$key] ?? null) ?: self::DEFAULT_ICON,
                'status'        => (bool) ($request->status[$key] ?? 1),
                'sort_order'    => (int) ($request->sort_order[$key] ?? 0),
            ]);
        }

        return redirect()->route('admin.contact-branches.index')
            ->with('success', 'Branches Added Successfully');
    }

    /*
    |--------------------------------------------------
    | EDIT
    |--------------------------------------------------
    */
    public function edit($id)
    {
        $branch = ContactBranch::findOrFail($id);
        return view('admin.contact-branches.edit', compact('branch'));
    }

    /*
    |--------------------------------------------------
    | UPDATE
    |--------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $branch = ContactBranch::findOrFail($id);

        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:1000',
            'phone'         => 'nullable|string|max:50',
            'email'         => 'nullable|email|max:150',
            'working_hours' => 'nullable|string|max:255',
            'icon'          => ['nullable', 'string', 'max:100', 'regex:/^[a-z0-9\- ]+$/i'],
            'status'        => 'required|in:0,1',
            'sort_order'    => 'nullable|integer|min:0',
        ]);

        $data['icon']       = $data['icon'] ?: self::DEFAULT_ICON;
        $data['status']     = (bool) $data['status'];
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $branch->update($data);

        return redirect()->route('admin.contact-branches.index')
            ->with('success', 'Branch Updated Successfully');
    }

    /*
    |--------------------------------------------------
    | DELETE
    |--------------------------------------------------
    */
    public function destroy($id)
    {
        // icon is a CSS class now, so there is no file to remove from storage
        ContactBranch::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Deleted Successfully'
        ]);
    }
}