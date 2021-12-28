@extends('layouts.app')
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Exercício</div>
                    <div class="card-body">
                        @if (session()->has('sucess.message'))
                            <div class="alert alert-success" role="alert">
                                 {{ session('sucess.message') }}
                            </div>
                        @endif
                    </div>

                    <form class="form-horizontal p-3" action="{{route('exercise-update' , ['id' => $exercise->id] )}}"  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>Nível do exercício</label>
                            <select class="form-control" id="treatmentLevel" name="treatmentLevel">
                                <option value="">Defina o nível do tratamento do exercício</option>
                                <option value="t1" {{ $exercise->treatmentLevel == 't1' ? 'selected' : '' }}>T1</option>
                                <option value="t2" {{ $exercise->treatmentLevel == 't2' ? 'selected' : '' }}>T2</option>
                                <option value="t3" {{ $exercise->treatmentLevel == 't3' ? 'selected' : '' }}>T3</option>
                                <option value="t4" {{ $exercise->treatmentLevel == 't4' ? 'selected' : '' }}>T4</option>
                            </select>
                         </div>

                        <div class="form-group">
                            <label>Imagem</label>
                            <img src="{{$exercise->img}}?w=240&h=240" class="card-img-top">
                            <input type="file" class="form-control"  name="exerciseImage">
                        </div>

                        <!--<div class="form-group">
                            <label>Video</label>
                            <video width="320" height="240" controls>
                            <source src="{{$exercise->video}}" type="video/mp4">
                            Your browser does not support the video tag.
                            </video>

                            <input type="file" class="form-control"  name="exerciseVideo">
                        </div>-->

                        <div class="form-group">
                            <label>Nome do exercício</label>
                            <input value="{{$exercise->name}}" type="text" class="form-control" name="exerciseName" >
                        </div>

                        <div class="form-group">
                            <label>Descrição do exercício</label>
                            <textarea type="text" class="form-control tinymce-editor" name="exerciseDescription">{{$exercise->description}}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Repetição do exercício</label>
                            <input value="{{$exercise->repetition}}" type="text" class="form-control" name="exerciseRepetition" >
                        </div>

                        <div class="form-group">
                            <label>Youtube</label>
                            <textarea type="text" class="form-control" name="exerciseYoutube">{{$exercise->youtube}}</textarea>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <label>Passo a passo</label>
                            </div>

                            <div class="card-body">
                                @foreach($exercise->stepbysteps as $stepbysteps)
                                    <div class="stepbystep" class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label>Descrição</label>
                                                <textarea type="text" class="form-control tinymce-editor" name="descStep[]">{{$stepbysteps->descStep}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!--<button id="btn_stepbystep_edit" type="button" class="btn btn-secondary">Adicionar novo passo</button>-->
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    tinymce.init({
    selector: 'textarea.tinymce-editor',
    height: 500,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
    'bold italic backcolor | alignleft aligncenter ' +
    'alignright alignjustify | bullist numlist outdent indent | ' +
    'removeformat | help',
    content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
</script>

@endsection
