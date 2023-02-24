<?php

namespace ElementPack\Modules\WcProducts;

use ElementPack\Base\Element_Pack_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Element_Pack_Module_Base {

    public function get_name() {
        return 'wc-products';
    }

    public function get_widgets() {

        $widgets = ['WC_Products'];

        return $widgets;
    }
}
