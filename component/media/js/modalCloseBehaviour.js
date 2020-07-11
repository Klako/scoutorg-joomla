function onModalReload(modalId) {
    jQuery('#Frame_' + modalId).on('load', function () {
        iframeDocument = jQuery(this).contents().get(0);
        
        let systemMessages = iframeDocument.getElementById('system-message-container');
        if (!systemMessages) {
            window.parent.location.reload();
        }
        let messages = systemMessages.children;
        var error = false;
        for (message in messages) {
            if (!message.hasClass('alert-error')) {
                error = true;
                break;
            }
        }
        if (!error) {
            window.parent.location.reload();
        }
    });
}