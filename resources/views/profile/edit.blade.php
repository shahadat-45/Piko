@extends('blank')
@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Edit profile</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <form class="forms-sample" method="POST" action="{{route('update.user')}}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                        @error('name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name='email' value="{{Auth::user()->email}}">
                        @error('email')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Change password</h3>
            </div>
            <div class="card-body">
                @if (session('successfull'))
                    <div class="alert alert-success">{{session('successfull')}}</div>
                @endif
                <form class="forms-sample" method="POST" action="{{route('change.password')}}">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                        @error('current_password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        @if(session('wrong_pass'))
                        <strong class="text-danger">{{ session('wrong_pass') }}</strong>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="password">
                        @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="conf_password">Confirm Password</label>
                        <input type="password" class="form-control" id="conf_password" name="password_confirmation">
                        @error('password_confirmation')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Change</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Change profile picture</h3>
            </div>
            <div class="card-body">
                @if(session('photo_updated'))
                    <div class="alert alert-success">{{ session('photo_updated') }}</div>
                @endif
                <form class="forms-sample" method="POST" action="{{route('change.profile.pic')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="photo">Select photo</label>
                        <input type="file" class="form-control" id="photo" name="profile_photo" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img src="{{asset('uploads/user')}}/{{Auth::user()->photo}}" id="blah" width="100" class="mt-2"/>
                        @error('profile_photo')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>    
@endsection
