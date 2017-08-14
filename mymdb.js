// common js mostly to deal with user checking/unchecking films for wish list
$(document).ready(function() {
    var top = $('#top');
    if (top.length) $('#top')[0].click(); // move to top of page
    var wish = window.location.pathname.indexOf("wish_list.php");
    $('.check').on("click", function() {
        var filmID = this.id;
        var isChecked = this.checked;
        $.ajax({
          url: "make_wish.php",
          method: "POST",
          data: { id : filmID, checked: isChecked },
        });
        if (wish && !isChecked) { // this is the wish list page, wish to be removed
            $(("#" + filmID + "tr")).remove();
            $(".count").each(function(index, elem) {
                $(elem).html(index + 1); // update count displayed
            });
        }
    });
});
