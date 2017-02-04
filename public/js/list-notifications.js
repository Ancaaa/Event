$(document).ready(function() {

    var updateNotifications = function() {
        var notificationsMenu = $('#notifications-sub-menu');

        var addNotification = function(notification) {
            var dummyElement = $('<div></div>');
            var link = $("<a></a>").attr('href', notification.href);
            link.html(notification.text);
            dummyElement.append(link);

            if (notification.unread) {
                dummyElement.addClass('unreadNotification');
            }

            notificationsMenu.append(dummyElement);
        }

        $.get('/notifications', function(output, idontcare, request) {
            if (request.status === 200) {
                try {
                    var result = JSON.parse(output);

                    // Update Notifications Bubble
                    var count = result.notifications.filter(function(notification) {
                        return notification.unread;
                    }).length;

                    count > 0 ? $('.unread-container').show() : $('.unread-container').hide()
                    $('.unread-number').html(count)

                    // Update Notifications List
                    notificationsMenu.empty();
                    result.notifications.map(addNotification);

                    if (result.notifications.length === 0) {
                        addNotification({
                            text: 'No notifications',
                            href: '#'
                        })
                    }

                } catch(e) {
                    console.error('Could not read notifications.');
                }
            }
        });
    }

    updateNotifications();
    setInterval(updateNotifications, 1000);

    var notificationTrigger = $('#notifications-trigger');
    notificationTrigger.on('mouseenter', function() {
        $.get('/check-notifications', function(data, idontcare, request) {
            updateNotifications();
        });
    });
});
