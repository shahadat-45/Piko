@extends('blank')
@section('header_links')
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatables.net-bs4/dataTables.bootstrap4.css">    
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <h6 class="card-title">Products list</h6>
            @if (session('deleted'))
            <div class="alert alert-success" role="alert">{{ session('deleted') }}</div>
            @endif
            {{-- <p class="card-description">Read the <a href="https://datatables.net/" target="_blank"> Official DataTables Documentation </a>for a full list of instructions and other options.</p> --}}
                <div class="table-responsive">
                    <div id="dataTableExample_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="dataTableExample" class="table dataTable no-footer" role="grid" aria-describedby="dataTableExample_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">Price</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending">Discount</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending">preview image</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Photo gellery</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)                                            
                                            <tr>
                                                <td class="sorting_1">{{ $product->product_name }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->discount }}%</td>
                                                <td><img class="img-xs rounded-circle" src="{{ asset('uploads/product') }}/{{ $product->thumbnail }}" alt="{{ $product->thumbnail }}"></td>
                                                <td>
                                                    @foreach (App\Models\Gallery::where('product_id', $product->id)->get() as $img)
                                                    <img class="img-xs rounded-circle" src="{{ asset('uploads/product') }}/{{ $img->images }}" alt="{{ $img->images }}">
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{ route('inventory',$product->id) }}"><button title="Inventory" type="button" class="btn btn-primary btn-icon">
                                                        <i data-feather="file-text"></i>
                                                    </button></a>
                                                    <a href="{{ route('product.view',$product->id) }}"><button title="View" type="button" class="btn btn-info btn-icon">
                                                        <i data-feather="external-link"></i>
                                                    </button></a>
                                                    <a href="{{ route('delete.product',$product->id) }}"><button title="Delete" type="button" class="btn btn-danger btn-icon">
                                                        <i data-feather="trash"></i>
                                                    </button></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-script')
<script src="{{asset('assets')}}/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="{{asset('assets')}}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="{{asset('assets')}}/js/data-table.js"></script>
@endsection