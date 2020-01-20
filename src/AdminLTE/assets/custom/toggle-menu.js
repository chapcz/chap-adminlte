$('.sidebar-toggle').click(function(event) {
    event.preventDefault();
    if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        sessionStorage.setItem('sidebar-toggle-collapsed', '');
        document.cookie = "sidebar-toggle-collapsed=0;path=/";
    } else {
        sessionStorage.setItem('sidebar-toggle-collapsed', '1');
        document.cookie = "sidebar-toggle-collapsed=1;path=/";
    }
});