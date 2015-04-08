var ls = ls || {};

ls.admins = (function ($) {

    this.options = {
        active: 'active',
        loader: DIR_STATIC_SKIN + '/images/loader.gif',
        type: {
            tournament: {
                url: aRouter['ajax'] + 'admins/tournament/'
            },
            teams: {
                url: aRouter['ajax'] + 'admins/teams/'
            },
            playoff: {
                url: aRouter['ajax'] + 'admins/playoff/'
            },
            players: {
                url: aRouter['ajax'] + 'admins/players/'
            },
            create_stat_table: {
                url: aRouter['ajax'] + 'admins/create_stat_table/'
            },
            create_schedule: {
                url: aRouter['ajax'] + 'admins/create_schedule/'
            },
            delete_schedule: {
                url: aRouter['ajax'] + 'admins/delete_schedule/'
            },
            set_teams: {
                url: aRouter['ajax'] + 'admins/set_teams/'
            },
            group: {
                url: aRouter['ajax'] + 'admins/group/'
            },
            schedule: {
                url: aRouter['ajax'] + 'admins/schedule/'
            },
            event: {
                url: aRouter['ajax'] + 'admins/event/'
            },
            event_day: {
                url: aRouter['ajax'] + 'admins/event_day/'
            },
            penalty: {
                url: aRouter['ajax'] + 'admins/penalty/'
            },
            award: {
                url: aRouter['ajax'] + 'admins/award/'
            }
        }
    }

    this.onLoad = function (result, blockContent) {
        blockContent.html('');
        if (!result) {
            ls.msg.error('Error', 'Please try again later');
        }
        if (result.bStateError) {
            ls.msg.error(result.sMsgTitle, result.sMsg);
        } else {
            blockContent.html(result.sText);
            $('.date-picker').datepicker({
                weekStart: 1,
                dateFormat: 'dd.mm.yy',
                firstDay: 1,
                autoclose: true
            });
            if (1 == 1) {
                ls.autocomplete.add($(".autocomplete-teams"), aRouter['ajax'] + 'autocompleter/teams/', false);
                ls.autocomplete.add($(".autocomplete-users"), aRouter['ajax'] + 'autocompleter/user/', false);

                ls.autocomplete.add($(".autocomplete-player_card"), aRouter['ajax'] + 'autocompleter/player_card/', true);
                ls.autocomplete.add($(".autocomplete-team"), aRouter['ajax'] + 'autocompleter/team/', false);
            }
            $(".dropdown .buttons, .dropdown buttons").click(function () {

                if (!$(this).find('span.toggle').hasClass('active')) {
                    $('.dropdown-slider').slideUp();
                    $('span.toggle').removeClass('active');
                    var params = {};
                    params['match_id'] = $(this).attr("name");
                    var name_of_this = $(this);

                    ls.ajax(aRouter['ajax'] + 'match/get_buttons/', params, function (result) {
                        if (!result) {
                            ls.msg.error('Error', 'Please try again later');
                        }
                        if (result.bStateError) {
                            ls.msg.error('Error', 'Please try again later');
                        } else {
                            $(name_of_this).parent().append(result.sText);
                            $(name_of_this).parent().find('.dropdown-slider').slideToggle('fast');
                            $(name_of_this).find('span.toggle').toggleClass('active');

                        }
                    });


                } else {
                    $(this).parent().find('.dropdown-slider').remove();
                    $(this).parent().find('.dropdown-slider').slideToggle('fast');
                    $(this).find('span.toggle').toggleClass('active');
                }
                return false;
            });

        }
    },
        this.toggle = function (obj, type, params) {

            if (!this.options.type[type]) return false;
            thisObj = this;
            this.obj = $(obj);

            var blockContent = $('#div_admins');

            this.showProgress(blockContent);


            ls.ajax(this.options.type[type].url, params, function (result) {
                if (!result) {
                    ls.msg.error('Error', 'Please try again later');
                }
                if (result.bStateError) {
                    ls.msg.error(result.sMsgTitle, result.sMsg);
                } else {
                    this.onLoad(result, blockContent);
                }
            }.bind(this));


        }

    this.simple_toggles = function (obj, type, params) {

        if (!this.options.type[type]) return false;
        thisObj = this;
        this.obj = $(obj);

        if (type == 'event_day') {
            var blockContent = $('#div_event_day');
        } else {
            var blockContent = thisObj.obj.parent('div');
        }
        this.showProgress(blockContent);


        if (type == "map") {
            params['mapintournament'] = this.obj.val();
        }
        if (type == "eventday") {
            params['event_id'] = this.obj.val();
        }

        ls.ajax(this.options.type[type].url, params, function (result) {
            this.onLoad(result, blockContent);

            if (type == "map") {
                $("#gonka_list").sortable({
                    update: function () {
                        var params = {};
                        params['kval_gonka'] = 0;
                        params['mapintournament_id'] = $('#speedB').val();
                        params['order'] = $('#gonka_list').sortable('serialize');
                        ls.ajax(aRouter['ajax'] + 'map/order/', params, function (result) {
                            if (!result) {
                                ls.msg.error('Error14', 'Please try again later');
                            }
                            if (result.bStateError) {
                                ls.msg.error('Error15', 'Please try again later');
                            } else {

                            }
                        });
                    }
                });

                $("#kval_list").sortable({
                    update: function () {
                        var params = {};
                        params['kval_gonka'] = 0;
                        params['mapintournament_id'] = $('#speedB').val();
                        params['order'] = $('#kval_list').sortable('serialize');
                        ls.ajax(aRouter['ajax'] + 'map/order/', params, function (result) {
                            if (!result) {
                                ls.msg.error('Error14', 'Please try again later');
                            }
                            if (result.bStateError) {
                                ls.msg.error('Error15', 'Please try again later');
                            } else {

                            }
                        });
                    }
                });
            }

        }.bind(this));

    }

    this.showProgress = function (content) {
        content.html($('<div />').css('text-align', 'center').append($('<img>', {src: this.options.loader})));
    };

    return this;
}).call(ls.admins || {}, jQuery);