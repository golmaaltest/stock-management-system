@extends('layouts.app')

@section('title')
{{__('Stocks Data')}}
@endsection

@section('action-btn')
    <a href="{{ route('stock.create') }}"><button type="button" class="btn btn-success" >Add Stocks</button></a>
@endsection

@section('content')
    <table  id="dataTable" class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Item Code</th>
                <th scope="col">Item Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Location</th>
                <th scope="col">Store Name</th>
                <th scope="col">Status</th>
                <th scope="col">In Stock Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($stocks as $stock)
                <tr>
                    <th>{{$i}}</th>
                    <td>{{$stock->item_code}}</td>
                    <td>{{$stock->item_name}}</td>
                    <td>{{$stock->quantity}}</td>
                    <td>{{$stock->location}}</td>
                    <td>{{$stock->store->name}}</td>
                    <td>
                        @if ($stock->status == 'In stock')
                            <span class="badge text-white bg-success p-2">{{$stock->status}}</span>
                        @else
                            <span class="badge text-white bg-warning p-2">{{$stock->status}}</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($stock->in_stock_date)->format('d-m-Y') }}</td>
                    <td>
                        <form action="{{ route('stock.destroy', $stock->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    @php
                        $i++;
                    @endphp
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
