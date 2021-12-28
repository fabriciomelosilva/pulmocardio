@extends('layouts.app')

@section('content')

<div class="container">
@if (session()->has('sucess.message'))
    <div class="alert alert-success">
    {{ session('sucess.message') }}
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
            <td>Exercício</td>
            <td>Nível do Tratamento</td>
            <td>Ação</td>
        </tr>
    </thead>
    <tbody>

        @foreach($exercises as $key => $exercises)
          <tr>
            <td>{{$exercises->name}}</td>
            <td>{{$exercises->treatmentLevel}}</td>
            <td><a href="{{ route('exercise-edit', $exercises->id)}}"  class="btn btn-primary">Editar</a></td>
            <td>
            <form action="{{ route('exercise-delete', $exercises->id) }}" method="post">
                @csrf
                <button class="btn-delete-program btn btn-danger" type="submit">Excluir</button>
            </form>
            </td>
          </tr>
        @endforeach
    </tbody>
  </table>
<div>
@endsection
