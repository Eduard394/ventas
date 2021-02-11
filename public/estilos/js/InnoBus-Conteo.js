$(document).on('ready', function () {

    //flechas personalizadas slick
    var prevArrow = "<div class='arrow-left'></div>";
    var nextArrow = "<div class='arrow-right'></div>";






    //acordeones navbar

    $('[data-ed-accodion]').click(function () {

        var edAccordion = $(this).attr('data-ed-accodion');

        if ($('#ed-accodion-' + edAccordion).hasClass('ed-accodion-activo')) {
            $('.barraLateral__acordeonContenedor').removeClass('ed-accodion-activo');
            $('#ed-accodion-' + edAccordion).removeClass('ed-accodion-activo');
            $('.js-barraLateral').removeClass('barraLateral--activa');
            $('.js-barraLateral').addClass('barraLateral--inactiva');
            $('.js-contenido').removeClass('contenido--barraLateral');
            $('.js-navBar').removeClass('navBar--activo');
        } else {
            $('.barraLateral__acordeonContenedor').removeClass('ed-accodion-activo');
            $('#ed-accodion-' + edAccordion).addClass('ed-accodion-activo');
            $('.js-barraLateral').removeClass('barraLateral--inactiva');
            $('.js-barraLateral').addClass('barraLateral--activa');
            $('.js-contenido').addClass('contenido--barraLateral');
            $('.js-navBar').addClass('navBar--activo');
        }
        if ($(this).hasClass('menuFunciones__btn--activo')) {
            $(this).removeClass('menuFunciones__btn--activo');
        } else {
            $('.menuFunciones__btn').removeClass('menuFunciones__btn--activo');
            $(this).addClass('menuFunciones__btn--activo');
        }
    });



    //thumbelina

    $('.js-carousel').each(function (index) {
        $(this).Thumbelina({
            $bwdBut: $(this).find('.left'), // Selector to left button.
            $fwdBut: $(this).find('.right') // Selector to right button.
        });
    });













    //acordeones

    $('.acordeon-trigger').click(function () {

        var dacordeon = $(this).attr('data-acordeon');


        if ($('#rutaAcordeon-' + dacordeon).hasClass('acordeon-activo')) {
            $('.acordeon-contenido').removeClass('acordeon-activo');
            $('.acordeon-trigger').removeClass('activo');
        } else {
            $('.acordeon-contenido').removeClass('acordeon-activo');
            $('#rutaAcordeon-' + dacordeon).addClass('acordeon-activo');

            $('.acordeon-trigger').removeClass('activo');
            $(this).addClass('activo');
        }
    });




    //grupo pestañas

    inicializarPestanas($('.contenido__rutaVehiculo'));

    //Inicialización chosen

    $('.chosen').chosen();

    //Inicializacion datepicker

    $('.datepicker').datepicker();

    //Inicializacion timepicker 

    $('.timepicker').wickedpicker();

    //Inicializacion tooltip

    inicializarTippy('.contenido__rutaPunto', $('.contenido__rutaPunto').find('.tooltip-contenedor'), 'mouseenter');

    inicializarTippy('.contenido__monitorPunto', $('.contenido__monitorPunto').find('.tooltip-contenedor'), 'click');

    //Inicializacion toogle Alertas

    inicializarToggleAlertas();

    //Funciones
    function inicializarTippy(elemento, contenido, trigger) {

        var origen = $(elemento);

        if (origen.length > 0) {

            contenido = contenido[0].outerHTML;

            var options = {
                content: contenido,
                arrow: true,
                interactive: true,
                allowHTML: true,
                trigger: trigger,
            }

            var tooltip = tippy(elemento, options);

        }

    }

    function inicializarPestanas(contenedor) {
        var pestanas = contenedor.find('.nav-link');

        pestanas.click(function () {

            contenedor.find('.nav-link,.nav-item').removeClass('active');

            $(this).addClass('active');
            $(this).parent().addClass('active');

            var tabcontent = $(this).attr('data-tab-toggle');

            contenedor.find('.tab-panel').removeClass('active show')

            $('#' + tabcontent).addClass('active show');
        })
    }

    function inicializarToggleAlertas() {
        $('.alerta-show').click(function () {

            if ($(this).hasClass('activo')) {
                $(this).removeClass('activo');
                $(this).removeClass('ed-accodion-activo');
                $('.contenido__monitorAlertas').removeClass('activo');
                $(this).parent().find('.barraLateral__acordeonContenedor').removeClass('activo');
                $(this).find('i').removeClass('ed-icono-activo');
            } else {
                $(this).addClass('activo');
                $(this).addClass('ed-accodion-activo');
                $('.contenido__monitorAlertas').addClass('activo');
                $(this).parent().find('.barraLateral__acordeonContenedor').addClass('activo');
                $(this).find('i').addClass('ed-icono-activo');
            }
        });
    }



    //Función con las responsabilidad de manejar los tabs.

    $('[data-ed-tab]').click(function () {
        var tab = $(this).attr('data-ed-tab');
        $('.ed-tab-contenido').removeClass('ed-tab-contenido-activo');
        $('#ed-t' + tab).addClass('ed-tab-contenido-activo');

        $('[data-ed-tab]').removeClass('ed-tab-activo');
        $('[data-ed-tab="' + tab + '"]').addClass('ed-tab-activo');
    });



    //onready recorre el menu y coloca la clase de flecha a los items que tienen submenu
    $('.megaMenu__menuItem').each(function (index) {
        if ($(this).children().hasClass('megaMenu__submenu')) {
            //adiciona clase de icono de flecha a los items que tienen submenus
            $(this).addClass('megaMenu__conSubmenu');
        }
    });



    var altoVentanaPull__contenido= ($('.js-ventanaPull__contenido').height() + 25);

    $('.js-ventanaPull__btnInterruptor').click(function() {
        
        if ($('.js-ventanaPull').hasClass('ventanaPull--abierta')) {
            $('.js-ventanaPull').css('bottom', '-'+ altoVentanaPull__contenido +'px');
            $('.js-ventanaPull__iconoInterruptor').removeClass('ib-flechaAbajo');
            $('.js-ventanaPull__iconoInterruptor').addClass('ib-flechaArriba');
            $('.js-ventanaPull').removeClass('ventanaPull--abierta');
        } else {
            $('.js-ventanaPull').css('bottom', '0');
            $('.js-ventanaPull__iconoInterruptor').addClass('ib-flechaAbajo');
            $('.js-ventanaPull__iconoInterruptor').removeClass('ib-flechaArriba');
            $('.js-ventanaPull').addClass('ventanaPull--abierta');
        }
    });

});