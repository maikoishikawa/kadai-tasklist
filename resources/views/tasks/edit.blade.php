@extends('layouts.app')

@section('content')

    <h1>id: {{ $task->id }} のタスク編集ページ</h1>

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
            {!! Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'put']) !!}
        
                {!! Form::label('status', 'ステータス:') !!}
                {!! Form::text('status', null, ['class' => 'form-control']) !!}
        
                {!! Form::label('content', 'メッセージ:') !!}
                {!! Form::text('content', null, ['class' => 'form-control']) !!}
        
                {!! Form::submit('更新', ['class' => 'btn btn-primary']) !!}
        
            {!! Form::close() !!}
        </div>
    </div>

@endsection