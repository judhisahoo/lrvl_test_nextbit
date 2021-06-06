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
        <h2 class="title">Dashboard</h2>
        @if( Session::has('message') )
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-lg EmailByEventListener">Email by Event Listener</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-secondary btn-lg EmailByQueryListener">Email By Query Listener</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('customscript')
<script>
$(function(){
    $('.EmailByEventListener').click(function(){
        location.href='{{url("/send-mail-by-event")}}';
    });

    $('.EmailByQueryListener').click(function(){
        location.href='{{url("/send-mail-by-queue")}}';
    });

    send-mail-by-queue
});
</script>
@endpush
