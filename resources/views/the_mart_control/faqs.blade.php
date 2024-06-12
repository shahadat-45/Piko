@extends('blank')
@section('content')
<div class="row">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">FAQ List</h6>
                @if (session('deleted'))
                    <div class="alert alert-success">{{ session('deleted') }}</div>                    
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $index => $faq)
                               <tr>
                                <th>{{ $index + 1 }}</th>
                                <td>{{ $faq->question }}</td>
                                <td>{{ $faq->answer }}</td>
                                <td><a href="{{ route('faq.delete',$faq->id) }}"><button type="button" class="btn btn-danger btn-icon">
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
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
                <h6 class="card-title">Add FAQs</h6>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>                    
                @endif
                <form class="forms-sample" action="{{ route('add.faqs') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="Question">Question</label>
                        <input type="text" class="form-control" id="Question" placeholder="Question" name="question">
                        @error('question')
                            {{ $message }}                            
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea class="form-control" name="answer" id="answer" cols="30" rows="10">Type Answer...</textarea>
                            @error('answer')
                                {{ $message }}                            
                            @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
          </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">FAQs From Users</h6>
                @if (session('faq_deleted'))
                    <div class="alert alert-success">{{ session('faq_deleted') }}</div>                    
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Question</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs_store as $index => $faq)
                               <tr>
                                <th>{{ $index + 1 }}</th>
                                <td>{{ $faq->name }}</td>
                                <td>{{ $faq->email }}</td>
                                <td>{{ $faq->phone ?? 'N/A' }}</td>
                                <td>{{ $faq->question }}</td>
                                <td><a href="{{ route('faq_store.delete',$faq->id) }}"><button type="button" class="btn btn-danger btn-icon">
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
</div>
@endsection