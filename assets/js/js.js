// 变黑函数
function setDark() {
  localStorage.setItem("isDarkMode", "1");
  document.documentElement.classList.add("dark");
}
// 变白函数
function removeDark() {
  localStorage.setItem("isDarkMode", "0");
  document.documentElement.classList.remove("dark");
}
// switch按钮
function switchDarkMode() {
  let isDark = localStorage.getItem("isDarkMode");
  if (isDark == '1') {
    removeDark();
  } else {
    setDark();
  }
}


jQuery(document).ready(function($){

//table预设calss
$('.wznrys table').addClass("table");

});


$(document).ready(function(){
    //子菜单点击展开
    $('.menu-zk .menu-item-has-children').prepend('<span class="czxjcdbs"></span>');
    $('.menu-zk li.menu-item-has-children .czxjcdbs').click(function(){
    $(this).toggleClass("kai");
    $(this).nextAll('.sub-menu').slideToggle("slow");
    });
});


//列表ajax加载
jQuery(document).ready(function($) {
$('div.post-read-more a').click( function() {
    $this = $(this);
    $this.addClass('loading');
    var href = $this.attr("href");
    if (href != undefined) {
        $.ajax( {
            url: href,
            type: "get",
        error: function(request) {
        },
        success: function(data) {
            $this.removeClass('loading');
            var $res = $(data).find(".post_loop");
            $('.post_box').append($res);
            var newhref = $(data).find(".post-read-more a").attr("href");
            if( newhref != undefined ){
                $(".post-read-more a").attr("href",newhref);
            }else{
                $(".post-read-more").hide();
            }
        }
        });
    }
    return false;
});
});


//导航菜单
function ds_mainmenu(ulclass){
    $(document).ready(function(){
        $(ulclass+' li').hover(function(){
            $(this).children("ul").show();
        },function(){
            $(this).children("ul").hide();
        });
    });
}
ds_mainmenu('.header-menu-ul');



//赞
$.fn.postLike = function() {
    if ($(this).hasClass('done')) {
        alert('勿重复操作');
        return false;
    } else {
        $(this).addClass('done');
        var id = $(this).data("id"),
        action = $(this).data('action'),
        rateHolder = $(this).children('.count');
        var ajax_data = {
            action: "specs_zan",
            um_id: id,
            um_action: action
        };
        $.post("/wp-admin/admin-ajax.php", ajax_data,
        function(data) {
            $(rateHolder).html(data);
        });
        return false;
    }
};
$(document).on("click", ".specsZan", function() {$(this).postLike();});


//返回顶部
const scrollToTopBtn = document.querySelector(".scrollToTopBtn")
const rootElement = document.documentElement
function handleScroll() {
  const scrollTotal = rootElement.scrollHeight - rootElement.clientHeight
  if ((rootElement.scrollTop / scrollTotal ) > 0.80 ) {
    scrollToTopBtn.classList.add("showBtn")
  } else {
    scrollToTopBtn.classList.remove("showBtn")
  }
}
function scrollToTop() {
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth"
  })
}
scrollToTopBtn.addEventListener("click", scrollToTop)
document.addEventListener("scroll", handleScroll)

