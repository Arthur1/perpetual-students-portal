/*
window.addEventListener('load', function() {
	if ('serviceWorker' in navigator) {
		navigator.serviceWorker.register('/serviceWorker.js').then(function(registration) {
			return registration.pushManager.getSubscription().then(function(subscription) {
				if (subscription) {
					return subscription;
				}
				return registration.pushManager.subscribe({
					userVisibleOnly: true
				});
			});
		}).then(function(subscription) {
			var endpoint = subscription.endpoint;
			console.log("pushManager endpoint:", endpoint);
			var post_data = {
				user_id: $('#user_id').text(),
				signature: $('#signature').text(),
				endpoint: endpoint
			};
			$.post(
				'/api/notification/register.json',
				post_data,
				function(data) {
					console.log(data);
				}
			);
		}).catch(function(error) {
			console.warn("serviceWorker error:", error);
		});
	}
});*/


/*navigator.serviceWorker.ready.then(registration => {
	return registration.pushManager.subscribe({
		userVisibleOnly: true,
		applicationServerKey: decodeBase64URL('AIzaSyCK47pos8jrPGmj98DHO1PjDeuMFvANWbM')
	}).then(subscription => {
 		const endpoint = subscription.endpoint;
		const publicKey = encodeBase64URL(subscription.getKey('p256dh'));
		const authSecret = encodeBase64URL(subscription.getKey('auth'));
		let content_encoding;
		if ('supportedContentEncodings' in PushManager) {
			content_encoding =
			PushManager.supportedContentEncodings.includes('aes128gcm') ? 'aes128gcm' : 'aesgcm';
		}
		else {
			content_encoding = 'aesgcm';
		}
		var post_data = {
			user_id: $('#user_id').text(),
			signature: $('#signature').text(),
			endpoint: endpoint,
			public_key: public_key,
			auth_secret: auth_secret,
			content_encoding: content_encoding
		};
		$.post(
			'/api/notification/register.json',
			post_data,
			function(data) {
				console.log(data);
			}
		);
	});
});

const applicationServerPublicKey = '<Your Public Key>';

const pushButton = document.querySelector('.js-push-btn');

let isSubscribed = false;
let swRegistration = null;*/

function urlB64ToUint8Array(base64String) {
	const padding = '='.repeat((4 - base64String.length % 4) % 4);
	const base64 = (base64String + padding)
 		.replace(/\-/g, '+')
		.replace(/_/g, '/');

	const rawData = window.atob(base64);
	const outputArray = new Uint8Array(rawData.length);
	for (let i = 0; i < rawData.length; ++i) {
		outputArray[i] = rawData.charCodeAt(i);
	}
	return outputArray;
}

function encodeBase64URL(buffer) {
  return btoa(String.fromCharCode.apply(null, new Uint8Array(buffer)))
           .replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
}


function register_subscription(subscription) {
	const endpoint = subscription.endpoint;
	const public_key = encodeBase64URL(subscription.getKey('p256dh'));
	const auth_secret = encodeBase64URL(subscription.getKey('auth'));
	let content_encoding;
	if ('supportedContentEncodings' in PushManager) {
		content_encoding =
		PushManager.supportedContentEncodings.includes('aes128gcm') ? 'aes128gcm' : 'aesgcm';
	}
	else {
		content_encoding = 'aesgcm';
	}
	var post_data = {
		user_id: $('#user_id').text(),
		signature: $('#signature').text(),
		endpoint: endpoint,
		public_key: public_key,
		auth_secret: auth_secret,
		content_encoding: content_encoding
	};
	$.post(
		'/api/notification/register.json',
		post_data,
		function(data) {
			console.log(data);
		}
	);
}

var server_key = urlB64ToUint8Array('BBo1HQ-3J_fds91Aot__hNW_Om1qbAXZiKXPixqUTI06mqIsNviisLFeLEYfWxHGZz7QQPCCSglALTzgNLCUCC4');

navigator.serviceWorker.register('serviceWorker.js').then(function (registration) {
    // getSubscription()で登録済みのsubscriptionを取得してみる
    registration.pushManager.getSubscription().then(function (subscription) {
        if (subscription) {
            register_subscription(subscription);
            return;
        }

        // 登録済みのsubscriptionがない場合は新たに登録する
        registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: server_key
        }).then(function (subscription) {
            // Pushサーバに登録できたらsubscriptionをアプリケーションサーバにも登録する
            register_subscription(subscription);
            return;
        })
    });
});