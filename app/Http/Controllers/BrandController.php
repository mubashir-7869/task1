<?php

namespace App\Http\Controllers;

use App\Models\Brand;
<<<<<<< HEAD
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
=======
use App\Events\SendEmail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageData = [
            'title' => 'Brands',
            'pageName' => 'Brands',
            'breadcrumb' => '<li class="breadcrumb-item"><a href="' . route('dashboard') . '">Dashboard</a></li>
                              <li class="breadcrumb-item active">Brands</li>',
<<<<<<< HEAD
            
=======

>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
        ];

        return view('pages.brand.index')->with($pageData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            "action" => route('brands.store'),
            "method" => "POST",
        ];
        return view('pages.brand.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
<<<<<<< HEAD
    $request->validate([
        'name' => 'required|string|max:255', // Assuming 'name' is required
    ]);

    // Create a new brand
    $brand = new Brand();
    $brand->name = $request->name;
    $brand->save();

    return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
=======
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Brand::create($validated);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = Brand::query();
<<<<<<< HEAD
    
    return DataTables::of($data)
        ->addColumn('id', function ($row) {
            return $row->id;
        })
        ->addColumn('name', function ($row) {
            return $row->name;
        })
        ->orderColumn('name', function ($query, $order) {
            $query->orderBy('name', $order)->orderBy('id', $order);
        })
        ->filterColumn('name', function ($query, $keyword) {
            $query->where('name', 'like', "%$keyword%");
        })
        // Adding 'items' column (with count)
        ->addColumn('items', function ($row) {
            return $row->items->count();  // Counting the related items
        })
        // Sorting logic for 'items' column
        ->orderColumn('items', function ($query, $order) {
            $query->withCount('items')->orderBy('items_count', $order);
        })
        // Adding 'models' column (with count)
        ->addColumn('models', function ($row) {
            return $row->models->count();  // Counting the related models
        })
        
        // Sorting logic for 'models' column
        ->orderColumn('models', function ($query, $order) {
            $query->withCount('models')->orderBy('models_count', $order);
        })
        ->addColumn('actions', function ($row) {
            return '
                <a href="#" title="Edit Models" data-url="' . route('brands.edit', [$row->id]) . '" data-size="small" data-ajax-popup="true"
                    data-title="' . __('Edit Model') . '" data-bs-toggle="tooltip">
                    <i class="fas fa-edit text-info font-18"></i>
                </a>
                &nbsp;&nbsp;
                <a href="#" title="Delete" onclick="Delete(' . $row->id . ')">
                    <i class="fa fa-trash text-danger font-18"></i>
                </a>
            ';
        })
        ->rawColumns(['actions'])  //  'actions' column is raw for HTML content
        ->toJson();
        
=======
        if ($request->has('show_trashed') && $request->show_trashed == 'true') {
            $data->onlyTrashed();
        }

        return DataTables::of($data)
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order)->orderBy('id', $order);
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            ->addColumn('items', function ($row) {
                return $row->items->count(); // Counting the related items
            })
        // Sorting logic for 'items' column
            ->orderColumn('items', function ($query, $order) {
                $query->withCount('items')->orderBy('items_count', $order);
            })
        // Adding 'models' column (with count)
            ->addColumn('models', function ($row) {
                return $row->models->count(); // Counting the related models
            })

        // Sorting logic for 'models' column
            ->orderColumn('models', function ($query, $order) {
                $query->withCount('models')->orderBy('models_count', $order);
            })
            ->addColumn('actions', function ($row) {
                if ($row->trashed()) {
                    return '
                    <a href="#" title="Restore" onclick="handleAction(' . $row->id . ', \'restore\')" data-bs-toggle="tooltip">
                        <i class="fas fa-redo-alt"></i>
                    </a>
                    &nbsp;&nbsp;
                    <a href="#" title="Permanent Delete" onclick="handleAction(' . $row->id . ', \'permanentDelete\')" data-bs-toggle="tooltip">
                        <i class="fa fa-trash text-danger font-18"></i>
                    </a>';
                } else {
                    return '
                    <a href="#" title="Edit Models" data-url="' . route('brands.edit', [$row->id]) . '" data-size="small" data-ajax-popup="true"
                        data-title="' . __('Edit Model') . '" data-bs-toggle="tooltip">
                        <i class="fas fa-edit text-info font-18"></i>
                    </a>
                    &nbsp;&nbsp;
                    <a href="#" title="Delete" onclick="handleAction(' . $row->id . ', \'delete\')" data-bs-toggle="tooltip">
                        <i class="fa fa-trash text-danger font-18"></i>
                    </a>';
                }
            })
            ->rawColumns(['actions']) //  'actions' column is raw for HTML content
            ->toJson();

>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        $data = [
<<<<<<< HEAD
            "action" => route('brands.update',[$brand->id]),
=======
            "action" => route('brands.update', [$brand->id]),
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
            'row' => $brand,
            "method" => "PUT",
        ];
        return view('pages.brand.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
<<<<<<< HEAD
         // Validate the input
         $request->validate([
            'name' => 'required|string|max:255', // Assuming 'name' is required
        ]);

        // Find the brand by its ID
        $brand = Brand::findOrFail($id);

        // Update the brand details
        $brand->name = $request->name;
        $brand->save();

=======

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $brand = Brand::findOrFail($id);
        $brand->update($validated);
        
        event(new SendEmail($brand));
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

<<<<<<< HEAD
        return redirect()->back()->with('success' , 'Brand deleted successfully.');
=======
        return response()->json(['success' => true]);
    }
    public function restore($id)
    {
        $brand = Brand::withTrashed()->find($id);
        if ($brand) {
            $brand->restore();
            return response()->json(['success' => 'Brand restored successfully']);
        }

        return response()->json(['error' => 'Brand not found'], 404);
    }
    public function forceDelete($id)
    {
        $brand = Brand::withTrashed()->find($id);
        if (!empty($brand)) {
            $brand->forceDelete();
            return response()->json(['message' => 'Brand has been permanently deleted.'], 200);
        }
        return response()->json(['message' => 'Brand not found.'], 404);
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
    }
}
