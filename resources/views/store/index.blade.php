@extends('layouts.app')

@section('title')
{{__('Stores Data')}}
@endsection

@section('action-btn')
    <button type="button" class="btn btn-success" data-size="md" data-url="{{ route('store.create') }}" data-ajax-popup="true" data-title="{{__('Add new store')}}">Add store</button>
@endsection

@section('content')
    <table id="dataTable" class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Stocks</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($stores as $store)
                <tr>
                    <th>{{$i}}</th>
                    <td>{{$store->name}}</td>
                    <td>{{$store->stocks->count()}} <a href="{{route('stock.index',['id'=> $store->id])}}">Stocks</a></td>
                    <td>
                        <form action="{{ route('store.destroy', $store->id) }}" method="post">
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
