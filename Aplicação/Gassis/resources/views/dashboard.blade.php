@extends('templates.master')

@section('css-view')
@endsection

@section('js-view')
@endsection

@section('conteudo-view')

    {!! Form::open(['class'=>'form','route'=>'requester.logout', 'method' => 'post']) !!}
    {!!Form::submit('Logout',['class'=>'form-submit']) !!}

@endsection

