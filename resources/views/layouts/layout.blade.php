<!DOCTYPE html>
<html lang="en">
<head>
    @extends('fixed.head')
</head>
    <body>
        @include('fixed.header')
        @yield('content') 
        
        @include('fixed.scripts')
        @include('fixed.footer')
    </body>
</html>