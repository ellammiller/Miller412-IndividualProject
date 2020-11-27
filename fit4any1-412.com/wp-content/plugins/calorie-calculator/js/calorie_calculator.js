"use strict";

var calorie_calculator = {
    BMR : 0,
    activity_factor: 0,
    persondata: {}
}


var personDataUSUnit, personDataMetricUnit;

var is_calcal_debug_mode = calcalpro_settings.debug_mode;

function cal_dump(var_name, text = '') {

    if(is_calcal_debug_mode) {

        if(text) {
            console.log(text, var_name);
        } else {
            console.log(var_name);
        }

    }

}

  
if(!jQuery) {
        throw new Error("jQuery isn't enabled. Calorie calculator needs jQuery to function!");
}

jQuery( function($) {


    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }


    function is_calcal_admin_page() {

        var page = getParameterByName('page');

        //console.log(page);

        if(page == 'calorie-calculator/calorie-calculator.php') {

            return true;

        }

        return false;

    }

    function create_calcalpro_options(options, initial_text, $this) {

        var result = '';

        jQuery.ajax({
            type: 'POST',
            url: ajax_send_or_download_details.ajaxurl,
            data: {
                'action': 'save_calcalpro_options',
                'options': options
            },
            success: function(data) {

                $this.text(initial_text);

                result = data

                console.log(result);

                if(data == 'success') {

                    alert('Options saved successfully');

                }

            },

            error: function(data) {

                $this.text(initial_text);

            }

        });




    }

    //generate another captcha
    function generate_captcha(captcha_img_selector) {

        var $this = captcha_img_selector;

        //console.log($this);

        jQuery.ajax({

            type: 'POST',
            url: ajax_send_or_download_details.ajaxurl,
            data: {
                action: 'generate_captcha'
            },
            success: function(data, textStatus, XMLHttpRequest) {

                //console.log(data);
                $this.attr('src', data);
            },
            error: function(MLHttpRequest, textStatus, errorThrown) {
                //alert(errorThrown);
                console.log(errorThrown);

            }
        });

    }




    $(document).ready(function(e) {



        /** Custom Select JS starts */

        $(".calorie_calculator_general .calcalpro-custom-select").each(function() {
            var classes = $(this).attr("class"),
                id      = $(this).attr("id"),
                name    = $(this).attr("name");
            var template =  '<div class="' + classes + '">';
            template += '<span class="calcalpro-custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
            template += '<div class="calcalpro-custom-options">';
            $(this).find("option").each(function() {
                template += '<span class="calcalpro-custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
            });
            template += '</div></div>';

            $(this).wrap('<div class="calcalpro-custom-select-wrapper"></div>');
            $(this).hide();
            $(this).after(template);
        });
        $(".calcalpro-custom-option:first-of-type").hover(function() {
            $(this).parents(".calcalpro-custom-options").addClass("option-hover");
        }, function() {
            $(this).parents(".calcalpro-custom-options").removeClass("option-hover");
        });
        $(".calcalpro-custom-select-trigger").on("click", function(e) {
            $('html').one('click',function() {
                $(".calcalpro-custom-select").removeClass("opened");
            });
            $(this).parents(".calcalpro-custom-select").toggleClass("opened");
            e.stopPropagation();
        });
        $(".calcalpro-custom-option").on("click", function() {
            $(this).parents(".calcalpro-custom-select-wrapper").find("select").val($(this).data("value"));
            $(this).parents(".calcalpro-custom-options").find(".calcalpro-custom-option").removeClass("selection");
            $(this).addClass("selection");
            $(this).parents(".calcalpro-custom-select").removeClass("opened");
            $(this).parents(".calcalpro-custom-select").find(".calcalpro-custom-select-trigger").text($(this).text());
        });


        /** Custom Select JS ends */



        $('.clear_form').click(function() {

            var $form = $(this).closest('form');

            $form.find("input[type=text], input[type=email], input[type=number], textarea").val("");

            $form.find("select").find('option:eq(0)').prop('selected', true);

            $form.find(".calcalpro-custom-options span").removeClass('selection');

            $('.calcalpro-custom-select-trigger').text($form.find("select").attr('placeholder'));

            $(document).trigger('calcalpro_form_cleared', $form);

        });

        $(document).on('calcalpro_form_cleared', function(e, form) {

            console.log(form);

            $(form).closest('.calorie_calculator_general').find('.calorie_calculator_result').css({'display': 'none'});


        });



        $('.calorie_calculator_general ul.tab_header_container li').on('click', function(e) {

            var $container_id = '';

            e.preventDefault();

            var $this = $(this);


            var $tab_container = $($this.find('a').first().attr('href'));


            if( !$this.hasClass('calcal_tab_active')) {

                $this.siblings().removeClass('calcal_tab_active');
                $this.addClass('calcal_tab_active');

                $tab_container.siblings().removeClass('calcal_tab_open');
                $tab_container.addClass('calcal_tab_open');

                var switch_left_to_right = $this.parent('.tab_header_container').find('.switch-left-to-right').first();

                if($this.hasClass('left_tab')) {

                    switch_left_to_right.removeClass('right');

                    //$this.addClass('calcal_tab_active');

                } else {

                    switch_left_to_right.addClass('right');

                }

            }


            //var $container_selector = $this.attr('href');

            //var $closest_li = $this.closest('li');

            //$closest_li.addClass("calcal_tab_active");
            //$closest_li.closest('li').siblings(".calcal_tab_triggerer").removeClass("calcal_tab_active");


            //$($container_selector).addClass('calcal_tab_open');
            //$($container_selector).siblings('.calcal_tab').removeClass('calcal_tab_open');

        });



        if(jQuery.isFunction(jQuery().tabs)) {

            jQuery( ".calorie_calculator_tabs" ).tabs({
                collapsible: true
            });

        }

        if(jQuery.isFunction(jQuery().DataTable)) {

            var food_calorie_table = jQuery('.calorie_calculator_food_chart_table').DataTable({
                //ref:https://datatables.net/reference/option/
                "lengthMenu": [7, 10, 20, 40, 60, 80],
                "pageLength": 7,
                "language": {
                    "lengthMenu": translation_array.show + " _MENU_",
                    //"info": "_START_ to _END_ of _TOTAL_",
                    "info": "",
                    "infoEmpty": translation_array.no_foods_to_show,
                    "infoFiltered": "",
                    "zeroRecords": translation_array.no_foods_to_show,
                    "search": "",
                    "searchPlaceholder": translation_array.search_food,
                    "paginate" : {
                        "next": ">>",
                        "previous": "<<"
                    }

                }

            });

            var calorie_burning_table = jQuery('.calorie_calculator_burning_rate_table').DataTable({
                //ref:https://datatables.net/reference/option/
                "lengthMenu": [7, 10, 20],
                "pageLength": 7,
                "language": {
                    "lengthMenu": translation_array.show + " _MENU_",
                    //"info": "_START_ to _END_ of _TOTAL_",
                    "info": "",
                    "infoEmpty": translation_array.no_exercises_to_show,
                    "infoFiltered": "",
                    "zeroRecords": translation_array.no_exercises_to_show,
                    "search": "",
                    "searchPlaceholder": translation_array.search_exercise,
                    "paginate" : {
                        "next": ">>",
                        "previous": "<<"
                    }

                }

            });

        }

        //bootstrap tooltip
        if(jQuery.isFunction(jQuery().tooltip)) {

            jQuery('[data-toggle="tooltip"]').tooltip();

        }

        if( jQuery('.calorie_calculator_bootstrap') && jQuery.isFunction(jQuery().tooltip) == false ) {

            jQuery('.calorie_calculator_bootstrap').html('<span style="color: #a94442">It seems your theme doesn\'t support Twitter Bootstrap. Please disable Bootstrap styling and use default styling instead in Calorie Calculator widget setting.</span>');

        }


        jQuery('.send_to_email_toggle_button').click(function() {

            var $this = jQuery(this);

            $this.hide();
            $this.parent().parent().find('.send_to_email_input, .send_to_email_submit').removeClass('hide');
        });

        //send as email
        jQuery('.send_to_email_form').submit(function(e) {

            e.preventDefault();

            var $this = jQuery(this);

            $this.find('.send_to_email_submit').attr('value', translation_array.sending_email);

            var formdata = $this.serializeArray().reduce(function(obj, item) {

                obj[item.name] = item.value;
                return obj;

            }, {});


            //console.log(formdata);

            jQuery.ajax({
                type: 'POST',
                url: ajax_send_or_download_details.ajaxurl,
                data: {
                    action: 'send_as_email',
                    formdata: formdata,
                    calculator_result: $this.parent().prev('.calorie_calculator_result').html()
                },
                success: function(data, textStatus, XMLHttpRequest) {
                    var loademailresult = $this.next('.email_sent_status');
                    loademailresult.html('');
                    loademailresult.append(data);
                    loademailresult.css({'display': 'block'});
                    $this.find('.send_to_email_submit').attr('value', translation_array.send_me_an_email);
                    //console.log(data);
                },
                error: function(MLHttpRequest, textStatus, errorThrown) {
                    //alert(errorThrown);
                    var loademailresult = $this.next('.email_sent_status');
                    loademailresult.html('');
                    loademailresult.append(translation_array.sorry_email_cannot_be_sent);
                    loademailresult.css({'display': 'block'});
                    $this.find('.send_to_email_submit').attr('value', translation_array.send_me_an_email);
                }
            });


        });

        jQuery('.download_as_pdf_submit_initializer_button').click(function(e) {
            var $this = jQuery(this);
            $this.hide().parent().next('form').removeClass('hide');
            var captcha_img_selector = $this.parent().next('.download_as_pdf').find('.calorie_calculator_captcha_img');
            generate_captcha(captcha_img_selector);
        });

        //download as pdf
        jQuery('.download_as_pdf').submit(function(e) {

            e.preventDefault();

            var $this = jQuery(this);

            //console.log($this.children('.download_as_pdf_submit'));

            $this.children('.download_as_pdf_submit').attr('value', translation_array.downloading);
            $this.next('.download_as_pdf_status').html(translation_array.processing_download);

            var formdata = $this.serializeArray().reduce(function(obj, item) {

                obj[item.name] = item.value;
                return obj;

            }, {});

            // console.log(formdata);



            jQuery.ajax({
                type: 'POST',
                url: ajax_send_or_download_details.ajaxurl,
                data: {
                    action: 'download_as_pdf',
                    calculator_data: calorie_calculator,
                    persondata: calorie_calculator.persondata,
                    formdata: formdata
                },
                success: function(data, textStatus, XMLHttpRequest) {

                    var loadpdfdownloadstatus = $this.next('.download_as_pdf_status');
                    loadpdfdownloadstatus.html('');
                    loadpdfdownloadstatus.append(data);
                    loadpdfdownloadstatus.css({'display': 'block'});
                    $this.children('.download_as_pdf_submit').attr('value', translation_array.download_as_pdf);
                    $this.find('.calorie_verify_captcha').attr('value', '');
                    var captcha_img_selector = $this.find('.calorie_calculator_captcha_img');
                    generate_captcha(captcha_img_selector);

                    //console.log(data);
                },
                error: function(MLHttpRequest, textStatus, errorThrown) {

                    var loadpdfdownloadstatus = $this.next('.download_as_pdf_status');
                    loadpdfdownloadstatus.html('');
                    //loadpdfdownloadstatus.append(translation_array.something_went_wrong);
                    loadpdfdownloadstatus.append(MLHttpRequest.responseText);
                    $this.children('.download_as_pdf_submit').attr('value', translation_array.download_as_pdf);
                    $this.find('.calorie_verify_captcha').attr('value', '');
                    var captcha_img_selector = $this.find('.calorie_calculator_captcha_img');
                    generate_captcha(captcha_img_selector);
                }
            });


        });


        //generate another captcha
        jQuery( ".generate_another_captcha" ).click(function(e) {

            e.preventDefault();

            var $this = jQuery(this);

            var captcha_img_selector = $this.parent().prev('.calorie_calculator_captcha_img');

            generate_captcha(captcha_img_selector);

        });

        //add new food calorie post
        jQuery("#food_calorie_create_new").click(function(e) {

            var $this = jQuery(this);

            try {

                var food_calorie_data = {
                    food_name: $this.parent().parent().find('#food_calorie_food_name').attr('value'),
                    food_amount: $this.parent().parent().find('#food_calorie_food_amount').attr('value'),
                    food_calorie_amount: $this.parent().parent().find('#food_calorie_calorie_amount').attr('value')
                };

                if( !food_calorie_data.food_name || !food_calorie_data.food_amount || !food_calorie_data.food_calorie_amount ) {

                    throw new Error('Please enter all required fields!');

                }

                //console.log(food_calorie_data);

                jQuery.ajax({

                    type: 'POST',
                    url: ajax_send_or_download_details.ajaxurl,
                    data: {
                        action: 'create_food_calorie_post',
                        food_calorie_data : food_calorie_data
                    },
                    success: function(data, textStatus, XMLHttpRequest) {

                        //let's add the created post to the table instantly.

                        var row_class = $this.parent().parent().next().next().attr('class');

                        var new_food_row  = '<tr role="row" class="'+ row_class +' new_row_transition">';
                        new_food_row +=     '<td>'+ food_calorie_data.food_name +'</td>';
                        new_food_row +=     '<td>' + food_calorie_data.food_amount + '</td>';
                        new_food_row +=     '<td>' + food_calorie_data.food_calorie_amount + '</td>';
                        new_food_row +=     '<td>';
                        new_food_row +=         '<input type="button" value="Edit" id="food_calorie_edit" class="food_calorie_edit button" data-post-id="'+ parseInt(data) +'" />';
                        new_food_row +=         '<input type="button" value="Delete" id="delete_post" class="delete_post button" data-post-id="'+ parseInt(data) +'" />';
                        new_food_row +=     '</td>';
                        new_food_row += '</tr>';

                        $this.parent().parent().after(new_food_row);

                    },
                    error: function(MLHttpRequest, textStatus, errorThrown) {
                        //alert(errorThrown);
                        console.log(errorThrown);

                    }
                });



            } catch(errorMessage) {

                console.log(errorMessage);

            }

        });

        //delete a post by it's id

        jQuery(document).on("click", "#delete_post", function(e) {

            var $this = jQuery(this);

            jQuery.ajax({

                type: 'POST',
                url: ajax_send_or_download_details.ajaxurl,
                data: {
                    action: 'delete_post',
                    post_id: $this.attr('data-post-id')
                },
                success: function(data, textStatus, XMLHttpRequest) {

                    //console.log(data);
                    //$this.attr('src', data);

                    $this.parent().parent().remove();
                },
                error: function(MLHttpRequest, textStatus, errorThrown) {
                    //alert(errorThrown);
                    console.log(errorThrown);

                }
            });

        });

        //Edit a food calorie item

        jQuery(document).on("click", "#food_calorie_edit", function(e) {

            var $this = jQuery(this);

            //console.log($this.parent().prev().prev().prev().text());

            var food_calorie_data = {
                food_name: $this.parent().prev().prev().prev().text(),
                food_amount: $this.parent().prev().prev().text(),
                food_calorie_amount: $this.parent().prev().text(),
                post_id: $this.attr('data-post-id')
            };

            var row_class = $this.parent().parent().attr('class');

            var new_food_row  = '<tr role="row" class="'+ row_class +'">';
            new_food_row +=     '<td><input type="text" name="food_calorie_food_name" id="food_calorie_food_name" class="food_calorie_food_name" placeholder="Food Name" value="'+ food_calorie_data.food_name +'" /></td>';
            new_food_row +=     '<td><input type="text" name="food_calorie_food_amount" id="food_calorie_food_amount" class="food_calorie_food_amount" placeholder="Amount" value="'+ food_calorie_data.food_amount +'" /></td>';
            new_food_row +=     '<td><input type="text" name="food_calorie_calorie_amount" id="food_calorie_calorie_amount" class="food_calorie_calorie_amount" placeholder="Calorie Amount" value="'+ food_calorie_data.food_calorie_amount +'" /></td>';
            new_food_row +=     '<td>';
            new_food_row +=         '<input type="button" value="Update" id="food_calorie_update" class="food_calorie_update button" data-post-id="'+ food_calorie_data.post_id +'" />';
            new_food_row +=         '<input type="button" value="Delete" id="delete_post" class="delete_post button" data-post-id="'+ food_calorie_data.post_id +'" />';
            new_food_row +=     '</td>';
            new_food_row += '</tr>';

            $this.parent().parent().replaceWith(new_food_row);

        });

        //update a food
        jQuery(document).on("click", "#food_calorie_update", function(e) {

            var $this = jQuery(this);


            var food_calorie_data = {
                post_id: parseInt($this.attr('data-post-id')),
                food_name: $this.parent().parent().find('#food_calorie_food_name').attr('value'),
                food_amount: $this.parent().parent().find('#food_calorie_food_amount').attr('value'),
                food_calorie_amount: $this.parent().parent().find('#food_calorie_calorie_amount').attr('value')
            };

            //console.log(food_calorie_data);

            jQuery.ajax({

                type: 'POST',
                url: ajax_send_or_download_details.ajaxurl,
                data: {
                    action: 'update_food_calorie_post',
                    food_calorie_data : food_calorie_data
                },
                success: function(data, textStatus, XMLHttpRequest) {


                    //let's add the created post to the table instantly.

                    var row_class = $this.parent().parent().attr('class');

                    var new_food_row  = '<tr role="row" class="'+ row_class +' new_row_transition">';
                    new_food_row +=     '<td>'+ food_calorie_data.food_name +'</td>';
                    new_food_row +=     '<td>' + food_calorie_data.food_amount + '</td>';
                    new_food_row +=     '<td>' + food_calorie_data.food_calorie_amount + '</td>';
                    new_food_row +=     '<td>';
                    new_food_row +=         '<input type="button" value="Edit" id="food_calorie_edit" class="food_calorie_edit button" data-post-id="'+ food_calorie_data.post_id +'" />';
                    new_food_row +=         '<input type="button" value="Delete" id="delete_post" class="delete_post button" data-post-id="'+ food_calorie_data.post_id +'" />';
                    new_food_row +=     '</td>';
                    new_food_row += '</tr>';

                    $this.parent().parent().replaceWith(new_food_row);

                },
                error: function(MLHttpRequest, textStatus, errorThrown) {
                    //alert(errorThrown);
                    console.log(errorThrown);

                }
            });

        });


        //Edit a calorie burning activity item

        jQuery(document).on("click", "#calorie_bunring_edit", function(e) {

            var $this = jQuery(this);

            var calorie_burning_data = {
                post_id: $this.attr('data-post-id'),
                activity: $this.parent().prev().prev().prev().prev().text(),
                person_125lbs: $this.parent().prev().prev().prev().text(),
                person_155lbs: $this.parent().prev().prev().text(),
                person_185lbs: $this.parent().prev().text()
            };

            var row_class = $this.parent().parent().attr('class');

            var new_calorie_burning_row  = '<tr role="row" class="'+ row_class +'">';
            new_calorie_burning_row +=     '<td><input type="text" name="calorie_burning_activity" id="calorie_burning_activity" class="calorie_burning_activity" placeholder="Activity Name" value="'+ calorie_burning_data.activity +'" /></td>';
            new_calorie_burning_row +=     '<td><input type="text" name="calorie_burning_person_125lbs" id="calorie_burning_person_125lbs" class="calorie_burning_person_125lbs" placeholder="Calorie Burning" value="'+ calorie_burning_data.person_125lbs +'" /></td>';
            new_calorie_burning_row +=     '<td><input type="text" name="calorie_burning_person_155lbs" id="calorie_burning_person_155lbs" class="calorie_burning_person_155lbs" placeholder="Calorie Burning" value="'+ calorie_burning_data.person_155lbs +'" /></td>';
            new_calorie_burning_row +=     '<td><input type="text" name="calorie_burning_person_185lbs" id="calorie_burning_person_185lbs" class="calorie_burning_person_185lbs" placeholder="Calorie Burning" value="'+ calorie_burning_data.person_185lbs +'" /></td>';
            new_calorie_burning_row +=     '<td>';
            new_calorie_burning_row +=         '<input type="button" value="Update" id="calorie_burning_update" class="calorie_burning_update button" data-post-id="'+ calorie_burning_data.post_id +'" />';
            new_calorie_burning_row +=         '<input type="button" value="Delete" id="delete_post" class="delete_post button" data-post-id="'+ calorie_burning_data.post_id +'" />';
            new_calorie_burning_row +=     '</td>';
            new_calorie_burning_row += '</tr>';


            $this.parent().parent().replaceWith(new_calorie_burning_row);

        });

        //Create a new calorie burning exercise/activity
        jQuery("#calorie_burning_create_new").click(function(e) {

            var $this = jQuery(this);

            try {

                var calorie_burning_data = {
                    activity: $this.parent().parent().find('#calorie_burning_activity').attr('value'),
                    person_125lbs: $this.parent().parent().find('#calorie_burning_person_125lbs').attr('value'),
                    person_155lbs: $this.parent().parent().find('#calorie_burning_person_155lbs').attr('value'),
                    person_185lbs: $this.parent().parent().find('#calorie_burning_person_185lbs').attr('value')
                };

                //console.log(calorie_burning_data);


                if( !calorie_burning_data.activity || !calorie_burning_data.person_125lbs || !calorie_burning_data.person_155lbs || !calorie_burning_data.person_185lbs ) {

                    throw new Error('Please enter all required fields!');

                }


                jQuery.ajax({

                    type: 'POST',
                    url: ajax_send_or_download_details.ajaxurl,
                    data: {
                        action: 'create_calorie_burning_post',
                        calorie_burning_data : calorie_burning_data
                    },
                    success: function(data, textStatus, XMLHttpRequest) {

                        //console.log('Post created with id: ', data);

                        //let's add the created post to the table instantly.

                        var row_class = $this.parent().parent().next().next().attr('class');

                        var new_calorie_burning_row  = '<tr role="row" class="'+ row_class +' new_row_transition">';
                        new_calorie_burning_row +=     '<td>'+ calorie_burning_data.activity +'</td>';
                        new_calorie_burning_row +=     '<td>' + calorie_burning_data.person_125lbs + '</td>';
                        new_calorie_burning_row +=     '<td>' + calorie_burning_data.person_155lbs + '</td>';
                        new_calorie_burning_row +=     '<td>' + calorie_burning_data.person_185lbs + '</td>';
                        new_calorie_burning_row +=     '<td>';
                        new_calorie_burning_row +=         '<input type="button" value="Edit" id="calorie_bunring_edit" class="calorie_bunring_edit button" data-post-id="'+ parseInt(data) +'" >';
                        new_calorie_burning_row +=         '<input type="button" value="Delete" id="delete_post" class="delete_post button" data-post-id="'+ parseInt(data) +'" >';
                        new_calorie_burning_row +=     '</td>';
                        new_calorie_burning_row += '</tr>';


                        $this.parent().parent().after(new_calorie_burning_row);

                    },
                    error: function(MLHttpRequest, textStatus, errorThrown) {
                        //alert(errorThrown);
                        console.log(errorThrown);

                    }
                });

            } catch(errorMessage) {
                console.log(errorMessage);
            }

        });

        //update a calorie burning activity/exercise.
        jQuery(document).on("click", "#calorie_burning_update", function(e) {

            var $this = jQuery(this);

            //console.log($this.attr('data-post-id'));

            var calorie_burning_data = {
                post_id: parseInt($this.attr('data-post-id')),
                activity: $this.parent().parent().find('#calorie_burning_activity').attr('value'),
                person_125lbs: $this.parent().parent().find('#calorie_burning_person_125lbs').attr('value'),
                person_155lbs: $this.parent().parent().find('#calorie_burning_person_155lbs').attr('value'),
                person_185lbs: $this.parent().parent().find('#calorie_burning_person_185lbs').attr('value')
            };

            //console.log(calorie_burning_data);

            jQuery.ajax({

                type: 'POST',
                url: ajax_send_or_download_details.ajaxurl,
                data: {
                    action: 'update_calorie_burning_post',
                    calorie_burning_data : calorie_burning_data
                },
                success: function(data, textStatus, XMLHttpRequest) {

                    //console.log('Post created with id: ', data);
                    //console.log(data);

                    //let's add the created post to the table instantly.

                    var row_class = $this.parent().parent().attr('class');

                    var new_calorie_burning_row  = '<tr role="row" class="'+ row_class +' new_row_transition">';
                    new_calorie_burning_row +=     '<td>'+ calorie_burning_data.activity +'</td>';
                    new_calorie_burning_row +=     '<td>' + calorie_burning_data.person_125lbs + '</td>';
                    new_calorie_burning_row +=     '<td>' + calorie_burning_data.person_155lbs + '</td>';
                    new_calorie_burning_row +=     '<td>' + calorie_burning_data.person_185lbs + '</td>';
                    new_calorie_burning_row +=     '<td>';
                    new_calorie_burning_row +=         '<input type="button" value="Edit" id="calorie_bunring_edit" class="calorie_bunring_edit button" data-post-id="'+ calorie_burning_data.post_id +'" >';
                    new_calorie_burning_row +=         '<input type="button" value="Delete" id="delete_post" class="delete_post button" data-post-id="'+ calorie_burning_data.post_id +'" >';
                    new_calorie_burning_row +=     '</td>';
                    new_calorie_burning_row += '</tr>';


                    $this.parent().parent().replaceWith(new_calorie_burning_row);

                },
                error: function(MLHttpRequest, textStatus, errorThrown) {
                    //alert(errorThrown);
                    console.log(errorThrown);

                }
            });

        });

        //delte all foods.
        jQuery(document).on('click', '#delete_all_foods', function(e) {

            var confirm_deletion = confirm("Do you really want to delete all foods?");

            if(confirm_deletion) {


                jQuery(this).attr('value', 'Deleting...')

                var $this = jQuery(this);


                $this.attr('value', 'Deleting all foods...');

                jQuery.ajax({

                    type: 'POST',
                    url: ajax_send_or_download_details.ajaxurl,
                    data: {
                        action: 'delete_all_foods'

                    },
                    success: function(data, textStatus, XMLHttpRequest) {
                        //console.log(data);
                        $this.attr('value', 'Delete All Foods');

                        //store first row to append later on the table
                        var first_row = jQuery("#food_calorie_table_body tr.add_new_entry");
                        food_calorie_table.rows().remove().draw();
                        jQuery("#food_calorie_table_body").prepend(first_row);

                        //let's add the created post to the table instantly.


                    },
                    error: function(MLHttpRequest, textStatus, errorThrown) {
                        //alert(errorThrown);
                        console.log(errorThrown);

                    }
                });

            }

        });

        //delete all activities.
        jQuery(document).on('click', '#delete_all_activities', function(e) {

            var confirm_deletion = confirm("Do you really want to delete all activites?");

            if(confirm_deletion) {

                jQuery(this).attr('value', 'Deleting...')

                var $this = jQuery(this);


                $this.attr('value', 'Deleting all activites...');

                jQuery.ajax({

                    type: 'POST',
                    url: ajax_send_or_download_details.ajaxurl,
                    data: {
                        action: 'delete_all_activities'

                    },
                    success: function(data, textStatus, XMLHttpRequest) {
                        //console.log(data);
                        $this.attr('value', 'Delete All Activities');
                        //store first row to append later on the table
                        var first_row = jQuery("#calorie_burning_table_body tr.add_new_entry");
                        calorie_burning_table.rows().remove().draw();
                        jQuery("#calorie_burning_table_body").prepend(first_row);



                    },
                    error: function(MLHttpRequest, textStatus, errorThrown) {
                        //alert(errorThrown);
                        console.log(errorThrown);

                    }
                });

            }

        });




        //generate shortcode
        jQuery(document).on('click', '.generate_shortcode', function(e) {

            var shortcode = '[calorie_calculator';

            var $this = jQuery(this);

            //var $enable_subscription = $this.find('#enable_subscription');
            var $hide_name_field = $this.find('#hide_name_field');
            var $hide_lastname = $this.find('#hide_lastname');
            var $hide_email_field = $this.find('#hide_email_field');
            var $hide_send_to_email = $this.find("#hide_send_to_email_button");
            var $hide_download_as_pdf = $this.find("#hide_download_as_pdf_button");
            var $selected_unit = $this.find("#select_unit > option:selected");
            var $selected_styling = $this.find("#select_styling >option:selected");

            jQuery('#select_unit, #select_styling').change(function(){
                $this.click();
            });

            // if($enable_subscription.prop('checked')) {

            //     shortcode += ' enable_subscription="true"';
            // }

            if($hide_name_field.prop('checked')) {

                shortcode += ' show_name_field="false"';
            }

            if($hide_lastname.prop('checked')) {

                shortcode += ' show_firstname_only="true"';
            }

            if($hide_email_field.prop('checked')) {

                shortcode += ' show_email_field="false"';
            }


            if($hide_send_to_email.prop('checked')) {

                shortcode += ' send_to_email="false"';
            }

            if($hide_download_as_pdf.prop('checked')) {

                shortcode += ' download_as_pdf="false"';
            }

            if($selected_unit.attr('value') == 'usunit') {

                shortcode += ' unit="usunit"';

            } else if($selected_unit.attr('value') == 'metricunit') {

                shortcode += ' unit="metricunit"';
            }

            if($selected_styling.attr('value') != '') {

                shortcode += ' template="'+$selected_styling.attr('value')+'"';

            }

            shortcode += ']';

            jQuery('.generated_shortcode > textarea').html(shortcode);

        });


        //select shortcode text when uses focuses on the textarea field.
        jQuery(".generated_shortcode_textarea").focus(function(e) {
            jQuery(this).select();
        });

        //Generate calorie calculator result for us units.
        jQuery( ".calorie_calculator_form_us_units" ).submit(function(e) {

            var $this = jQuery(this);

            e.preventDefault();

            var has_empty_field = false;

            try {

                var formData = $this.serializeArray().reduce(function(obj, item) {

                    var form_field = $this.find('input[name="'+item.name+'"]').first();

                    //console.log(form_field);

                    if(item.value == '') {

                        has_empty_field = true;

                        form_field.addClass('empty-highlight');
                        form_field.closest('form-group').addClass('has-error');

                        jQuery($this).on('keyup', 'input', function(e) {

                            if( this.value != '' ) {

                                $(this).removeClass('empty-highlight');
                                $(this).closest('form-group').addClass('has-error');

                            }

                        });


                        //return;
                    } else {

                        if(form_field.hasClass('empty-highlight')) {
                            form_field.removeClass('empty-highlight');
                            form_field.closest('form-group').addClass('has-error');
                        }

                    }

                    obj[item.name] = item.value;
                    return obj;

                }, {});

                if(has_empty_field) {

                    $this.prepend('<div class="calorie_calculator_show_errors"><span class="calcal_flash_message">'+ translation_array.please_fill_up_all_fields +'</span></div>');

                    $('.calcal_flash_message').delay(500).fadeIn('normal', function() {
                        $(this).delay(3500).fadeOut();
                        $('.calorie_calculator_show_errors').remove();
                    });

                    throw new Error("Please Fill up all of the fields!");
                }


                //console.log(formData);

                //Remove nonce value
                delete formData.calorie_calculator_form_nonce_field_action;

                calorie_calculator.persondata = formData;

                localStorage.setItem('personDataUSUnit', JSON.stringify(calorie_calculator.persondata));


                // ref: http://www.calculator.net/calorie-calculator.html

                /*
                 * BMR calculation
                 */

                var BMR =  0;

                console.log(formData);

                var age = formData.calorie_calculator_age,
                    gender = formData.calorie_calculator_gender,
                    height = (formData.calorie_calculator_height_feet * 30.48) + (formData.calorie_calculator_height_inch * 2.54),
                    weight = formData.calorie_calculator_weight * 0.453592,
                    activity_factor = formData.calorie_calculator_activity,
                    email = formData.user_email,
                    first_name = formData.first_name,
                    nonce = jQuery('#calorie_calculator_form_nonce_field_action').val();


                if(formData.calorie_calculator_gender == 'male') {

                    BMR = 10 * weight + 6.25 * height - 5 * age + 5;
                }

                if(formData.calorie_calculator_gender == 'female') {

                    BMR = 10 * weight + 6.25 * height - 5 * age - 161;
                }

                //Now apply activity factor to BMR

                BMR = Math.round(BMR * activity_factor);

                //set BMR data to global varialbe
                calorie_calculator.BMR = BMR;
                calorie_calculator.activity_factor = activity_factor;

                if( activity_factor == 1) {

                    var result = '<p class="calorie_calculator_single_result green">' + translation_array.bmr + ' = <span class="bmr_val">' + BMR + '</span> '+ translation_array.calories_per_day +'.</p>';

                } else {

                    var result = '<p class="calorie_calculator_single_result green"><span>&#9755;</span> '+ translation_array.you_need +' <span class="bmr_val">' + BMR + '</span> '+ translation_array.calories_to_maintain_weight +'</p>';

                    result += '<p class="calorie_calculator_single_result"><span>&#9755;</span> ' + translation_array.you_need + ' ' + (BMR - 500) + ' ' + translation_array.calories_per_day_to_loose_1lb_per_week +'</p>';
                    result += '<p class="calorie_calculator_single_result"><span>&#9755;</span> ' + translation_array.you_need + ' ' + (BMR - 1000) + ' ' + translation_array.calories_per_day_to_loose_2lb_per_week +'</p>';
                    result += '<p class="calorie_calculator_single_result"><span>&#9755;</span> ' + translation_array.you_need + ' ' + (BMR + 500) + ' ' + translation_array.calories_per_day_to_gain_1lb_per_week +'</p>';
                    result += '<p class="calorie_calculator_single_result"><span>&#9755;</span> ' + translation_array.you_need + ' ' + (BMR + 1000) + ' ' + translation_array.calories_per_day_to_gain_2lb_per_week + '</p>';
                }

                //console.log($this.parent().parent().parent());

                if(formData['template'] == 'bootstrap-general') {
                    //console.log(formData['template']);
                    $this.parent().parent().parent().find(".calorie_calculator_result").css({'display': 'block'}).html(result);
                    $this.parent().parent().parent().find(".send_or_download").removeClass('hide');
                } else {
                    //console.log(formData['template']);
                    $this.parent().parent().find(".calorie_calculator_result").css({'display': 'block'}).html(result);
                    $this.parent().parent().find(".send_or_download").removeClass('hide');
                }

                if( ( email != undefined || email != '' ) || ( first_name != undefined || first_name != '' ) ) {


                    jQuery.ajax({
                        type: 'POST',
                        url: ajax_send_or_download_details.ajaxurl,
                        data: {
                            'action': 'create_new_form_submission_entry',
                            'formData': formData,
                            'age': age,
                            'gender': gender,
                            'height': height,
                            'weight': weight,
                            'activity_factor': activity_factor,
                            'user_email': formData.user_email,
                            'BMR': BMR,
                            'unit': 'US Unit',
                            'nonce': nonce
                        },
                        success: function(data) {

                            console.log(data);

                        },
                        error: function(data) {

                            console.log(data);

                        }

                    });




                }

            } catch(errorMessage) {

                console.log(errorMessage);

            }

        });

        //Generate calorie calculator result for metric units.
        jQuery( ".calorie_calculator_form_metric_units" ).submit(function(e) {
            e.preventDefault();

            var $this = jQuery(this);

            var has_empty_field = false;

            try {

                var formData = $this.serializeArray().reduce(function(obj, item) {

                    var form_field = $this.find('input[name="'+item.name+'"]').first();

                    //console.log(form_field);

                    if(item.value == '') {

                        has_empty_field = true;

                        form_field.addClass('empty-highlight');
                        form_field.closest('form-group').addClass('has-error');

                        jQuery($this).on('keyup', 'input', function(e) {

                            if( this.value != '' ) {

                                $(this).removeClass('empty-highlight');
                                $(this).closest('form-group').addClass('has-error');

                            }

                        });


                        //return;
                    } else {

                        if(form_field.hasClass('empty-highlight')) {
                            form_field.removeClass('empty-highlight');
                            form_field.closest('form-group').addClass('has-error');
                        }

                    }

                    obj[item.name] = item.value;
                    return obj;

                }, {});

                if(has_empty_field) {

                    $this.prepend('<div class="calorie_calculator_show_errors"><span class="calcal_flash_message">'+ translation_array.please_fill_up_all_fields +'</span></div>');

                    $('.calcal_flash_message').delay(500).fadeIn('normal', function() {
                        $(this).delay(3500).fadeOut();
                        $('.calorie_calculator_show_errors').remove();
                    });

                    throw new Error("Please Fill up all of the fields!");
                }


                console.log(formData);

                //Remove nonce value
                delete formData.calorie_calculator_form_nonce_field_action;
                calorie_calculator.persondata = formData;
                localStorage.setItem('personDataMetricUnit', JSON.stringify(calorie_calculator.persondata));

                // ref: http://www.calculator.net/calorie-calculator.html

                /*
                 * BMR calculation
                 */

                var BMR =  0;

                var age = formData.calorie_calculator_age,
                    gender = formData.calorie_calculator_gender,
                    height = formData.calorie_calculator_height,
                    weight = formData.calorie_calculator_weight,
                    activity_factor = formData.calorie_calculator_activity,
                    email = formData.user_email,
                    first_name = formData.first_name,
                    nonce = jQuery('#calorie_calculator_form_nonce_field_action').val();


                // console.log(height);
                // console.log(weight);
                // console.log(activity_factor);
                // console.log(age);


                if(formData.calorie_calculator_gender == 'male') {

                    BMR = 10 * weight + 6.25 * height - 5 * age + 5
                }

                if(formData.calorie_calculator_gender == 'female') {

                    BMR = 10 * weight + 6.25 * height - 5 * age - 161;
                }

                // console.log(formData);
                // console.log(weight);
                // console.log(height);

                // console.log(BMR);

                //Now apply activity factor to BMR

                BMR = Math.round(BMR * activity_factor);

                //set BMR data to global varialbe
                calorie_calculator.BMR = BMR;
                calorie_calculator.activity_factor = activity_factor;


                if( activity_factor == 1) {

                    var result = '<p class="calorie_calculator_single_result green">' + translation_array.bmr + ' = <span class="bmr_val">' + BMR + '</span> '+ translation_array.calories_per_day +'.</p>';

                } else {

                    var result = '<p class="calorie_calculator_single_result green"><span>&#9755;</span>  '+ translation_array.you_need +' <span class="bmr_val">' + BMR + '</span> '+ translation_array.calories_to_maintain_weight +'</p>';

                    result += '<p class="calorie_calculator_single_result"><span>&#9755;</span> ' + translation_array.you_need + ' ' + (BMR - 500) + ' '+ translation_array.calories_per_day_to_loose_point_5kg_per_week +'</p>';
                    result += '<p class="calorie_calculator_single_result"><span>&#9755;</span> ' + translation_array.you_need + ' ' + (BMR - 1000) + ' ' + translation_array.calories_per_day_to_loose_1kg_per_week +'</p>';
                    result += '<p class="calorie_calculator_single_result"><span>&#9755;</span> ' + translation_array.you_need + ' ' + (BMR + 500) + ' ' + translation_array.calories_per_day_to_gain_point_5kg_per_week +'</p>';
                    result += '<p class="calorie_calculator_single_result"><span>&#9755;</span> ' + translation_array.you_need + ' ' + (BMR + 1000) + ' ' + translation_array.calories_per_day_to_gain_1kg_per_week +'</p>';
                }

                if(formData['template'] == 'bootstrap-general') {
                    //console.log(formData['template']);
                    $this.parent().parent().parent().find(".calorie_calculator_result").css({'display': 'block'}).html(result);
                    $this.parent().parent().parent().find(".send_or_download").removeClass('hide');
                } else {
                    //console.log(formData['template']);
                    $this.parent().parent().find(".calorie_calculator_result").css({'display': 'block'}).html(result);
                    $this.parent().parent().find(".send_or_download").removeClass('hide');
                }

                if( ( email != undefined || email != '' ) || ( first_name != undefined || first_name != '' ) ) {

                    jQuery.ajax({
                        type: 'POST',
                        url: ajax_send_or_download_details.ajaxurl,
                        data: {
                            'action': 'create_new_form_submission_entry',
                            'formData': formData,
                            'age': age,
                            'gender': gender,
                            'height': height,
                            'weight': weight,
                            'activity_factor': activity_factor,
                            'user_email': formData.user_email,
                            'BMR': BMR,
                            'unit': 'Metric Unit',
                            'nonce': nonce
                        }

                    });

                }



            } catch(errorMessage) {
                console.log(errorMessage);
            }

        });



        jQuery("#save_calcalpro_options").on('click', function(e) {

            e.preventDefault();

            var $this = jQuery(this);

            var initial_text = $this.text();

            var options = {};

            var $form_data = jQuery('form').serializeArray();

            jQuery.each($form_data, function(i, field) {
                if(field.value != '') {
                    options[field.name] = field.value;
                }
            });


            if(!jQuery.isEmptyObject(options)) {

                $this.text('Saving...');

                create_calcalpro_options(options, initial_text, $this);

            } else {

                alert('No data to save!');

            }


        });



        //populate form data from localStorage if available
        // Retrieve the object from storage
        personDataUSUnit = JSON.parse(localStorage.getItem('personDataUSUnit'));
        personDataMetricUnit = JSON.parse(localStorage.getItem('personDataMetricUnit'));


        if(personDataUSUnit) {
            for (var key in personDataUSUnit) {
                // skip loop if the property is from prototype
                if (!personDataUSUnit.hasOwnProperty(key)) continue;

                var value = personDataUSUnit[key];

                if( key == 'calorie_calculator_gender' ) {
                    var selector = '.calorie_calculator_form_us_units input[value="'+value+'"]';
                    jQuery(selector).prop('checked', true);
                } else if( key == 'calorie_calculator_activity' ) {
                    var selector = '.calorie_calculator_form_us_units option[value="'+value+'"]';
                    jQuery(selector).prop('selected', true);

                    //console.log(value);

                    jQuery(".calcalpro-custom-options span[data-value='"+value+"']").first().addClass('selection');
                    jQuery('.calcalpro-custom-select-trigger').text(jQuery(selector).first().text());

                } else if( key == 'template' ) {
                    continue;
                } else if( key == 'unit') {
                    continue;
                } else {
                    var selector = '.calorie_calculator_form_us_units input[name="'+key+'"]';
                    jQuery(selector).attr('value', value);
                }

            }
        }

        if(personDataMetricUnit) {
            for (var key in personDataMetricUnit) {
                // skip loop if the property is from prototype
                if (!personDataMetricUnit.hasOwnProperty(key)) continue;

                var value = personDataMetricUnit[key];

                if( key == 'calorie_calculator_gender' ) {
                    var selector = '.calorie_calculator_form_metric_units input[value="'+value+'"]';
                    jQuery(selector).prop('checked', true);
                } else if( key == 'calorie_calculator_activity' ) {
                    var selector = '.calorie_calculator_form_metric_units option[value="'+value+'"]';
                    jQuery(selector).prop('selected', true);
                } else if( key == 'template' ) {
                    continue;
                } else if( key == 'unit') {
                    continue;
                } else {
                    var selector = '.calorie_calculator_form_metric_units input[name="'+key+'"]';
                    jQuery(selector).attr('value', value);
                }


            }
        }


    });



} );