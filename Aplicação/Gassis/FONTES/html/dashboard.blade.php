@extends('templates.master')

@section('css-view')
<link rel="stylesheet" href="{{asset('/css/dashboard.css')}}">
@endsection

@section('js-view')
@endsection

@section('conteudo-view')

    @extends('templates.menuLateral')
    
    {!! Form::open(['class'=>'form','route'=>'requester.logout', 'method' => 'post']) !!}
    {!!Form::submit('Logout',['class'=>'form-submit']) !!}

@endsection

