@extends('layout.base')

<!-- Header -->
@include('templates.components.header')

<!-- Content -->
<div class="container">
    @yield('content')           
</div>

<!-- Footer -->
@include('templates.components.footer')