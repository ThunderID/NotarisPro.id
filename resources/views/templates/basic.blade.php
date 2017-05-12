@extends('layout.base')

<!-- Header -->
@include('templates.components.header')

<!-- Content -->
@section('template')
<div class="container-fluid" style="padding-top: 54px;">
    @yield('content')           
</div>
@stop

<!-- Footer -->
@include('templates.components.footer')