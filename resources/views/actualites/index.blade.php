@extends('layouts.master')
@section('title', 'Actualités')
<link rel="stylesheet" href="{{asset('assets/css/styleactu.css')}}">
@section('content')

<script>
var NEWS = {!! $news !!};
</script>
<script src="{{asset('assets/js/test.js')}}"></script>

<section id ="news">
    <div class="container">
        <div class="row" id="rowactu">
            
        </div>
    </div>                
</section>

@endsection