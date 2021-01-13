$(document).ready(function(){
    $('[placeholder]').focus(function(){
      $(this).attr('data-holder',$(this).attr('placeholder'));
      $(this).removeAttr('placeholder');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-holder'));
    })

    $("select").selectBoxIt({
      autoWidth:false,
    });
})