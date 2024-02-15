@extends('blank')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>Welcome , {{Auth::user()->name}}</h3>                
                    </div>
                    <div class="card-body">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maiores provident sed earum veritatis explicabo ducimus a dolores cum molestiae quasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection