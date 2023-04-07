function disconnectAccount() {
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/panel/logout',
        success: function() {
            window.location = '/';
        }
    });
}