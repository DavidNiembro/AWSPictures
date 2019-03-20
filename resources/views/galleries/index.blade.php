@extends('layouts.app')
@section('content')
    <h1>Galleries</h1>
    <ul>
    @foreach($galleries as $gallery)
        <li><a href={{route('galleries.pictures.show', compact('gallery','picture'))}}>{{$gallery->name}}</a></li>
    @endforeach
    </ul
@endsection