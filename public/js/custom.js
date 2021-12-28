jQuery(document).ready(function() {
    var x = 1;
    $('#btn_stepbystep').click(function(e) {
        e.preventDefault();
                $('.stepbystep').last().append('<div id="son" class="row">\
                                        <div class="col">\
                                            <label>Imagem</label>\
                                            <input type="file" class="form-control" name="imgStep[]">\
                                        </div>\
                                        <div class="col">\
                                            <label>Descrição</label>\
                                            <textarea type="text" class="form-control" name="descStep[]"></textarea>\
                                            <a href="#" id="remover_campo">Remover</a>\
                                        </div>\
                                    </div>');
                                    x++;
    });

    $('#btn_stepbystep_edit').click(function(e) {
        e.preventDefault();
                $('.stepbystep').last().append('<div id="son" class="row">\
                                        <div class="col">\
                                            <label>Imagem</label>\
                                            <input type="file" class="form-control" name="imgStepNew[]">\
                                        </div>\
                                        <div class="col">\
                                            <label>Descrição</label>\
                                            <textarea type="text" class="form-control" name="descStepNew[]"></textarea>\
                                            <a href="#" id="remover_campo">Remover</a>\
                                        </div>\
                                    </div>');
                                    x++;
    });

    $('.stepbystep').on("click","#remover_campo",function(e) {
        e.preventDefault();
        $(this).parents('#son').remove();
        x--;
    });

});
