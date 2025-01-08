<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()) {
            $stores = Store::with('stocks')->where('created_by', Auth::user()->id)->get();
            return view('store.index',compact('stores'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('store.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('failed', $messages->first());
        }

        $store              = new Store();
        $store->name        = $request->name;
        $store->created_by  = Auth::user()->id;
        $store->save();

        return redirect()->route('store.index')->with('success', __('Store created successfully.'));
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
        $store = Store::find($id);
        if ($store) {
            $stocks = Stock::where('store_id',$store->id)->where('created_by', Auth::user()->id);
            $stocks->delete();
            $store->delete();
            return redirect()->route('store.index')->with('success', __('Store deleted successfully.'));
        }
        return redirect()->route('store.index')->with('failed','Something went wrong!');
    }
}
