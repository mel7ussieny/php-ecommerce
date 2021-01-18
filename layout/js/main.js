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

    $(".login h3 span").click(function(){
        if($(this).attr("class") == "signin"){
          $(this).css("color","#0069D9");
          $(this).siblings().css("color","#2b2b2b");
        }else if($(this).attr("class") == "signup"){
          $(this).css("color","#218838");
          $(this).siblings().css("color","#2b2b2b");
          
        }
        $(".login form").hide();
        $(".form-login."+$(this).attr("class")).show(100);
    })
      $(".preview").on("keyup keydown",function(){
        $("."+$(this).attr("data-live")).text($(this).val());
      })
})