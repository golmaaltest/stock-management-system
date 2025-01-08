<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()) {

            $stocks = Stock::with('store');
            if($request->id){
                $stocks = $stocks->where('store_id',$request->id);
            }
            $stocks = $stocks->get();

            return view('stock.index',compact('stocks'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::where('created_by', Auth::user()->id)->get();
        return view('stock.create',compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'item_code.*'       => 'required|string',
                'item_name.*'       => 'required|string',
                'quantity.*'        => 'required|integer',
                'location.*'        => 'required|string',
                'store_id.*'        => 'required|integer|exists:stores,id',
                'in_stock_date.*'   => 'required|date',
            ]);

            foreach($request->input('item_code') as $key => $value) {
                Stock::create([
                    'item_code'     => $request->input('item_code')[$key],
                    'item_name'     => $request->input('item_name')[$key],
                    'quantity'      => $request->input('quantity')[$key],
                    'location'      => $request->input('location')[$key],
                    'store_id'      => $request->input('store_id')[$key],
                    'in_stock_date' => $request->input('in_stock_date')[$key],
                    'created_by'    => Auth::user()->id,
                ]);
            }
            return redirect()->route('stock.index')->with('success', 'Stocks created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('stock.index')->with('failed','Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = Stock::find($id);
        if ($stock) {
            $stock->delete();
            return redirect()->route('stock.index')->with('success', __('Stock deleted successfully.'));
        }
        return redirect()->route('stock.index')->with('failed','Something went wrong!');
    }

    public function stockData(Request $request)
    {
        $perPage = $request->input('size', 10);
        $sortColumn = $request->input('sort', 'id');
        $sortOrder = $request->input('sortOrder', 'asc');

        $stocks = Stock::query()->with('store');

        if ($request->has('search')) {
            $stocks->where('item_name', 'like', '%'.$request->search.'%');
        }
        $stocks->orderBy($sortColumn, $sortOrder);
        $stocksPaginated = $stocks->paginate($perPage);

        return response()->json([
            'data' => $stocksPaginated->items(),
            'total' => $stocksPaginated->total(),
            'page' => $stocksPaginated->currentPage(),
            'last_page' => $stocksPaginated->lastPage(),
        ]);
    }

    public function stocksDataStore(Request $request)
    {
        try {
            $request->validate([
                'item_code.*'       => 'required|string',
                'item_name.*'       => 'required|string',
                'quantity.*'        => 'required|integer',
                'location.*'        => 'required|string',
                'store_id.*'        => 'required|integer|exists:stores,id',
                'in_stock_date.*'   => 'required|date',
            ]);

            foreach($request->input('item_code') as $key => $value) {
                Stock::create([
                    'item_code'     => $request->input('item_code')[$key],
                    'item_name'     => $request->input('item_name')[$key],
                    'quantity'      => $request->input('quantity')[$key],
                    'location'      => $request->input('location')[$key],
                    'store_id'      => $request->input('store_id')[$key],
                    'in_stock_date' => $request->input('in_stock_date')[$key],
                    'created_by'    => Auth::user()->id,
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Stocks created successfully.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
            ]);
        }
    }
}
