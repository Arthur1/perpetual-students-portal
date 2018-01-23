<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title><?= isset($title) ? $title : ''; ?> - ぶらつき学生ポータル</title>
	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<?= Asset::css('materialize.css'); ?>
	<?= Asset::render('add_css'); ?>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="navbar-fixed">
	<nav>
		<div class="nav-wrapper orange">
			<?= Html::anchor('', 'ぶらつき学生ポータル', ['class' => 'brand-logo left']); ?>
			<a href="#" data-activates="mobile-menu" class="button-collapse right"><i class="material-icons">menu</i></a>
			<ul class="side-nav" id="mobile-menu">
				<li><?= Html::anchor('result/list', 'ゲーム結果'); ?></li>
				<li><?= Html::anchor('profile/list', '部員一覧'); ?></li>
				<li><?= Html::anchor('document', '記事'); ?></li>
				<?php if (Authplus::check([1])): ?>
				<li><?= Html::anchor('mypage', 'マイページ'); ?></li>
				<?php else: ?>
				<li><?= Html::anchor('login', 'ログイン'); ?></li>
				<?php endif; ?>
			</ul>
			<ul class="right hide-on-med-and-down">
				<li><?= Html::anchor('result/list', 'ゲーム結果'); ?></li>
				<li><?= Html::anchor('profile/list', '部員一覧'); ?></li>
				<li><?= Html::anchor('document', '記事'); ?></li>
				<?php if (Authplus::check([1])): ?>
				<li><?= Html::anchor('mypage', 'マイページ'); ?></li>
				<?php else: ?>
				<li><?= Html::anchor('login', 'ログイン'); ?></li>
				<?php endif; ?>
			</ul>
		</div>
	</nav>
</header>
<main class="container">
	<?= isset($contents) ? $contents : ''; ?>
</main>
<footer class="page-footer grey darken-1" id="footer">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<h5 class="white-text">ぶらつき学生ポータル</h5>
				<p class="grey-text text-lighten-4">東京工業大学アグリコラサークル「ぶらつき学生連盟」の公式サイトです。</p>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			&copy; 2018 ぶらつき学生連盟
		</div>
	</div>
</footer>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<?= Asset::js('materialize.min.js'); ?>
<?= Asset::js('footerFixed.js'); ?>
<script type="text/javascript">
$(document).ready(function() {
	$(".button-collapse").sideNav();
});
</script>
<?= Asset::render('add_js'); ?>
</body>
</html>
