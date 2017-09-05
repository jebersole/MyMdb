// common js mostly to deal with user checking/unchecking films for wish list
$(document).ready(function() {
    var top = $('#top');
    if (top.length) $('#top')[0].click(); // move to top of page

    // populate checked boxes by querying user's wish list
    $.ajax({
        url: "get_wish.php",
        cache: false
    })
    .done(function( wishes ) {
        var checkboxes = $('.check');
        for (var i = 0; i < wishes.length; i++) {
            checkboxes.filter('#' + wishes[i]['id']).prop('checked', true);
        }
        checkboxes.prop("disabled", false);
    });

    $('.check').on("click", function() {
        var filmID = this.id;
        var isChecked = this.checked;
        $.ajax({
          url: "make_wish.php",
          method: "POST",
          data: { id : filmID, checked: isChecked },
        });

        var wish = window.location.pathname.indexOf("wish_list.php");
        if (wish > 0 && !isChecked) { // this is the wish list page and user removing a wish
            $(("#" + filmID + "tr")).remove();
            var countBoxes = $(".count");
            if (countBoxes.length) {
                countBoxes.each(function(index, elem) {
                    $(elem).html(index + 1); // update count displayed
                });
            } else { // remove table header if all items removed
                $('table').remove();
                $('h1').html('Nothing here yet. How about running a search to add some?')
                    .css('fontSize', '1.17em');
            }
        }
    });
});
