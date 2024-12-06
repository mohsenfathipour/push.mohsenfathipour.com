<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<script>
    navigator.serviceWorker.register('sw.js');

    async function subscribe() {
        let sw = await navigator.serviceWorker.ready;
        let push = await sw.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: '{{ config('app.vapid_public_key') }}'
        });

        let xhr = new XMLHttpRequest();
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        xhr.open('POST', '/admin/savepush', true);
        xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Add CSRF token to the request header
        xhr.send(JSON.stringify({'push': JSON.stringify(push)}));
    }

    function enableNotif() {
        Notification.requestPermission().then(function (permission) {
            if (Notification.permission === 'granted') {
                subscribe();
            }
        });
    }
</script>
<button onclick='enableNotif();' style='font-size: 5rem'>enableNotif</button>
</body>
</html>
