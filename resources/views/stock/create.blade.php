@extends('layouts.app')

@section('title')
{{__('Add Stocks')}}
@endsection

@section('action-btn')
    <a href="{{ route('stock.index') }}"><button type="button" class="btn btn-secondary">Back</button></a>
    <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
@endsection

@section('content')
    {{Form::open(array('url'=>route('stock.store'), 'method'=>'post', 'id' => 'bulk_stocks', 'name' => 'bulk_stocks'))}}
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered" id="repeater">
                <thead>
                    <th scope="col">Item Code</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Location</th>
                    <th scope="col">Store</th>
                    <th scope="col">In Stock Date</th>
                    <th scope="col">Action</th>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="item_code[]" id="item_code" placeholder="Enter item code" class="form-control item_code_list" required /></td>
                        <td><input type="text" name="item_name[]" id="item_name" placeholder="Enter item name" class="form-control item_name_list" required /></td>
                        <td><input type="text" name="quantity[]" id="quantity" placeholder="Enter quantity" class="form-control quantity_list" required /></td>
                        <td><input type="text" name="location[]" id="location" placeholder="Enter location" class="form-control location_list" required /></td>
                        <td><select class="form-control" id="store_id" name="store_id[]" required>
                                <option value="">Select Store</option>
                                @foreach ($stores as $store)
                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="date" name="in_stock_date[]" id="in_stock_date" class="form-control in_stock_date_list" min="{{ date('Y-m-d') }}" required /></td>
                        <td><button type="button" name="remove" id="1" class="btn btn-danger btn_remove">Delete</button></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-end">
                <a href="{{ route('stock.index') }}"><button type="button" class="btn btn-secondary">Back</button></a>
                <input type="submit" id="submit" class="btn btn-info" value="Submit" />
            </div>
        </div>

    {{Form::close()}}
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            var i=1;

            $('#add').click(function(){
                i++;
                $('#repeater').append(
                    '<tr class="stock-added">'+
                        '<td><input type="text" name="item_code[]" id="item_code" placeholder="Enter item code" class="form-control item_code_list" required /></td>'+
                        '<td><input type="text" name="item_name[]" id="item_name" placeholder="Enter item name" class="form-control item_name_list" required /></td>'+
                        '<td><input type="text" name="quantity[]" id="quantity" placeholder="Enter quantity" class="form-control quantity_list" required /></td>'+
                        '<td><input type="text" name="location[]" id="location" placeholder="Enter location" class="form-control location_list" required /></td>'+
                        '<td><select class="form-control" id="store_id" name="store_id[]" required><option value="">Select Store</option> @foreach ($stores as $store) <option value="{{$store->id}}">{{$store->name}}</option> @endforeach </select></td>'+
                        '<td><input type="date" name="in_stock_date[]" id="in_stock_date" class="form-control in_stock_date_list" min="{{ date('Y-m-d') }}" required /></td>'+
                        '<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">Delete</button></td>'+
                    '</tr>'
                );
            });


            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $(this).closest('tr').remove();
            });
        });
    </script>
@endpush
