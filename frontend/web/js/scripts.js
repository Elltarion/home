
    $('document').ready(function() {
        if($('#countRanges').length > 0) {
            function chekTypes() {
                if($('#countRanges [name=diapason_add_type] option').length == $('#countRanges [name=diapason_add_type] option.hide').length) {
                    //если все позиции заюзаны
                    $('#countRanges [name=diapason_add_type]').prop('disabled', true);
                    $('#countRanges [name=diapason_add_value]').prop('disabled', true);
                    $('#countRanges #addCountRange').prop('disabled', true);
                } else {
                    $('#countRanges [name=diapason_add_type]').prop('disabled', false);
                    $('#countRanges [name=diapason_add_value]').prop('disabled', false);
                    $('#countRanges #addCountRange').prop('disabled', false);
                }

                $('#countRanges [name=diapason_add_type] option:selected').prop('selected', false);
                $('#countRanges [name=diapason_add_type] option').each(function() {
                   if(!$(this).hasClass('hide')) {
                       $(this).prop('selected', true);
                       return false;
                   }
                });
            }

            function checkValues(el, weight, type) {
                var value = el.val();
                var check = true;
                $('#countRanges .item .value').each(function() {
                    //если есть позиция по рангу меньше, но значение в ней больше
                    if(Number($(this).attr('data-weight')) <= Number(weight) && $(this).attr('data-type') != type && Number($(this).val()) >= Number(value)) {
                        check = false;
                        return false;
                    }

                    //если есть позиция по рангу больше, но значение в ней меньше
                    if(Number($(this).attr('data-weight')) > Number(weight) && $(this).attr('data-type') != type && Number($(this).val()) <= Number(value)) {
                        check = false;
                        return false;
                    }
                });
                return check;
            }

            chekTypes();

            $('#countRanges').on('input propertychange', '.item .value', function() {
                if(!checkValues($(this), $(this).attr('data-weight'), $(this).attr('data-type'))) {
                    $(this).parent().addClass('has-error');
                } else {
                    $(this).parent().removeClass('has-error');
                }
            });

            $('#countRanges').on('click', '.remove', function() {
                var parent = $(this).closest('.item');
                var type = $(this).attr('data-type');
                $('#countRanges [name=diapason_add_type] #crt_option_' + type).removeClass('hide');
                chekTypes();
                parent.remove();
            });

            $('#countRanges').on('click', '#addCountRange', function() {
                $('#countRanges [name=diapason_add_value]').parent().removeClass('has-error');
                var parent = $(this).closest('.buttons');
                var option = $('#countRanges [name=diapason_add_type] option:selected');
                var value = $('#countRanges [name=diapason_add_value]').val();
                var type = option.val();
                var color = option.attr('data-color');
                var text = option.text();
                var weight = option.attr('data-weight');

                if(value <= 0) {
                    $('#countRanges [name=diapason_add_value]').parent().addClass('has-error');
                    return false;
                }

                if(!checkValues($('#countRanges [name=diapason_add_value]'), weight, type)) {
                    $('#countRanges [name=diapason_add_value]').parent().addClass('has-error');
                    return false;
                }

                var html = '<tr class="item"><td><input class="form-control value" data-type="'+type+'" data-weight="'+weight+'" type="text" value="'+value+'" name="count_ranges['+type+'][pcr_value]"></td>';
                html += '<td class="va-center"> <input type="hidden" value="'+type+'" name="count_ranges['+type+'][pcr_type]"> <span style="color: '+color+';">'+text+'</span></td>';
                html += '<td><div class="remove btn btn-danger fa fa-plus" title="Удалить" data-type="'+type+'"><span class="glyphicon glyphicon-remove"></span></div></td></tr>';
                option.addClass('hide');
                parent.before(html);
                chekTypes();
            })
        }

        if($('.counter').length > 0) {
            function changeCountProduct(productID, count) {
                $.ajax({
                    url: '/economy/products/change-count-product',
                    type: 'POST',
                    data: {id: productID, count: count},
                    success: function (data) {
                        console.log(data);
                    }
                });
            }

            $('body').on('click', '.counter .btn', function() {
                /** @var int changeCount - на сколько меняем */
                var changeCount = 1;
                changeCount = $(this).hasClass('plus') ? changeCount : (changeCount * -1);
                var parent = $(this).closest('.counter');
                var valueSelector = parent.find('.count .value');
                var unitSelector = parent.find('.count .unit');
                var containerSelector = parent.find('.count');
                var nullValue = valueSelector.attr('data-null');
                var ranges = $.parseJSON(valueSelector.attr('data-ranges'));
                var defaultColor = valueSelector.attr('data-defaultcolor');
                var defaultColorNull = valueSelector.attr('data-defaultcolornull');
                var productId = valueSelector.attr('data-product');
                var finalCountValue = 0;

                var currentVal = valueSelector.text();
                if(currentVal == nullValue) {
                    currentVal = 0;
                }

                currentVal = Number(currentVal) + Number(changeCount);
                finalCountValue = currentVal;
                if(currentVal <= 0) {
                    currentVal = nullValue;
                    unitSelector.addClass('hide');
                    if(ranges.length > 0 && ranges[0]['count'] == 0) {
                        containerSelector.css('color', ranges[0]['color']);
                    } else {
                        containerSelector.css('color', defaultColorNull);
                    }
                } else {
                    unitSelector.removeClass('hide');
                    if(ranges.length > 0) {
                        var color = '';
                        var checkStart = false;

                        if(ranges.length == 1 && ranges[0]['type'] == 1) {
                            color = defaultColor;
                        } else {
                            $.each(ranges, function(idx, range) {
                                if(!checkStart && range.type != 1) {
                                    color = range.color;
                                    checkStart = true;
                                }

                                if(range.count <= currentVal) {
                                    color = range.color;
                                }
                            });
                        }
                        containerSelector.css('color', color);
                    } else {
                        containerSelector.css('color', defaultColor);
                    }
                }

                valueSelector.text(currentVal);
                //сохраняем значение
                changeCountProduct(productId, finalCountValue);
            });
        }
    });
   // parent.find('select[name=diapason_add_type] #crt_option_' + type).show();