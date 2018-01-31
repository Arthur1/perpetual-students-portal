<h1 class="orange-text text-darken-2">編集完了</h1>
<p>
	評価の編集が完了しました。5秒後にカード詳細ページに戻ります。
</p>

<script>
setTimeout(function(){
	location.href = '/cards/show/<?= $card_id; ?>';
}, 5 * 1000);
</script>