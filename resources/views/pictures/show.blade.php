@extends('layouts.app')
@section('content')
    <h1>Gallery {{$picture->title}}</h1>
    <p>Auteur {{$picture->gallery->author}}</p>
            <img src="{{ route('galleries.pictures.show', compact('gallery','picture'))}}"/>
@endsection