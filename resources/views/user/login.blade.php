@extends('layouts.app')
@section('content')
<style>
    .card-2 .card-heading{
        background: url({{asset('assets/img/bg-heading-02.jpg')}});
    }
</style>
<div class="card card-2">
    <div class="card-heading"></div>
    <div class="card-body">
        <h2 class="title">Login</h2>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            @if( Session::has('message') )
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>
            @endif
        @endif
        <form method="POST" name="login" id="login" action="{{url('login')}}">
            @csrf
            <div class="input-group">
                <input class="input--style-2" type="email" placeholder="Enter Email" name="username" id="username" required>
            </div>

            <div class="input-group">
                <input class="input--style-2" type="password" placeholder="Name" name="password" id="password" required>
            </div>

            <div class="p-t-30">
                <button class="btn btn--radius btn--green" type="submit">Submit</button>
            </div>
            <div class="p-t-30">
                <p>Are you not registration yet ? <a href="{{ url('/register') }}">Register Hre</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
