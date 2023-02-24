<?php

namespace ElementPack\Modules\WcMiniCart;

use ElementPack\Base\Element_Pack_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Element_Pack_Module_Base {

    public function get_name() {
        return 'wc-mini-cart';
    }

    public function get_widgets() {

        $widgets = ['WC_Mini_Cart'];

        return $widgets;
    }
}
