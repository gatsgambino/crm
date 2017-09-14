$(document).foundation()

$(function() {
    
    //$('#home').hide().delay(500).slideDown(500);
    
    var $home_form = $('#hf-core');

    // variables for form icons
    var user_icon  = '<i class="fa fa-user hffa-custom" aria-hidden="true"></i>';
    var user_white = '<i class="fa fa-user-o" aria-hidden="true"></i>';
    // focus events for form email and username
    $home_form.find('#email').on('focus', function(e) {
        $('#user-icon > i').css({'color':'white', 'background-color':'#6a5a8c'});
        $('#user-icon').css('background-color', '#6a5a8c');
    });
    $home_form.find('#username').on('focus', function(e) {
        $('#user-icon > i').css({'color':'white', 'background-color':'#6a5a8c'});
        $('#user-icon').css('background-color', '#6a5a8c');
    });
    // blur events for form email and username
    $home_form.find('#email').on('blur', function(e) {
        $('#user-icon > i').css({'color':'#6a5a8c', 'background-color':'white'});
        $('#user-icon').css('background-color', 'white');
    });
    $home_form.find('#username').on('blur', function(e) {
        $('#user-icon > i').css({'color':'#6a5a8c', 'background-color':'white'});
        $('#user-icon').css('background-color', 'white');
    });
    
    // different icon sets for password form element
    var lock_icon   = '<i id="pwd-icon" class="fa fa-lock hffa-custom" aria-hidden="true"></i>';
    var unlock_icon = '<i id="pwd-icon" class="fa fa-unlock-alt hffa-custom" aria-hidden="true"></i>';
    $home_form.find('#pwd').on('focus', function(e) {
        $('#pwd-icon').html(unlock_icon);
        $('#pwd-icon > i').css({'color':'white', 'background-color':'#6a5a8c'});
        $('#pwd-icon').css('background-color', '#6a5a8c');
    });
    $home_form.find('#pwd').on('blur', function(e) {
        $('#pwd-icon').html(lock_icon);
        $('#pwd-icon > i').css({'color':'#6a5a8c', 'background-color':'white'});
        $('#pwd-icon').css('background-color', 'white');
    });

});

