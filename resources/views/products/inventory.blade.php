@extends('blank')
@section('content')
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Inventory List</h6>
                @if (session('delete_inventory'))                    
                <div class="alert alert-success" role="alert">{{ session('delete_inventory') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Color</th>
                                <th>Size</th>
                                <th>New Price</th>
                                <th>Discount Price</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory as $inventory)                                
                            <tr class="{{ $inventory->quantity < 6 ? 'bg-danger-subtle' : '' }}" data-toggle="tooltip" data-placement="top" title="{{ $inventory->quantity < 6 ? 'Stock Out Soon' : '' }}">
                                <th>{{ $inventory->rel_to_color->color_name }}</th>
                                <td>{{ $inventory->rel_to_size->size }}</td>
                                <td>{{ $inventory->new_price }}</td>
                                <td>{{ $inventory->after_discount }}</td>
                                <td>{{ $inventory->quantity }}</td>
                                <td><a href="{{ route('inventory.delete', $inventory->id) }}"><button type="button" class="btn btn-danger btn-icon">
                                    <i data-feather="trash"></i>
                                </button></a></td>
                            </tr>                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
		</div>
        <div class="col-md-4 grid-margin stretch-card ml-auto">
            <div class="card">
                <form action="{{ route('add.inventory') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <h6 class="card-title">Add Inventories</h6>
                        {{-- <p class="mb-3">Use class <code>.form-control-lg</code> or <code>.form-control-sm</code></p> --}}
                        <div class="form-group">
                            <label>Select Color</label>
                            <select class="form-control form-control-sm mb-3" name="color">
                                <option selected="">select color from this menu</option>
                                @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>
                            @error('color_id')
                                <strong class="text-danger">{{ $message }}</strong>                                
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Select Size</label>
                            <select class="form-control mb-3" name="size">
                                <option selected="">select size from this menu</option>
                                @foreach ($size as $size)
                                <option value="{{ $size->id }}">{{ $size->size }}</option>
                                @endforeach
                            </select>
                            @error('size_id')
                                <strong class="text-danger">{{ $message }}</strong>                                
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>New Price</label>
                            <input type="number" name="new_price" class="form-control form-control-lg" placeholder="old price - {{ App\Models\Products::find($product_id)->price }}"/>
                            @error('new_price')
                                <strong class="text-danger">{{ $message }}</strong>                                
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="quantity" class="form-control form-control-lg" placeholder="add stock quantity"/>
                            <input type="hidden" name="product_id" value="{{ $product_id }}"/>
                            @error('quantity')
                                <strong class="text-danger">{{ $message }}</strong>                                
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Insert</button>
                        </div>
                    </div>
                </form>    
            </div>
        </div>
    </div>
@endsection