self.addEventListener('push', (e) => {
    try {
        // Parse push notification data
        let data = e.data ? e.data.json() : {};

        const options = {
            body: data.body || 'No content available.',
            icon: "https://mohsenfathipour.com/assets/front/img/favicon/64.png",
            data: {
                url: data.url || '/' // Default to home page if URL is not provided
            }
        };

        e.waitUntil(self.registration.showNotification(data.title || 'Notification', options));
    } catch (error) {
        console.error('Push event error:', error);
    }
});

self.addEventListener('notificationclick', (e) => {
    const notification = e.notification;
    const urlToOpen = notification.data?.url;

    e.notification.close(); // Close the notification after click

    if (urlToOpen) {
        e.waitUntil(
            clients.openWindow(urlToOpen).catch((error) => {
                console.error('Error opening window:', error);
            })
        );
    }
});
