<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container mt-3">
    {{-- @hasrole('Admin')
    I am a Admin!
@else
    I am not a admin...
@endhasrole --}}
{{-- {{dd(Auth::user()->roles()->parent()->relations()->items()->attributes()->name)}} --}}

{{-- {{Auth::user()->role()}} --}}
    <h3>{{Auth::user()->getRoleNames()->first()}}</h3><br>
<h3>Welcome <b class="text-success">{{Auth::user()->username}} </b></h3>
<br>
<a href="logout" class="btn btn-danger">Logout</a><br>
</div>
