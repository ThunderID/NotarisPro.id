@extends('layout.base')

<!-- Header -->
@include('templates.components.header')

<!-- Content -->
<div class="container-fluid">
    @yield('content')           
</div>

<!-- Footer -->
@include('templates.components.footer')