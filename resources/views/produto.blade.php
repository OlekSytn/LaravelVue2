@extends('layouts.app')
@section('content')
<div class="container">

    <form-produto url="{{route('apiProdutoStore')}}"></form-produto>
    <table-produto url="{{route('apiProdutoIndex')}}"></table-produto>
</div>

@endsection