$(document).ready(function () {
   // Variables de consulta
    var search = '';
    var orderBy = 't_value';
    var orderWay = 'DESC';
    var fecha = $('#selectAnio').val();
    var tipoSesion = $('#selectTipoSesion').val();
    var limit = parseInt($('#selectDocsPagina').val());
    var offset = 0;
    var currentPage = 1;
    var token = 'F6GTUtqkF9NUMqE9q2PrCwm3QWTuuZqeGEW8mz9g';
    var timeOut = null; // Timeout para barra de búsqueda
    var totalDocs = 0;
    $('.fa-spinner').hide();
    $('.text-resultados').hide();

    // Obtener documentos de inicio
    getDocumentos();
    getTiposSesion();
    fillAnio();

    /**
     * Al hacer búsqueda en la barra
     */
    $('#searchbar').keyup(function() {
        offset = 0;
        currentPage = 1;
        search = $('#searchbar').val();
        clearTimeout(timeOut);
        timeOut = setTimeout(function () { // Cuando terminan de escribir, espera medio segundo y hace la búsqueda
           getDocumentos();
        }, 500);
    });


    /**
     * Cuando cambia el select de documentos por página
     */
    $("#selectDocsPagina").change(function() {
        offset = 0;
        currentPage = 1;
        limit = parseInt($('#selectDocsPagina').val());
        //if (limit > 0) // Si se pide paginación
            getDocumentos(false);
        //else // Si se piden todos los documentos
            //getAllDocumentos();
    });

    /**
     * Cuando cambia el select de tipo de sesión
     */
    $("#selectTipoSesion").change(function() {
        $('.cuerpo-tabla').empty();
        currentPage = 1;
        offset = 0;
        tipoSesion = $('#selectTipoSesion').val();
        getDocumentos(true);
    });

    /**
     * Cuando cambia el select de año
     */
    $("#selectAnio").change(function() {
        $('.cuerpo-tabla').empty();
        currentPage = 1;
        offset = 0;
        fecha = $('#selectAnio').val();
        getDocumentos(true);
    });

    /**
     * Al presionar las flechas de ordenamiento
     */
    $('.sort').click(function () {
        $('.cuerpo-tabla').empty();
        offset = 0;
        currentPage = 1;
        // Guardar la columna por la que se está ordenando
        var $column = $(this).attr('id');

        // Obtener el ícono (flecha) de esa columna y cambiar al contrario
        var $icon = $(this).find('i');
        if ($($icon).attr('class') == 'fa fa-chevron-circle-down') {
            $($icon).removeClass('fa-chevron-circle-down');
            $($icon).addClass('fa-chevron-circle-up');
            orderWay = 'ASC';
        } else {
            $($icon).removeClass('fa-chevron-circle-up');
            $($icon).addClass('fa-chevron-circle-down');
            orderWay = 'DESC';
        }

        // Encontrar todas las flechas de las columas que estén hacia arriba y reiniciarlas, menos la de la columna seleccionada
        var $arrowIcons = $("#table-header").find('.fa-chevron-circle-up').get();

        $arrowIcons.forEach(function ($i) {
            var $parent = $($i).parent().get();
            $('#'+$column).addClass('text-danger');
            if ($($parent).attr('id') != $column) {
                $($i).removeClass('fa-chevron-circle-up');
                $($i).addClass('fa-chevron-circle-down');
                $($parent).removeClass('text-danger');
            }
        });

        // Agregar o quitar el color rojo
        var $arrowIcons = $("#table-header").find('.fa').get();
        $arrowIcons.forEach(function ($i) {
            var $parent = $($i).parent().get();
            $('#'+$column).addClass('text-danger');
            if ($($parent).attr('id') != $column) {
                $($parent).removeClass('text-danger');
            }
        });

        // Colocar la columna de ordenamiento
        if ($column == 'sort-tipo') orderBy = 'm_value';
        else if ($column == 'sort-fecha') orderBy = 't_value';
        else if ($column == 'sort-naturaleza') orderBy = 'k_value';

        getDocumentos(true);
    });

    /**
     * Al hacer click en los elementos de paginación
     */
    $(document).on('click', '.page-link', function(){
        currentPage = parseInt($(this).val());
        offset = limit * (currentPage - 1);
        $('.cuerpo-tabla').empty();
        getDocumentos(false);

        //alert($(this).val());
    });

    /**
     * Al hacer click en [Ver más] de cada elemento
     */
    $(document).on('click', '.btn-ver-mas', function(){
        $('#modalInfo').modal('show');
        $('.modal-body').text($(this).val());
    });

    /**
     * Obtiene los documentos cuando se pide paginación
     */
   function getDocumentos(todos) {
        $('.fa-spinner').show();
       var params = {
           search: search,
           fecha: fecha,
           tipoSesion: tipoSesion,
           orderBy: orderBy,
           orderWay: orderWay,
           limit: limit,
           offset: offset,
           t: token
       };

       $.get("../api/index.php?action=getDocsJuntaGobierno", params, function(data) {
           $('.fa-spinner').hide();
           var res = JSON.parse(data);

           totalDocs = parseInt(res.pagination.total_rows);
           if (totalDocs === 0) $('.text-resultados').show();
           else $('.text-resultados').hide();

           setDocumentos(res.data, todos);
           setPagination(res.pagination);
           $('select[name=selectDocsPagina] > option:first-child')
               .text('Todos ('+totalDocs+')');
       }).fail(function() {$('.fa-spinner').hide();});
       if (todos) offset += 100; // Si se piden todos los documentos, incrementar poco a poco
    }

    /**
     * Obtiene los diferentes tipos de documentos
     */
    function getTiposSesion() {
        var params = {t: token};
       $.get("../api/index.php?action=getTiposSesion", params, function(data) {
           var res = JSON.parse(data);
           setTiposSesion(res.data);
       }).fail(function() {});
    }

    /**
     * Obtiene todos los documentos sin paginación
     */
    /*function getAllDocumentos() {
        $('.cuerpo-tabla').empty();
        limit = 100;
        offset = 0;

        getDocumentos(true);
        interval = setInterval(function () { // Obtiene poco a poco la lista de documentos
            getDocumentos(true);
            if (parseInt(totalDocs) <= parseInt(offset)) clearInterval(interval);
        }, 1000);
    }*/

   /**
     * Colocar la lista de documentos en la tabla
     */
   function setDocumentos(documentos, todos) {
       if(!todos) $('.cuerpo-tabla').empty();
        documentos.forEach(function (c, i) {
            var $col = '<tr>' +
                '       <td scope="row" class="text-center" valign="middle">' +
                '           <a href="http://localhost:8002/seeddms/data/1048576/'+c.documento+'/1.pdf" target="_blank">' +
                '           <img src="../src/images/pdf.png" class="pdf-icon"><br>' +
                '           </a>' +
                '           </td>' +
                '           <td><strong>'+c.fecha+'</strong></td>' +
                '       <td valign="middle">'+c.tipoSesion+'</td>' +
                '       <td>'+c.naturalezaSesion+'</td>';

            $col +=  '<td class="col-doc-'+c.documento+'"></td>' + // Docs para consulta
                     '<td class="col-doc-'+c.documento+'-acta-sesion"></td>' +
                     '<td class="col-doc-'+c.documento+'-aprobado"></td>' + // Docs para aprobados
                '</tr>';

            $($col).appendTo('.cuerpo-tabla');

            /* DOCUMENTOS PARA CONSULTA PREVIA */
            $ul = '<ul class="docs-consulta-'+c.documento+'"></ul>';
            $($ul).appendTo('.col-doc-'+c.documento);

            var documentosConsulta = c.documentosConsulta;
            documentosConsulta.forEach(function (d) {
                if (d.orgFileName !== null) {
                    var url = '';
                    if (d.name === 'Documentos aprobados') url = 'http://localhost:8002/seeddms/data/1048576/'+c.documento+'/f'+d.id+''+d.fileType;
                    else url = 'http://localhost:8002/seeddms/data/1048576/'+c.documento+'/f'+d.id+''+d.fileType;

                    $li = '<li><a target="_blank" href="'+url+'">'+d.orgFileName+'</a></li>';
                    $($li).appendTo('.docs-consulta-'+c.documento);
                }
            });

            /* DOCUMENTOS APROBADOS */
            $ul = '<ul class="docs-aprobados-'+c.documento+'"></ul>';
            $($ul).appendTo('.col-doc-'+c.documento+'-aprobado');

            var documentosAprobados = c.documentosAprobados;
            documentosAprobados.forEach(function (d) {
                if (d.orgFileName !== null) {
                    var url = '';
                    if (d.name === 'Documentos públicos para consulta previa') url = 'http://localhost:8002/seeddms/data/1048576/'+c.documento+'/f'+d.id+''+d.fileType;
                    else url = 'http://localhost:8002/seeddms/data/1048576/'+c.documento+'/f'+d.id+''+d.fileType;

                    $li = '<li><a target="_blank" href="'+url+'">'+d.orgFileName+'</a></li>';
                    $($li).appendTo('.docs-aprobados-'+c.documento);
                }
            });

            /* DOCUMENTOS ACTA DE SESIÓN */
            $ul = '<ul class="docs-acta-sesion-'+c.documento+'"></ul>';
            $($ul).appendTo('.col-doc-'+c.documento+'-acta-sesion');

            var actaSesion = c.actaSesion;
            actaSesion.forEach(function (d) {
                if (d.orgFileName !== null && d.document == c.documento) {
                    var url = '';
                    if (d.name === 'Acta de sesión') url = 'http://localhost:8002/seeddms/data/1048576/'+c.documento+'/f'+d.id+''+d.fileType;
                    else url = 'http://localhost:8002/seeddms/data/1048576/'+c.documento+'/'+d.id+''+d.fileType;

                    $li = '<li><a target="_blank" href="'+url+'">'+d.orgFileName+'</a></li>';
                    $($li).appendTo('.docs-acta-sesion-'+c.documento);
                }
            });
        });
   }

    /**
     * Coloca los tipos de documentos que existen
     * @param tipos
     */
   function setTiposSesion(tipos) {
       //$('#selectTipoDocumento').empty();
        tipos.forEach(function (t) {
            var $option = '<option value="'+t+'">'+t+'</option>';
            $($option).appendTo('#selectTipoSesion');
        });
   }

   /**
     * Coloca la paginación
     */
   function setPagination(pagination) {
       if (parseInt($('#selectDocsPagina').val()) == 0) // Si se pidieron todos los documentos, no paginar
           $('.paginacion').hide();
       else {
           $('.paginacion').show();
           $('.paginacion').empty();

           var totalPaginas = Math.ceil(parseInt(pagination.total_rows) / limit);

           var $paginacion = '<nav aria-label="..." class="paginador-iieg">' +
               '                <ul class="pagination justify-content-end">';

           if (currentPage == 1){
               $paginacion += '<li class="page-item disabled">' +
                   '                <button class="page-link" tabindex="-1" value="'+(currentPage-1)+'">&laquo;</button>' +
                   '           </li>';
           } else {
               $paginacion += '<li class="page-item">' +
                   '                <button class="page-link" tabindex="-1" value="'+(currentPage-1)+'">&laquo;</button>' +
                   '           </li>';
           }

           for (var i = 0; i < totalPaginas; i++) {
               if (currentPage == i + 1)
                   $paginacion += '<li class="page-item active"><button class="page-link" value="'+(i+1)+'">'+ (i+1) +'</button></li>';
               else
                   $paginacion += '<li class="page-item"><button class="page-link" value="'+(i+1)+'">'+ (i+1) +'</button></li>';
           }

           if (currentPage == totalPaginas) {
               $paginacion += '<li class="page-item disabled">' +
                   '                <button class="page-link" value="'+(currentPage+1)+'">&raquo;</button>' +
                   '            </li>' +
                   '           </ul>' +
                   '       </nav>';
           } else {
               $paginacion += '<li class="page-item">' +
                   '                <button class="page-link" value="'+(currentPage+1)+'">&raquo;</button>' +
                   '            </li>' +
                   '           </ul>' +
                   '       </nav>';
           }

           $('.paginacion').append($paginacion);
       }
   }

    /**
     * Al exportar en excel
     */
   $("#btnExport").click(function(e) {
       var params = {
           search: search,
           fecha: fecha,
           tipoSesion: tipoSesion,
           orderBy: orderBy,
           orderWay: orderWay,
           limit: limit,
           offset: offset,
           t: token
       };
       window.open('../export/junta-de-gobierno.php?'+$.param(params));
   });

   function fillAnio() {
       // Obtener año actual
       var currentDate = new Date();
       for(var i = currentDate.getFullYear(); i >= 2014; i--) {
           $li = '<option value="'+i+'">'+i+'</option>';
           $($li).appendTo('#selectAnio');
       }
   }

});