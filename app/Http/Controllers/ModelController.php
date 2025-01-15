<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
use App\Models\Models;
use Yajra\DataTables\DataTables;
use App\Models\Brand;
=======
use App\Models\Brand;
use App\Models\Models;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageData = [
            'title' => 'All Models',
            'pageName' => 'All Models',
            'breadcrumb' => '<li class="breadcrumb-item"><a href="' . route('dashboard') . '">Dashboard</a></li>
                              <li class="breadcrumb-item active">All Models</li>',
<<<<<<< HEAD
            
=======

>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
        ];

        return view('pages.models.index')->with($pageData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        $data = [
            "action" => route('models.store'),
            'brands' => $brands,
            "method" => "POST",
        ];
        return view('pages.models.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
<<<<<<< HEAD
         // Validate the input
    $request->validate([
        'name' => 'required|string|max:255',  // Ensure name is provided
        'brand_id' => 'required|exists:brands,id',  // Ensure a valid brand ID is selected
    ]);

    // Create a new model
    $model = new Models; 
    $model->name = $request->input('name');  // Set the name from the form
    $model->brand_id = $request->input('brand_id');  // Set the brand_id from the form
    $model->save();  // Save the model

    // Redirect to the appropriate page with a success message
    return redirect()->route('models.index')->with('success', 'Model created successfully.');
}
=======
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        Models::create($validated);

        return redirect()->route('models.index')->with('success', 'Model created successfully.');
    }
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(string $id)
    {
       $data = Models::query();

       return DataTables::of($data)
           ->addColumn('id', function ($row) {
               return $row->id;
           })
           // Adding 'name' column
           ->addColumn('name', function ($row) {
               return $row->name;
           })
           // Sorting for 'name' column
           ->orderColumn('name', function ($query, $order) {
               $query->orderBy('name', $order)->orderBy('id', $order);
           })
           // Filtering for 'name' column
           ->filterColumn('name', function ($query, $keyword) {
               $query->where('name', 'like', "%$keyword%");
           })
           // Adding 'brand_name' column,the model has a `brand` relationship
           ->addColumn('brand_name', function ($row) {
               return $row->brand->name;  //'brand' is a relationship method on the Model
           })
           ->filterColumn('brand_name', function ($query, $keyword) {
            $query->whereHas('brand', function($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%");
            });
        })
           ->addColumn('items', function ($row) {
               return $row->items->count();  // Example static value for 'items'
           })
           ->orderColumn('items', function ($query, $order) {
            // Add sorting logic based on the number of related items
            $query->withCount('items')->orderBy('items_count', $order);  // Sort based on the count of related items
        })
           // Adding 'actions' column with edit and delete buttons
           ->addColumn('actions', function ($row) {
               return '
                   <a href="#" title="Edit Model" data-url="' . route('models.edit', [$row->id]) . '" data-size="small" data-ajax-popup="true"
                      data-title="' . __('Edit Model') . '" data-bs-toggle="tooltip">
                       <i class="fas fa-edit text-info font-18"></i>
                   </a>
                   &nbsp;&nbsp;
                   <a href="#" title="Delete" onclick="Delete(' . $row->id . ')">
                       <i class="fa fa-trash text-danger font-18"></i>
                   </a>
               ';
           })
           // Mark 'actions' column as raw for HTML content
           ->rawColumns(['actions'])
           // Return the JSON response
           ->toJson();
    }


=======
    public function show(Request $request)
    {
        $data = Models::query();

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
            ->addColumn('brand_name', function ($row) {
                return $row->brand->name ?? 'N/A';
            })
            ->filterColumn('brand_name', function ($query, $keyword) {
                $query->whereHas('brand', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                });
            })
            ->addColumn('items', function ($row) {
                return $row->items->count() ;
            })
            ->orderColumn('items', function ($query, $order) {
                $query->withCount('items')->orderBy('items_count', $order);
            })
            ->addColumn('actions', function ($row) {
                if ($row->trashed()) {
                    return '
                    <a href="#" title="Restore" onclick="handleAction(' . $row->id . ',\'restore\')" data-bs-toggle="tooltip">
                        <i class="fas fa-redo-alt"></i>
                    </a>
                    &nbsp;&nbsp;
                    <a href="#" title="Permanent Delete" onclick="handleAction(' . $row->id . ', \'permanentDelete\')" data-bs-toggle="tooltip">
                        <i class="fa fa-trash text-danger font-18"></i>
                    </a>';
                } else {
                    return '
                    <a href="#" title="Edit Model" data-url="' . route('models.edit', [$row->id]) . '" data-size="small" data-ajax-popup="true"
                       data-title="' . __('Edit Model') . '" data-bs-toggle="tooltip">
                        <i class="fas fa-edit text-info font-18"></i>
                    </a>
                    &nbsp;&nbsp;
                    <a href="#" title="Delete" onclick="handleAction(' . $row->id . ', \'delete\')" data-bs-toggle="tooltip">
                        <i class="fa fa-trash text-danger font-18"></i>
                    </a>';
                }
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
<<<<<<< HEAD
        // Find the model by ID, if not found return to the model list with an error message
        $model = Models::findOrFail($id);
        // Get all brands to populate the select dropdown for the brand
        $brands = Brand::all();
        $data = [
            'action' => route('models.update', $model->id),  // URL for the update action
            'row' => $model,
            'brands' => $brands,
            'method' => 'PUT',  // Use PUT method for update
=======
        $model = Models::findOrFail($id);
        $brands = Brand::all();
        $data = [
            'action' => route('models.update', $model->id), // URL for the update action
            'row' => $model,
            'brands' => $brands,
            'method' => 'PUT',
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
        ];
        return view('pages.models.form')->with($data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the input
<<<<<<< HEAD
        $request->validate([
            'name' => 'required|string|max:255',  
            'brand_id' => 'required|exists:brands,id', 
        ]);
    
        // Find the model by ID
        $model = Models::findOrFail($id);
        
        // Update the model's attributes with the request data
        $model->name = $request->input('name');
        $model->brand_id = $request->input('brand_id');
        
        // Save the updated model
        $model->save();
    
        // Redirect to the models index page with a success message
        return redirect()->route('models.index')->with('success', 'Model updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Models::findOrFail($id);
        // Delete the model
        $model->delete();
        // Redirect back to the models list with a success message
        return redirect()->route('models.index')->with('success', 'Model deleted successfully.');
    }
=======
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $model = Models::findOrFail($id);

        $model->update($validated);
        return redirect()->route('models.index')->with('success', 'Model updated successfully.');
    }
    public function destroy(string $id)
    {
        $model = Models::findOrFail($id);
        $model->delete();
        return redirect()->route('models.index')->with('success', 'Model deleted successfully.');
    }
    public function restore($id)
    {
        $model = Models::withTrashed()->find($id);
        if ($model) {
            $model->restore();
            return response()->json(['success' => 'Model restored successfully']);
        }

        return response()->json(['error' => 'Model not found'], 404);
    }

    public function forceDelete($id)
    {
        $model = Models::withTrashed()->find($id);
        if ($model) {
            $model->forceDelete();
            return response()->json(['message' => 'Model permanently deleted']);
        }

        return response()->json(['message' => 'Model not found'], 404);
    }

>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
}
