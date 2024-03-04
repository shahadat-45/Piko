@extends('blank')
@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
                <h6 class="card-title">Newsletter List</h6>
                <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emails as $index => $email)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $email->emails }}</td>
                                        <td>button</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
          </div>
        </div>
    </div>
    <div class="col-md-4 ml-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Newsletter Banner</h6>
                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('newsletter.update') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <textarea class="form-control mb-1" name="title" id="exampleInputEmail1"> {!! App\Models\Newsletter::find(1)->title !!} </textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Image</label>
                        <input type="file" class="form-control mb-1" name="image" id="exampleInputUsername1" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
                        <img src="{{ asset('uploads') }}/theMart/{{ App\Models\Newsletter::find(1)->image }}" class="mt-2" height="88px" id="blah">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection