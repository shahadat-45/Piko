@extends('blank')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">List of users</h6>
                    @if(session('delete_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('delete_success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <p class="card-description">Your can control your user from here</p>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joining Date</th>
                                    <th>Delete</th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach ($users as $key => $user)
                                <tr>
                                    <th>
                                        @if($user->photo == NULL)
                                        <img src="{{ Avatar::create($user->name)->toBase64() }}" width="40"/>
                                        @else
                                        <img src="{{asset('uploads/user')}}/{{$user->photo}}" alt="profile_photo" width="40" class="rounded-circle">
                                        @endif
                                    </th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td><a href="{{route('user.delete', $user->id)}}"><button type="button" class="btn btn-danger btn-icon"><i data-feather="trash"></i></button></a></td>
                                </tr>                                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection