@extends('layout.base')

<!-- Content -->
@section('template')

<!-- Header -->
@include('templates.components.header')

<div class="container-fluid" style="padding-top: 54px;">
    @yield('content')           
</div>

<!-- Footer -->
@include('templates.components.footer')

@stop