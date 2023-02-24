;
(function ($, elementor) {
    'use strict';

    $(window).on('elementor/frontend/init', function () {
        var ModuleHandler = elementorModules.frontend.handlers.Base,
            Notation;

        Notation = ModuleHandler.extend({

            bindEvents: function () {
                this.run();
            },

            getDefaultSettings: function () {
                return {
                    type: 'underline',
                    multiline: true
                };
            },

            onElementChange: debounce(function (prop) {
                if (prop.indexOf('ep_notation_') !== -1) {
                    this.run();
                }
            }, 400),

            settings: function (key) {
                return this.getElementSettings('ep_notation_' + key);
            },

            run: function () {

                if (this.settings('active') != 'yes') {
                    return;
                }

                var options = this.getDefaultSettings(),
                    $element = this.$element,
                    $widgetId = 'ep-' + this.getID(),
                    $elementID = this.getID(),
                    $globalthis = this;

                var $list = this.settings('list');

                var rtl = ($("body").hasClass("rtl")) ? true : false;

                elementorFrontend.waypoint($element, function () {

                    $list.forEach(element => {
                        var $selectElement = '',
                            bracketOn = '';

                        if (element.ep_notation_select_type == 'widget') {
                            $($globalthis.findElement('.elementor-widget-container > ').get(0)).attr('data-notation', $widgetId);
                            $selectElement = '[data-notation="' + $widgetId + '"]';
                        }
                        if (element.ep_notation_select_type == 'custom') {
                            var customSelector = element.ep_notation_custom_selector;

                            if (element.ep_notation_custom_selector && customSelector.length > 1) {
                                $selectElement = '[data-id="' + $elementID + '"] ' + ' ' + customSelector;
                            } else {
                                $selectElement = '.-bdt-empty';
                            }

                        }

                        if (element.ep_notation_type == 'bracket') {
                            bracketOn = element.ep_notation_bracket_on;
                            bracketOn = bracketOn.split(',');
                            options.brackets = bracketOn;
                        }

                        if ($selectElement.length > 0) {

                            var n1 = document.querySelector($selectElement);

                            options.type = element.ep_notation_type;
                            options.color = element.ep_notation_color || '#f23427';
                            options.animationDuration = element.ep_notation_anim_duration.size || 800;
                            options.strokeWidth = element.ep_notation_stroke_width.size || 1;
                            options.rtl = rtl;

                            if ($($selectElement).length > 0) {
                                var a1 = _(n1, options);
                                a1.show();
                            }

                        }

                    });

                }, {
                    offset: 'bottom-in-view',
                    // offset: '90%'
                });

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope) {
            elementorFrontend.elementsHandler.addHandler(Notation, {
                $element: $scope
            });
        });

    });

}(jQuery, window.elementorFrontend));