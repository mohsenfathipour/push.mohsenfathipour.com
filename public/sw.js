self.addEventListener('push', (e) => {
    let data = e.data.json();
    const options = {
        body: data.body,
        icon: "https://mohsenfathipour.com/assets/front/img/favicon/64.png",
    data: {
        url: data.url
    }
}
    e.waitUntil(self.registration.showNotification(data.title, options));
});
self.addEventListener('notificationclick', function(e) {
    e.waitUntil(clients.openWindow(e.notification.data.url))
});
