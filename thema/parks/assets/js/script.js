$(document).ready(function(){
     //submenu 설정 (2019.07.23)
    var store_cat = $('.store-cat');
    var store_cat_top = $('.store-category-top');
    var store_s_cat = $('.store-s-cat');
    var store_s_cat_top = $('.store-s-category-top');
    store_cat.mouseenter(function(){
        store_cat_top.addClass('menu-open');
    });
    store_cat_top.mouseleave(function(){
        store_cat_top.removeClass('menu-open');
    });
    store_s_cat.mouseenter(function(){
        store_s_cat_top.addClass('menu-open');
    });
    store_s_cat_top.mouseleave(function(){
        store_s_cat_top.removeClass('menu-open');
    });
    
    
    //mobile-menu
    var rightMenu = $('.right-sub');
    var rightMenuLi = rightMenu.find('>li');
    
    $.each(rightMenuLi,function(index,item){
        var subMenu = $(this).find('.right-sub-ul');
        $(this).mouseenter(function(){
            subMenu.addClass('menu-open');
        });
        $(this).mouseleave(function(){
            subMenu.removeClass('menu-open');
        });
    });
  rightMenu.mouseleave(function(){
      $.each(rightMenuLi,function(index,item){
          var subMenu = $(this).find('.right-sub-ul');
          subMenu.removeClass('menu-open');
      });
  });   
  var subPage = new Array;
    subPage[0] = 'community','shop';
    subPage[1] = 'greeting';
    subPage[2] = 'classinfo';
    subPage[3] = 'fur-content','best-store';
    subPage[4] = 'signup';
    var url = window.location.pathname;
    var getAr0 = url.indexOf(subPage[0]);
    var getAr1 = url.indexOf(subPage[1]);
    var getAr2 = url.indexOf(subPage[2]);
    var getAr3 = url.indexOf(subPage[3]);
    var getAr4 = url.indexOf(subPage[4]);
    if(getAr0 != -1){
         $("ul.sub-dl > li:eq(0) > a").addClass("menu-on")
    };
    if(getAr1 != -1){
         $("ul.sub-dl > li:eq(1) > a").addClass("menu-on")
    };
    if(getAr2 != -1){
         $("ul.sub-dl > li:eq(2) > a").addClass("menu-on")
    };
    if(getAr3 != -1){
         $("ul.sub-dl > li:eq(3) > a").addClass("menu-on")
    };
    if(getAr4 != -1){
         $("ul.sub-dl > li:eq(4) > a").addClass("menu-on")
    };
});
