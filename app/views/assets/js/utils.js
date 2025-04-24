export function showAlert(message, type='success') {
    $.notify({
        icon: 'icon-bell',
        title: 'Book Master',
        message: `${message}`,
    }, {
        type: type,
        allow_dismiss: true,
        placement: {
            from: "bottom",
            align: "right"
        },
        delay: 4000,
        timer: 1000,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        z_index: 1031
    });

}