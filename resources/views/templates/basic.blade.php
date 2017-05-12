@extends('layout.base')

<!-- Header -->
@include('templates.components.header')

<!-- Content -->
<div class="container-fluid" style="padding-top: 54px;height: 100%;">
    @yield('content')           
</div>

<!-- Footer -->
@include('templates.components.footer')