var tabs = new Array(1);
$(function() {
    var total_tabs = 0;
    // initialize first tab
    total_tabs++;
    addtab(total_tabs,'home.php','INICIO');

    $("#addtab, #litab").click(function() {
        total_tabs++;
        //$("#tabcontent p").hide();
        addtab(total_tabs,'home.php','INICIO');
        return false;
    });
});

function addtab(count, url, title) {
        if(tabs.indexOf(count)==-1){
            $("#tabcontent p").hide();
            var closetab = '<a href="" id="close'+count+'" class="close">&times;</a>';
            $("#tabul").append('<li id="t'+count+'" class="ntabs">'+title+'&nbsp;&nbsp;'+closetab+'</li>');
            $("#tabcontent").append('<p id="c'+count+'"><iframe src="'+url+'" height="100%" width="100%"></iframe></p>');

            $("#tabul li").removeClass("ctab");
            $("#t"+count).addClass("ctab");

            $("#t"+count).bind("click", function() {
                $("#tabul li").removeClass("ctab");
                $("#t"+count).addClass("ctab");
                $("#tabcontent p").hide();
                $("#c"+count).fadeIn('slow');
            });
    /*
            $("#close"+count).bind("click", function() {
                // activate the previous tab
                $("#tabul li").removeClass("ctab");
                $("#tabcontent p").hide();
                $(this).parent().prev().addClass("ctab");
                $("#c"+count).prev().fadeIn('slow');

                $(this).parent().remove();
                $("#c"+count).remove();
                return false;
            });
      */      
            $("#close" + count).bind("click", function () {
                // activate the previous tab
                $("#tabul li").removeClass("ctab");
                var id = $(this).parent().prev().attr('id');
                if (id != "litab") {
                    $("#tabcontent div").hide();
                    $(this).parent().prev().addClass("ctab");
                    $("#c" + count).prev().fadeIn('slow');
                }else {
                    if ($(this).parent().next().length) {
                        $(this).parent().next().addClass("ctab");
                        $("#c" + count).next().fadeIn('slow');
                    }
                }
                $(this).parent().remove();
                $("#c" + count).remove();
                 tabs[tabs.indexOf(count)] = -1;
                return false;
            });
            tabs[tabs.length] = count;            
        }else{
            $("#tabul li").removeClass("ctab");
            $("#t"+count).addClass("ctab");
            $("#tabcontent p").hide();
            $("#c"+count).fadeIn('slow');
            return false;
        }
}
if (!Array.prototype.indexOf){
  Array.prototype.indexOf = function(elt /*, from*/){
    var len = this.length >>> 0;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++){
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}