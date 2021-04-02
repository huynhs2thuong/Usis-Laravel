/*================================================================================
    Item Name: Materialize - Material Design Admin Template
    Version: 3.1
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */
/*----------  main  ----------*/

function resizeInput() {
    $(this).attr('size', $(this).val().length + 2);
}

function to_slug(str) {
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();

    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');

    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, '');

    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, '-');

    // xóa phần dự - ở đầu
    str = str.replace(/^-+/g, '');

    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, '');

    // return
    return str;
}

function getLocaleText(text, locale) {
    var regex = new RegExp('\\[:' + locale +'\\]([^\\[]+)\\[:', 'i'),
        result = '';
    text.replace(regex, function(match, $1) {
        result = $1;
    });
    return result;
}

$.extend( true, $.fn.dataTable.defaults, {
    pageLength: 25,
    order: [],
    columnDefs: [
        { orderable: false, className: 'select-checkbox', targets: 0 },
        { orderable: false, targets: 'no-sort' }
    ],
    select: {
        style: 'multi',
        selector: 'td:first-child'
    },
    stateSave: true,
    dom: 'lfiprtp',
    language: {
        url: '/js/plugins/data-tables/Vietnamese.json',
        processing: '<div class="preloader-wrapper active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
    }
});

if (current_locale === 'vi') {
    $.extend( $.fn.pickadate.defaults, {
        monthsFull: [ 'Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu', 'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai' ],
        monthsShort: [ 'Một', 'Hai', 'Ba', 'Tư', 'Năm', 'Sáu', 'Bảy', 'Tám', 'Chín', 'Mưới', 'Mười Một', 'Mười Hai' ],
        weekdaysFull: [ 'Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy' ],
        weekdaysShort: [ 'C.Nhật', 'T.Hai', 'T.Ba', 'T.Tư', 'T.Năm', 'T.Sáu', 'T.Bảy' ],
        today: 'Hôm Nay',
        clear: 'Xoá',
        firstDay: 1
    });

    $.extend( $.validator.messages, {
        required: "Không được để trống.",
        remote: "Hãy sửa cho đúng.",
        email: "Email không đúng định dạng.",
        url: "Hãy nhập URL.",
        date: "Hãy nhập ngày.",
        dateISO: "Hãy nhập ngày (ISO).",
        number: "Hãy nhập số.",
        digits: "Hãy nhập chữ số.",
        creditcard: "Hãy nhập số thẻ tín dụng.",
        equalTo: "Hãy nhập thêm lần nữa.",
        extension: "Phần mở rộng không đúng.",
        maxlength: $.validator.format( "Hãy chọn từ {0} mục trở xuống." ),
        minlength: $.validator.format( "Hãy nhập từ {0} kí tự trở lên." ),
        rangelength: $.validator.format( "Hãy nhập từ {0} đến {1} kí tự." ),
        range: $.validator.format( "Hãy nhập từ {0} đến {1}." ),
        max: $.validator.format( "Hãy nhập từ {0} trở xuống." ),
        min: $.validator.format( "Hãy nhập từ {0} trở lên." )
    } );
}

slug_pattern = /^[\w\-]+[a-zA-Z\d]$/;
$gallery = $('.gallery');
$banner = $('.banner');

//Dropzone.autoDiscover = false;

$(document).ready(function() {
    $('input[type="text"]').keyup(resizeInput).each(resizeInput);

    $('.num').keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
            // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $('input[name="title[' + current_locale + ']"').change(function(event) {
        if ($('input[name="slug[' + current_locale + ']"').val() === '') $('input[name="slug[' + current_locale + ']"').val(to_slug($(this).val()));
    });
    $('input[name="title[en]"').change(function(event) {
        if ($('input[name="slug[en]"').val() === '') $('input[name="slug[en]"').val(to_slug($(this).val()));
    });

    $(document).on('click', '.lang-switch > li > a', function(e) {
        var $target = $(e.target);
        $('.lang-switch > li > a[data-tab-lang=' + $target.data('tab-lang') + ']').tab('show');
    });

    $gallery.on('click', '.item > .resource-delete', function(event) {
        event.preventDefault();
        $(this).parent('.item').detach();
    });
    $banner.on('click', '.item > .resource-delete_banner', function(event) {
        event.preventDefault();
        $(this).parent('.item').detach();
    });

    /*----------  end main  ----------*/

    /*----------  customer-detail  ----------*/

    init();
    increaseBinding();
    decreaseBinding();
    addFood();
    addCombo();
    removeFood();
    addExtra();
    removeExtra();
    addCategory();
    chooseCombo1();
    chooseCombo2();
    modalClose();

    function increaseBinding() {
        $('.order-info').on('click', '.plus', function() {
            var input = $(this).next('input');
            var update = parseFloat(removeComma($('.price-lg').text()));
            var totalPrice = $(this).parent('td').next('td');
            var singlePrice = $(this).parent('td').prev('td');
            input.val(parseInt(input.val()) + 1);
            totalPrice.text(addComma(
                parseFloat(removeComma(totalPrice.text())) + parseFloat(removeComma(singlePrice.text()))
            ));
            update = update + parseFloat(removeComma(singlePrice.text()));
            $('.price-lg').text(addComma(update) + ' VNĐ');
        });
    }

    function decreaseBinding() {
        $('.order-info').on('click', '.minus', function() {
            var input = $(this).prev('input');
            var update = parseFloat(removeComma($('.price-lg').text()));
            var totalPrice = $(this).parent('td').next('td');
            var singlePrice = $(this).parent('td').prev('td');
            if (parseInt(input.val()) > 0) {
                input.val(parseInt(input.val()) - 1);
                totalPrice.text(addComma(
                    parseFloat(removeComma(totalPrice.text())) - parseFloat(removeComma(singlePrice.text()))
                ));
                update = update - parseFloat(removeComma(singlePrice.text()));
            }
            $('.price-lg').text(addComma(update) + ' VNĐ');
        });
    }

    function init() {
        var total = 0;
        $('.order-info tbody tr').each(function() {
            var singlePrice = parseFloat(removeComma(
                $(this).children('td:nth-child(3)').text()
            ));
            var quantity = parseInt($(this).find('.quantity').children('input').val());
            $(this).children('td:last-child').text(addComma(singlePrice * quantity));
            total = total + parseInt(removeComma($(this).children('td:last-child').text()));
            $('.price-lg').text(addComma(total) + ' VNĐ');
        });
    }

    function addFood() {
        $('.add').each(function() {
            $(this).on('click', function() {
                var update = parseFloat(removeComma($('.price-lg').text()));
                var name = $(this).parent('.food-item').prev().text();
                var singlePrice = parseFloat(removeComma($(this).next().text()));
                var num = parseInt($('.order-info tbody tr:last-child td:first-child').text()) + 1;
                $('.order-info tbody').append($('<tr></tr>'));
                var orderNum = $('<td></td>').text(num);
                var orderName = $('<td></td>').html(
                    '<span>' + name + '</span>' + '\n' + '<button type="button" class="right remove"><i class="mdi-content-clear"></i></button>'
                );
                var orderPrice = $('<td></td>').text(addComma(singlePrice));
                var orderTotalPrice = $('<td></td>').text(addComma(singlePrice));
                var orderQty = '<td class="quantity">' + '\n' + '<button type="button" class="plus"><i class="mdi-content-add"></i></button>' + '\n' + '<input type="text" class="num" value="1">' + '\n' + '<button type="button" class="minus"><i class="mdi-content-remove"></i></button>' + '\n' + '</td>';
                $('.order-info tbody tr:last-child').append(orderNum, orderName, orderPrice, orderQty, orderTotalPrice);
                update = update + singlePrice;
                $('.price-lg').text(addComma(update) + ' VNĐ');
                //  go to bottom
                $('body,html').animate({ scrollTop: $(window).scrollTop() + $(window).height() });
            });
        });
    }

    function removeFood() {
        $('.order-info').on('click', '.remove', function() {
            $('#delete').on('click', '.btn-ok', function() {
                $(this).data('clicked', true);
            });
            if ($('.btn-ok').data('clicked')) {
                var totalPrice = parseFloat(removeComma($(this).parents('tr').children('td:last-child').text()));
                var update = parseFloat(removeComma($('.price-lg').text()));
                update = update - totalPrice;
                $(this).parents('tr').nextAll('tr').each(function() {
                    var num = parseInt($(this).children('td:first-child').text()) - 1;
                    $(this).children('td:first-child').text(num);
                });
                $(this).parents('tr').remove();
                $('.price-lg').text(addComma(update) + ' VNĐ');
                $('.btn-ok').data('clicked', false);
            }
        });
    }

    function addCombo() {
        var num, name, singlePrice, comboArr = [],
            signArr = [];
        $('.modal-trigger').on('click', function() {
            num = parseInt($('.order-info tbody tr:last-child td:first-child').text()) + 1;
            name = $(this).children('div').text();
            singlePrice = parseFloat(removeComma(
                $(this).children('span').text()
            ));
            chooseCombo1();
            chooseCombo2();
        });

        $('.modal-form .btn-add').on('click', function() {
            var update = parseFloat(removeComma($('.price-lg').text()));
            comboArr[0] = $(this).parent('div').prevAll('.combo1').find('.selected').children('span').text();
            comboArr[1] = $(this).parent('div').prevAll('.combo2').find('.selected').children('span').text();
            comboArr[2] = $(this).parent('div').prevAll('.combo3').find('.selected').children('span').text();
            for (var i = 0; i < comboArr.length; i++) {
                switch (comboArr[i]) {
                    case '':
                        signArr[i] = '';
                        break;
                    default:
                        signArr[i] = ' + ';
                }
            }

            $('.order-info tbody').append($('<tr></tr>'));
            var orderNum = $('<td></td>').text(num);
            var orderName = $('<td></td>').html(
                '<span>' + name + signArr[0] + comboArr[0] + signArr[1] + comboArr[1] + signArr[2] + comboArr[2] + '</span>' + '<button type="button" class="right remove"><i class="mdi-content-clear"></i></button>'
            );
            var orderPrice = $('<td></td>').text(addComma(singlePrice));
            var orderTotalPrice = $('<td></td>').text(addComma(singlePrice));
            var orderQty = '<td class="quantity">' + '\n' + '<button type="button" class="plus"><i class="mdi-content-add"></i></button>' + '\n' + '<input type="text" class="num" value="1">' + '\n' + '<button type="button" class="minus"><i class="mdi-content-remove"></i></button>' + '\n' + '</td>';
            $('.order-info tbody tr:last-child').append(orderNum, orderName, orderPrice, orderQty, orderTotalPrice);
            update = update + singlePrice;
            $('.price-lg').text(addComma(update) + ' VNĐ');

            // go to bottom
            $('body,html').animate({ scrollTop: $(window).scrollTop() + $(window).height() });
        });
    }

    function modalClose() {
        $('.modal-close').on('click', function() {
            $('.modal-form select').prop('selectedIndex', 0);
            $('.modal-form select').material_select();
        });
    }

    function addComma(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }

    function removeComma(val) {
        return val.replace(/,/g, '');
    }

    function addExtra() {
        $('.add-extra').keypress(function(e) {
            if (e.which == 13) {
                var name = $(this).val();
                var prent = $(this).parent('.input-field').prev('div');
                var txt1 = $('<input>').attr('type', 'checkbox').attr('id', name);
                var txt2 = $('<label></label>').text(name).attr('for', name);
                prent.after('<div class="ui-state-default check-item"><p></p></div>');
                prent.next('div').children('p').append(txt1, txt2).append('<button class="right remove-extra"><i class="mdi-content-clear"></i></button>');
                $(this).val('');
                $('.non-visibl').css('visibility', 'hidden');
            }
        });
    }

    function removeExtra() {
        $('#sortable').on('click', '.remove-extra', function() {
            $(this).parents('.ui-state-default').remove();
        });
    }

    function addCategory() {
        $('.add-cate').keypress(function(e) {
            if (e.which == 13) {
                var name = $(this).val();
                var prent = $(this).parent('.input-field').prevAll('#all');
                var txt1 = $('<input>').attr('type', 'checkbox').attr('id', name);
                var txt2 = $('<label></label>').text(name).attr('for', name);
                prent.append('<p></p>');
                prent.children('p:last-child').append(txt1, txt2).append('<button class="right remove-cate"><i class="mdi-content-clear"></i></button>');
                $(this).val('');
                $('.non-visib').css('visibility', 'hidden');
            }
        });
    }

    function removeCategory() {
        $('.cat-middle').on('click', '.remove-cate', function() {
            $(this).parent('p').remove();
        });
    }

    function chooseCombo1() {
        $('.combo1 li').on('click', function() {
            $('.combo2 select').prop('selectedIndex', 0);
            $('.combo2 select').material_select();
            // $('.combo1').find('#big-size').prop('disabled', false);
            chooseCombo2();
        });
    }

    function chooseCombo2() {
        $('.combo2 li').on('click', function() {
            $('.combo1 select').prop('selectedIndex', 0);
            $('.combo1 select').material_select();
            // $('.combo1').find('#big-size').prop('checked', false);
            // $('.combo1').find('#big-size').prop('disabled', true);
            chooseCombo1();
        });
    }

});

/*----------  end customer-detail  ----------*/
