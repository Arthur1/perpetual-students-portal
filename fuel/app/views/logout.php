<h1 class="orange-text text-darken-2">ログアウト</h1>
<p>
	ログアウトが完了しました。5秒後にトップページに戻ります。
</p>

<script>
setTimeout(function(){
	location.href = '/';
}, 5 * 1000);
</script>