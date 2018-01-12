<h1 class="orange-text text-darken-1">プロフィール</h1>
<div class="row">
	<div class="col s12 m4">
		<img src="https://pbs.twimg.com/profile_images/936629123765567488/yhndhwmr_400x400.jpg" class="responsive-img circle">
	</div>
	<div class="col s12 m8">
		<dl>
			<dt class="green-text text-darken-1">名前</dt>
			<dd><?= $data['screen_name']; ?></dd>
			<?php if (isset($data['twitter_id'])): ?>
			<dt class="green-text text-darken-1">Twitter</dt>
			<dd><?= Html::anchor('https://twitter.com/'.$data['twitter_id'], '@'.$data['twitter_id'], ['target' => '_blank']); ?></dd>
			<?php endif;?>
			<dt class="green-text text-darken-1">好きな職業</dt>
			<dd><?= $data['favorite_occupations']; ?></dd>
			<dt class="green-text text-darken-1">好きな進歩</dt>
			<dd><?= $data['favorite_improvements']; ?></dd>
			<dt class="green-text text-darken-1">ひとこと</dt>
			<dd><?= nl2br($data['comments']); ?></dd>
		</dl>
	</div>
</div>

<h2 class="green-text text-darken-1">最近のゲーム結果</h2>
<ul class="collection">
	<li class="collection-item">0000/00/00 5人全混ぜ 49点 1位</li>
</ul>