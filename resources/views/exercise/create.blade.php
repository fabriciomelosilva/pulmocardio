@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar Exercícios</div>
                    <div class="card-body">
                        @if (session()->has('sucess.message'))
                            <div class="alert alert-success" role="alert">
                                 {{ session('sucess.message') }}
                            </div>
                        @endif
                    </div>

                    <?php 
                    
                    if (isset($quantitySteps)){
                        $teste = $quantitySteps;
                    }
                    
                    //exit();
                    ?>

                    <form class="form-horizontal p-3" id="createexercise" action="/admin/store/exercise" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        
                        <div class="form-group">
                            <label>Nível do exercício</label>
                            <select class="form-control" id="treatmentLevel" name="treatmentLevel">
                            <option selected value="">Defina o nível do tratamento do exercício</option>
                                <option value="t1">T1</option>
                                <option value="t2">T2</option>
                                <option value="t3">T3</option>
                                <option value="t4">T4</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nome do exercício</label>
                            <input type="text" class="form-control" name="exerciseName">
                        </div>

                        <div class="form-group">
                            <label>Descrição do exercício</label>
                            <textarea type="text" class="form-control tinymce-editor" name="exerciseDescription"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Repetição do exercício</label>
                            <input type="text" class="form-control" name="exerciseRepetition">
                        </div>

                        <div class="form-group">
                            <label>Imagem do exercício</label>
                            <input type="file" class="form-control"  name="exerciseImage">
                        </div>

                        <div class="form-group">
                            <label>Vídeo do exercício</label>
                            <input type="file" class="form-control"  name="exerciseVideo">
                        </div>

                        <div class="form-group">
                            <label>Youtube</label>
                            <input type="text" class="form-control"  name="exerciseYoutube">
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <label>Passo a passo</label>
                            </div>
                                <div class="stepbystep" class="form-group">
                                <?php if (isset($teste)) : ?>
                                <?php for ($i = 1; $i <= $teste ; $i++) : ?>
                                    <div class="row">
                                        <div class="col">
                                        <?php echo "<label>Descrição do passo: $i </label>"; ?>
                                            <textarea type="text" class="form-control tinymce-editor" name="descStep[]"></textarea>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                <?php endif; ?>
                                </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
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
