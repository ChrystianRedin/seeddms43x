$(document).ready(function () {
   // Variables de consulta
    var search = '';
    var orderBy = 'id';
    var orderWay = 'DESC';
    var tipoContrato = $('#selectTipoConvenio').val();
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

    // Obtener convenios de inicio
    getConvenios();
    getTiposConvenio();
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
           getConvenios();
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
            getConvenios(false);
        //else // Si se piden todos los convenios
            //getAllConvenios();
    });

    /**
     * Cuando cambia el select de tipo de convenio
     */
    $("#selectTipoConvenio").change(function() {
        $('.cuerpo-tabla').empty();
        currentPage = 1;
        offset = 0;
        tipoContrato = $('#selectTipoConvenio').val();
        getConvenios(true);
    });

    /**
     * Cuando cambia el select de Año
     */
    $("#selectAnio").change(function() {
        $('.cuerpo-tabla').empty();
        currentPage = 1;
        offset = 0;
        anio = $('#selectAnio').val();
        getConvenios(true);
    });

    /**
     * Cuando cambia el select de monto
     */
    $("#selectMonto").change(function() {
        $('.cuerpo-tabla').empty();
        currentPage = 1;
        offset = 0;
        monto = parseInt($(this).val());
        getConvenios(true);
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
        if ($column == 'sort-no-convenio') orderBy = 't_value';
        else if ($column == 'sort-tipo-convenio') orderBy = 'k_value';
        else if ($column == 'sort-institucion') orderBy = 'm_value';
        //else if ($column == 'sort-inversion') orderBy = 'n_value';
        else if ($column == 'sort-inversion') orderBy = 'n.monto';
        else if ($column == 'sort-acciones') orderBy = 'p_value';
        else if ($column == 'sort-programa') orderBy = 'q_value';
        else if ($column == 'sort-vigencia') orderBy = 'g_value';

        getConvenios(true);
    });

    /**
     * Al hacer click en los elementos de paginación
     */
    $(document).on('click', '.page-link', function(){
        currentPage = parseInt($(this).val());
        offset = limit * (currentPage - 1);
        $('.cuerpo-tabla').empty();
        getConvenios(false);

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
     * Obtiene los convenios cuando se pide paginación
     */
   function getConvenios(todos) {
        $('.fa-spinner').show();
       var params = {
           search: search,
           tipoContrato: tipoContrato,
           anio: anio,
           monto: monto,
           orderBy: orderBy,
           orderWay: orderWay,
           limit: limit,
           offset: offset,
           t: token
       };

       $.get("../api/index.php?action=getDocs&documentType=Convenios", params, function(data) {
           $('.fa-spinner').hide();
           var res = JSON.parse(data);

           totalDocs = parseInt(res.pagination.total_rows);
           if (totalDocs === 0) $('.text-resultados').show();
           else $('.text-resultados').hide();

           setConvenios(res.data, todos);
           setPagination(res.pagination);
           $('select[name=selectDocsPagina] > option:first-child')
               .text('Todos ('+totalDocs+')');
       }).fail(function() {$('.fa-spinner').hide();});
       if (todos) offset += 100; // Si se piden todos los documentos, incrementar poco a poco
    }

    /**
     * Obtiene los diferentes tipos de convenios
     */
    function getTiposConvenio() {
       var params = {documentType: 'Convenios', t: token};
       $.get("../api/index.php?action=getTiposDoc", params, function(data) {
           var res = JSON.parse(data);
           setTiposConvenio(res.data);
       }).fail(function() {});
    }

    /**
     * Obtiene todos los convenios sin paginación
     */
    /*function getAllConvenios() {
        $('.cuerpo-tabla').empty();
        limit = 100;
        offset = 0;

        getConvenios(true);
        interval = setInterval(function () { // Obtiene poco a poco la lista de convenios
            getConvenios(true);
            if (parseInt(totalDocs) <= parseInt(offset)) clearInterval(interval);
        }, 1000);
    }*/

   /**
     * Colocar la lista de convenios en la tabla
     */
   function setConvenios(convenios, todos) {
       if(!todos) $('.cuerpo-tabla').empty();
        convenios.forEach(function (c, i) {
            var $col = '<tr>' +
                '       <th scope="row" class="text-center">' +			 
                '           <a href="http://localhost:8002/seeddms/data/1048576/'+c.id+'/'+c.version+c.formato+'" target="_blank">' +
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
     * Coloca los tipos de convenios que existen
     * @param tipos
     */
   function setTiposConvenio(tipos) {
       //$('#selectTipoConvenio').empty();
        tipos.forEach(function (t) {
            var $option = '<option value="'+t+'">'+t+'</option>';
            $($option).appendTo('#selectTipoConvenio');
        });
   }

   /**
     * Coloca la paginación
     */
   function setPagination(pagination) {
       if (parseInt($('#selectDocsPagina').val()) == 0  || pagination.total_rows == "0") // Si se pidieron todos los documentos, no paginar
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
           action: 'getDocs',
           documentType: 'Convenios',
           monto: monto,
           tipoContrato: tipoContrato,
           anio: anio,
           orderBy: orderBy,
           orderWay: orderWay,
           limit: limit,
           offset: offset
       };
       window.open('../export/convenios.php?'+$.param(params));
   });

    $("#btn-filtros").click(function(e) {
        $('.barra-filtros').slideToggle();
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