$(function () {
    $.nette.init();
});

$( document ).ready(function() {
    $("a.async-load").each(function () {
        $.nette.ajax({ off: ['unique'], "url": this.getAttribute("href")});
    });
});