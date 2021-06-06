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
        <h2 class="title">Registration Info</h2>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            @if(isset($error))
                <div> {{ $error }} </div>
            @endif
        @endif
        <form method="POST" name="registration_frm" id="registration_frm" action="{{url('/register')}}">
            @csrf
            <div class="input-group">
                <input class="input--style-2" type="text" placeholder="Enter your Full Name" name="name" id="name" required value="{{old('name')}}">
            </div>
            <div class="input-group">
                <input class="input--style-2" type="email" placeholder="Enter Email" name="username" id="username" required value="{{old('username')}}">
            </div>
            <div class="input-group">
                <input class="input--style-2" type="password" placeholder="Enter Passswrod" name="password" id="password" required>
            </div>
            <div class="input-group">
                <input class="input--style-2" type="password" placeholder="Enter Passswrod" name="password_confirmation" id="password_confirmation" required>
            </div>
            <div class="p-t-30">
                <button class="btn btn--radius btn--green" type="submit">Search</button>
            </div>
            <div class="p-t-30">
                <p>Are you Already registered ? <a href="{{ url('/login') }}">Login Here</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
{{--@push('customscript')
<script src="{{ asset('assets/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-validation/additional-methods.min.js') }}"></script>
<script>
    $(function () {
      $.validator.setDefaults({
        submitHandler: function () {
          return true;
        }
      });
      $('#registration_frm').validate({
        rules: {
          username: {
            required: true,
            email: true,
          },
          password: {
            required: true,
            minlength: 5
          },
          password_confirmation:{
            required: true,
            minlength: 5,
            equalTo : "#password"
          }
        },
        messages: {
          username: {
            required: "Please enter a user name",
            email: "Please enter a vaild email address"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
          }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
    </script>
@endpush--}}
