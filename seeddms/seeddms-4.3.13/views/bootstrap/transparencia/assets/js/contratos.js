$(document).ready(function () {
   // Variables de consulta
    var search = '';
    var orderBy = 'id';
    var orderWay = 'ASC';
    var tipoContrato = $('#selectTipoContrato').val();
    var anio = $('#selectAnio').val();
    var monto = parseInt($('#selectMonto').val());
    var limit = parseInt($('#selectDocsPagina').val());
    var offset = 0;
    var currentPage = 1;
    var token = 'F6GTUtqkF9NUMqE9q2PrCwm3QWTuuZqeGEW8mz9g';
    var timeOut = null; // Timeout para barra de búsqueda
    var totalDocs = 0;
    $('.fa-spinner').hide();
    $('.text-resultados').hide();
    $('.barra-filtros').hide(); // Esconder la barra de filtros

    /*var params = {
        tipoContrato: $('#selectTipoContrato').val(),
        monto: parseInt($('#selectMonto').val()),
        anio: $('#selectAnio').val(),
        search: '',
        orderBy: 'id',
        orderWay: 'ASC',
        limit: parseInt($('#selectDocsPagina').val()),
        offset: 0
    };*/

    // Obtener contratos de inicio
    getContratos();
    getTiposContrato();
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
           getContratos();
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
            getContratos(false);
        //else // Si se piden todos los contratos
            //getAllContratos();
    });

    /**
     * Cuando cambia el select de tipo de contrato
     */
    $("#selectTipoContrato").change(function() {
        $('.cuerpo-tabla').empty();
        currentPage = 1;
        offset = 0;
        tipoContrato = $('#selectTipoContrato').val();
        getContratos(true);
    });

    /**
     * Cuando cambia el select de monto
     */
    $("#selectMonto").change(function() {
        $('.cuerpo-tabla').empty();
        currentPage = 1;
        offset = 0;
        monto = parseInt($('#selectMonto').val());
        getContratos(true);
    });

    /**
     * Cuando cambia el select de Año
     */
    $("#selectAnio").change(function() {
        $('.cuerpo-tabla').empty();
        currentPage = 1;
        offset = 0;
        anio = $('#selectAnio').val();
        getContratos(true);
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
        if ($column == 'sort-no-contrato') orderBy = 't_value';
        else if ($column == 'sort-tipo-contrato') orderBy = 'k_value';
        else if ($column == 'sort-nombre-persona') orderBy = 'm_value';
        //else if ($column == 'sort-monto') orderBy = 'n_value';
        else if ($column == 'sort-monto') orderBy = 'n.monto';
        else if ($column == 'sort-acciones') orderBy = 'p_value';
        else if ($column == 'sort-proyecto') orderBy = 'q_value';
        else if ($column == 'sort-vigencia') orderBy = 'g_value';

        getContratos(true);
    });

    /**
     * Al hacer click en los elementos de paginación
     */
    $(document).on('click', '.page-link', function(){
        currentPage = parseInt($(this).val());
        offset = limit * (currentPage - 1);
        $('.cuerpo-tabla').empty();
        getContratos(false);

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
     * Obtiene los contratos cuando se pide paginación
     */
   function getContratos(todos) {
        $('.fa-spinner').show();
       var params = {
           search: search,
           tipoContrato: tipoContrato,
           monto: monto,
           anio: anio,
           orderBy: orderBy,
           orderWay: orderWay,
           limit: limit,
           offset: offset,
           t: token
       };

       $.get("../api/index.php?action=getDocs&documentType=Contratos", params, function(data) {
           $('.fa-spinner').hide();
           var res = JSON.parse(data);

           totalDocs = parseInt(res.pagination.total_rows);
           if (totalDocs === 0) $('.text-resultados').show();
           else $('.text-resultados').hide();

           setContratos(res.data, todos);
           setPagination(res.pagination);
           setFileInfo(res.docs); console.log(totalDocs);
           $('select[name=selectDocsPagina] > option:first-child')
               .text('Todos ('+totalDocs+')');
       }).fail(function() {$('.fa-spinner').hide();});
       if (todos) offset += 100; // Si se piden todos los documentos, incrementar poco a poco
    }

    /**
     * Obtiene los diferentes tipos de contratos
     */
    function getTiposContrato(todos) {
       var params = {documentType: 'Contratos', t: token};
       $.get("../api/index.php?action=getTiposDoc", params, function(data) {
           var res = JSON.parse(data);
           setTiposContrato(res.data);
       }).fail(function() {});
    }

   /**
     * Colocar la lista de contratos en la tabla
     */
   function setContratos(contratos, todos) {
       if(!todos) $('.cuerpo-tabla').empty();
        contratos.forEach(function (c, i) {
            var $col = '<tr>' +
                '       <th scope="row" class="text-center" valign="middle">' +
                '           <a href="https://iieg.gob.mx/seeddms-4.3.13/data/1048576/'+c.id+'/'+c.version+c.formato+'" target="_blank">' +
                '           <img src="../src/images/pdf.png" class="pdf-icon"><br>' +
                '           <span href="#" class="badge badge-primary">'+c.numeroContrato+'</span>' +
                '           </a>' +
                '           </th>' +
                '           <td><strong>'+c.tipoContrato+'</strong></td>' +
                '       <td>'+c.nombrePersona+'</td>' +
                '       <td>'+c.monto+'</td>';

            if (c.acciones.length < 50)
                $col += '<td>'+c.acciones +'</td>';
            else
                $col += '<td>'+c.accionesShort +'<button class="btn btn-link btn-sm btn-ver-mas" data-toggle="modal" data-target="#modalInfo" value="'+c.acciones+'">[Ver más]</button></td>';


            if (c.proyecto.length < 50)
                $col += '<td>'+c.proyecto +'</td>';
            else
                $col += '<td>'+c.proyectoShort +'<button class="btn btn-link btn-sm btn-ver-mas" data-toggle="modal" data-target="#modalInfo" value="'+c.proyecto+'">[Ver más]</button></td>';

            $col +=  '<td>'+c.vigencia+'</td></tr>';

            $($col).appendTo('.cuerpo-tabla');
        });
   }

    /**
     * Coloca los tipos de contratos que existen
     * @param tipos
     */
   function setTiposContrato(tipos) {
       //$('#selectTipoContrato').empty();
        tipos.forEach(function (t) {
            var $option = '<option value="'+t+'">'+t+'</option>';
            $($option).appendTo('#selectTipoContrato');
        });
   }

   /**
     * Coloca la paginación
     */
   function setPagination(pagination) {
       if (parseInt($('#selectDocsPagina').val()) == 0 || pagination.total_rows == "0")  // Si se pidieron todos los documentos, no paginar
           $('.paginacion').hide();
       else {
           $('.paginacion').show();
           $('.paginacion').empty();

           var totalPaginas = Math.ceil(parseInt(pagination.total_rows  || pagination.total_rows == "0") / limit);

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
           action: 'getDocs',
           documentType: 'Contratos',
           tipoContrato: tipoContrato,
           monto: monto,
           anio: anio,
           orderBy: orderBy,
           orderWay: orderWay,
           limit: limit,
           offset: offset
       };
       window.open('../export/contratos.php?'+$.param(params));
   });


    /**
     * Al descargar contratos en zip
     */
    $("#btn-download").click(function(e) {
        var params = {
            export: 'contratos',
            search: search,
            action: 'getDocs',
            documentType: 'Contratos',
            tipoContrato: tipoContrato,
            monto: monto,
            anio: anio,
            orderBy: orderBy,
            orderWay: orderWay,
            limit: limit,
            offset: offset
        };
        window.open('../export/zipfile.php?'+$.param(params));
    });


    $("#btn-filtros").click(function(e) {
        $('.barra-filtros').slideToggle();
    });

    /**
     * Llenar select de año
     */
    function fillAnio() {
        // Obtener año actual
        var currentDate = new Date();
        for(var i = currentDate.getFullYear(); i >= 2014; i--) {
            $li = '<option value="'+i+'">'+i+'</option>';
            $($li).appendTo('#selectAnio');
        }
    }

    /**
     * Coloca la información del archivo a descargar (ZIP)
     */
    function setFileInfo(zipInfo) {
        var text = zipInfo.totalDocs + ' documentos, tamaño total: ';
        var bytes = zipInfo.zipSize;
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        var total = Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];

        if (parseInt(bytes) === 0) total = '0 bytes';

        text += total+ ' aprox.';
        $('.zip-info').empty();
        $('.zip-info').append(text);
        console.log(total);
    }

});