@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">Referal Code</div>

                <form>
                    <div class="input-group">
                    <input class="form-control" type="text" value="{{url('').'/referral-code/'.Auth()->user()->invite_code }}" readonly id="myInput">
                    <button class="btn btn-default" onclick="myFunction()">Copy</button>
                    </div>
                </form>
            </div>
            
        </div>

        <div class="col-md-8">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">Invite</div>

                <form method="POST" action="{{ route("sendInvite") }}" >
                    @csrf
                    <div class="input-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" required autocomplete="email">
                   
                    <button class="btn btn-default">Send Invite</button>
                    </div>
                </form>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            
        </div>
        
   
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Invites ({{ count($UserReferred) }})</div>
                <div class="card-body">
                <div class="table-responsive">

                        <table class=" table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                              
                                   
                                        
                                        @foreach($UserReferred as $key => $item)
                                      
                                        <tr>
                                        <td>
                                            {{$item->user->email}}
                                        </td>
                                        <td>
                                            {{$item->user->name}}
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
@endsection
@section('scripts')
<script>

function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);
  
  // Alert the copied text
  alert("Copied");
}
</script>

@endsection