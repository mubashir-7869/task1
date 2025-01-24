<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Item;
use App\Events\PurchaseItem;
use App\Jobs\StockManagementJob;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use yajra\DataTables\DataTables;

class ServiceController extends Controller
{
    public function index()
    {
        $pageData = [
            'title' => 'Service',
            'pageName' => 'Service',
            'breadcrumb' => '<li class="breadcrumb-item"><a href="' . route('dashboard') . '">Dashboard</a></li>
                              <li class="breadcrumb-item active">Service</li>',
        ];

        return view('pages.service.index')->with($pageData);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
        $data = Brand::query();
        $data->has('items');

        return DataTables::of($data)
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('name', function ($row) {
                return $row->name ?? 'N/A';
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order)->orderBy('id', $order);
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            ->addColumn('actions', function ($row) {
                return '<a href="' . route('services.edit', [$row->id]) . '" class="btn btn-sm btn-primary" target="blank">Detail</a>';
            })
            ->rawColumns(['permissions', 'actions'])
            ->toJson();
    }

    public function edit(string $id)
    {
        $items = Item::where('brand_id', $id)->where('status','in_stock')->get();
        $brand = Brand::findOrFail($id);
        $pageData = [
            'title' => 'Items',
            'pageName' => 'Items',
            'breadcrumb' => '<li class="breadcrumb-item"><a href="' . route('dashboard') . '">Dashboard</a></li>
                              <li class="breadcrumb-item"><a href="' . route('services.index') . '">Service</a></li>
                              <li class="breadcrumb-item active">Items</li>',
                              
            'items' => $items,
            'brand' => $brand,
        ];

        return view('pages.service.show')->with($pageData);
    }

    public function purchase($id)
    {
        $item = Item::findOrFail($id);

        $pageData = [
            'title' => 'Purchase Item',
            'pageName' => 'Purchase Item',
            'breadcrumb' => '<li class="breadcrumb-item"><a href="' . route('dashboard') . '">Dashboard</a></li>
                              <li class="breadcrumb-item active">Purchase Item</li>',
            'action' => route('service.handlePayment'),
            'method' => 'POST',
            'item' => $item,
        ];
        return view('pages.service.purchase')->with($pageData);
    }

    public function handlePayment(Request $request)
    {
        // dd($request->all());
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'stripeToken' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);
        $item = Item::findOrFail($request->id);
        // dd($request->amount);
        $totalAmount = $item->getEffectivePrice() * $validated['quantity'];
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100,
                'currency' => 'usd',
                'description' => 'Payment for item: ' . $item->name,
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => $validated['stripeToken'],
                    ],
                ],
                'confirm' => true,
                'return_url' => route('services.index'),
            ]);
            dispatch(new StockManagementJob($item, $validated['quantity'],$validated['name'],$validated['email']));
            return redirect()->back()->with('success', 'Payment Successful!');

        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Payment Failed: ' . $e->getMessage());
        }
    }
}
