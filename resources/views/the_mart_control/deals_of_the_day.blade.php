@extends('blank')
@section('header_links')
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatables.net-bs4/dataTables.bootstrap4.css">    
<link rel="stylesheet" href="{{ asset('assets') }}/css/switch.css">
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <h6 class="card-title">Products list</h6>
            <p class="card-description">Select Maximum <a class="text-success" style="font-weight: bold ; font-size: 0.950rem"> 2 </a> Product For Deals Of The Day</p>
                <div class="table-responsive">
                    <div id="dataTableExample_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="dataTableExample" class="table dataTable no-footer" role="grid" aria-describedby="dataTableExample_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending">Discount</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending">preview image</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending">Show/off</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)                                            
                                            <tr>
                                                <td class="sorting_1">{{ $product->product_name }}</td>
                                                <td>{{ $product->discount }}%</td>
                                                <td><img class="img-xs rounded-circle" src="{{ asset('uploads/product') }}/{{ $product->thumbnail }}" alt="{{ $product->thumbnail }}"></td>
                                                <td>                                                    
                                                    <label class="switch" data-show="{{ $product->id }}" onclick="submitDetailsForm()"> 
                                                        <input  id="switch" type="checkbox" {{ $product->product_type == 2 ? 'checked' : '' }}>
                                                        <span class="slider round"></span>
                                                    </label>
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
<form action="{{ route('deals.product') }}" method="POST" id="switch2">
    @csrf
    <input class="product_id_show" type="hidden" name="show">
</form>
@endsection
@section('footer-script')
<script src="{{asset('assets')}}/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="{{asset('assets')}}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="{{asset('assets')}}/js/data-table.js"></script>
<script>
    $('.switch').click(function(){
        var show = $(this).attr('data-show');
        // alert(show)
        $('.product_id_show').val(show);
    })    
    function submitDetailsForm() {
       $("#switch2").submit();
    }
</script>
@endsection