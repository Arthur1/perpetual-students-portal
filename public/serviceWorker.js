/*
self.addEventListener('push', function(event) {
	event.waitUntil(
		getEndpoint().then(function(endpoint) {
			console.log(endpoint);
			return fetch('/api/notification/content.json?endpoint=' + endpoint);
		}).then(function(response) {
			if (response.status === 200) {
				return response.json();
			}
			throw new Error('notification api response error');
		}).then(function(response) {
			self.registration.showNotification('ぶらつき学生ポータル', {
				icon: '/assets/icon/android-chrome-144x144',
				body: response.body,
				data: {
					url: response.url
				}
			});
		})
	);
});

self.addEventListener('notificationclick', function(event) {
	event.notification.close();
	var url = '';
	if (event.notification.data.url) {
		url = event.notification.data.url;
	}
	event.waitUntil(
		clients.matchAll({type: 'window'}).then(function() {
			if (clients.openWindow) {
				return clients.openWindow(url)
			}
		})
	);
});*/

self.addEventListener('push', function(event) {
	const data = event.data.json() // payloadで送ったデータの取得

	return event.waitUntil(
		self.registration.showNotification(
			'ぶらつき学生ポータル',
			{
				// ここのデータをevent.notificationで取得する (event.notification.bodyとか)
				icon: data.icon,
				body: data.message,
				data: {
					url: data.url
				}
			}
		)
	);
}, false);

self.addEventListener('notificationclick', function(event) {
	event.notification.close();

	const data = event.notification.data;
	event.waitUntil(clients.matchAll({
		type: 'window'
	}).then(function(clientList) {
		for (var i = 0; i < clientList.length; i++) {
			var client = clientList[i];
			if (client.url === data.url && 'focus' in client) {
				return client.focus();
			}
		}
		if (clients.openWindow) {
			return clients.openWindow(data.url); // $payloadで送ったurlを開く
		}
	}));
});