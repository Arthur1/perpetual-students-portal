<h1 class="orange-text text-darken-2">投票完了</h1>
<p>
	投票完了しました。5秒後にピックジェネレータートップに戻ります。
</p>

<script>
setTimeout(function(){
	location.href = '/vote';
}, 5 * 1000);
</script>