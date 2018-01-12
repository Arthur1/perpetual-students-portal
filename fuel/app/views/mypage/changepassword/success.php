<h1 class="orange-text text-darken-2">パスワード変更完了</h1>
<p>
	パスワードを変更しました。5秒後にログインページに戻ります。
</p>

<script>
setTimeout(function(){
	location.href = '/login';
}, 5 * 1000);
</script>