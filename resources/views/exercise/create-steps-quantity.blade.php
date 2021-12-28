@extends('layouts.app')
    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">O exercício terá quantos passos?</div>
                        <div class="card-body">
                        <form class="form-horizontal p-3" id="quantitySteps" action="/admin/store/exercise/quantity" method="get">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Passos</label>
                                <input type="text" class="form-control" name="quantitySteps">
                                <button type="submit" class="btn btn-primary">Seguinte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection
