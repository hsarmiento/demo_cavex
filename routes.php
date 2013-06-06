<?php

defined("ROOT")  
    or define("ROOT", dirname(__FILE__).'/');

defined("MODELS")  
    or define("MODELS", ROOT.'models/');

defined("VIEWS")  
    or define("VIEWS", ROOT.'views/');

defined("CONTROLLERS")  
    or define("CONTROLLERS", ROOT.'controllers/');

defined("CONFIG")  
    or define("CONFIG", ROOT.'config/');

defined("RESOURCES")  
    or define("RESOURCES", 'assets/');

$aRoutes = array(
    'urls' => array(  
        'root' => ROOT,        
    ),  
    'paths' => array(
        'models' => array(
            'usuario' => MODELS.'st_usuario.php',
            'medico' => MODELS.'st_medico.php',
            'dependiente' => MODELS.'st_dependiente.php',
            'consulta' => MODELS.'st_consulta.php',
            'region' => MODELS.'st_region.php',
            'comuna' => MODELS.'st_comuna.php',
            'cardex' => MODELS.'st_cardex.php',
            'ciudad' => MODELS.'st_ciudad.php',
            'producto' => MODELS.'st_producto.php',
            'material_promocional' => MODELS.'st_material_promocional.php',
            'parrilla' => MODELS.'st_parrilla.php',
            'visita' => MODELS.'st_visita.php',
            'entrega_producto' => MODELS.'st_entrega_producto.php',
            'stock' => MODELS.'st_stock.php',
            'consulta_bk' => MODELS.'st_consulta_bk.php',
            'dependiente_bk' => MODELS.'st_dependiente_bk.php'
        ),
        'controllers' => array(
            'usuario' => CONTROLLERS.'st_usuario_controller.php',
            'medico' => CONTROLLERS.'st_medico_controller.php',
            'dependiente' => CONTROLLERS.'st_dependiente_controller.php',
            'consulta' => CONTROLLERS.'st_consulta_controller.php',
            'cardex' => CONTROLLERS.'st_cardex_controller.php',
            'producto' => CONTROLLERS.'st_producto_controller.php',
            'material_promocional' => CONTROLLERS.'st_material_promocional_controller.php',
            'parrilla' => CONTROLLERS.'st_parrilla_controller.php',
            'visita' => CONTROLLERS.'st_visita_controller.php',
            'entrega_producto' => CONTROLLERS.'st_entrega_producto_controller.php',
            'stock' => CONTROLLERS.'st_stock_controller.php',
            'consulta_bk' => CONTROLLERS.'st_consulta_bk_controller.php',
            'dependiente_bk' => CONTROLLERS.'st_dependiente_bk_controller.php'
        ),
        'layout' => array(
            'header' => VIEWS.'layout/header.php',
            'footer' => VIEWS.'layout/footer.php'
        ),
        'config' => CONFIG,
        'images' => array(
            'base' => RESOURCES . 'images/',            
        ),
        'js' => RESOURCES . 'js/',
        'css' => RESOURCES . 'css/',
    ),    
    'return' => array(        
        '1' => '/../',
        '2' => '/../../',
    )    
);

?>