<!DOCTYPE html>
<html lang="ja" prefix="og: http://ogp.me/ns#">
<head>
	<meta charset="UTF-8">
	<title><?= isset($title) ? $title : ''; ?> - ぶらつき学生ポータル</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<?= Asset::css('materialize.css'); ?>
	<?= Asset::render('add_css'); ?>
	<link rel="apple-touch-icon" sizes="152x152" href="/assets/icon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/assets/icon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/assets/icon/favicon-16x16.png">
	<link rel="manifest" href="/assets/icon/manifest.json">
	<link rel="mask-icon" href="/assets/icon/safari-pinned-tab.svg" color="#f59b35">
	<link rel="shortcut icon" href="/assets/icon/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="msapplication-config" content="/assets/icon/browserconfig.xml">
	<meta name="theme-color" content="#ff9800">
	<meta name="keywords" content="アグリコラ,ぶらつき学生連盟,東工大,東京工業大学,ボードゲーム">
	<?= Html::meta('description', isset($description) ? $description : '東京工業大学アグリコラサークル「ぶらつき学生連盟」の公式サイトです。拡張入り旧版アグリコラのプレイ結果を記録しています。'); ?>
	<meta name="author" content="東京工業大学アグリコラサークル「ぶらつき学生連盟」">
	<?php
		$ogp = [
			['property' => 'og:title', 'content' => isset($title) ? $title : ''],
			['property' => 'og:type', 'content' => Uri::string() === '' ? 'website' : 'article'],
			['property' => 'og:url', 'content' => Uri::current()],
			['property' => 'og:site_name', 'content' => 'ぶらつき学生ポータル'],
			['property' => 'og:description', 'content' => isset($description) ? $description : '東京工業大学アグリコラサークルぶらつき学生連盟の公式サイトです。'],
			['property' => 'fb:app_id', 'content' => '196610947765927'],

		];
		if (isset($ogp_image_large))
		{
			$ogp[] = ['property' => 'twitter:card', 'content' => 'summary_large_image'];
			$ogp[] = ['property' => 'og:image', 'content' => Asset::get_file($ogp_image_large, 'img')];
		}
		elseif (isset($ogp_image))
		{
			$ogp[] = ['property' => 'twitter:card', 'content' => 'summary'];
			$ogp[] = ['property' => 'og:image', 'content' => Asset::get_file($ogp_image, 'img')];
		}
		else
		{
			$ogp[] = ['property' => 'twitter:card', 'content' => 'summary'];
			$ogp[] = ['property' => 'og:image', 'content' => Uri::create('assets/icon/apple-touch-icon.png')];
		}
		echo Html::meta($ogp);
	?>
</head>
<body>
<header class="navbar-fixed">
	<nav>
		<div class="nav-wrapper orange">
			<?= Html::anchor('', 'ぶらつき学生ポータル', ['class' => 'brand-logo left']); ?>
			<a href="#" data-activates="mobile-menu" class="button-collapse right"><i class="material-icons">menu</i></a>
			<ul class="side-nav" id="mobile-menu">
				<?php if (Authplus::check([1])): ?>
				<li>
					<div class="user-view">
    					<div class="background">
    						<?= Asset::img('navbg.jpg', ['alt' => 'background']); ?>
						</div>
						<a href="/mypage"><?= Asset::img(Auth::get('icon'), ['class' => 'circle', 'alt' => 'user icon']); ?></a>
						<a href="/mypage"><span class="white-text name"><?= Auth::get('screen_name'); ?></span></a>
						<a href="/mypage"><span class="white-text email"><?= Auth::get_screen_name(); ?></span></a>
  					</div>
				</li>
				<?php else: ?>
				<li><?= Html::anchor('login', '<i class="material-icons">account_circle</i>ログイン'); ?></li>
				<li><div class="divider"></div></li>
				<?php endif; ?>
				<li><?= Html::anchor('result/list', '<i class="material-icons">star_rate</i>ゲーム結果'); ?></li>
				<li><?= Html::anchor('profile/list', '<i class="material-icons">people</i>部員一覧'); ?></li>
				<li><?= Html::anchor('cards/list', '<i class="material-icons">find_in_page</i>カード一覧'); ?></li>
				<li><?= Html::anchor('ranking', '<i class="material-icons">assessment</i>統計'); ?></li>
				<li><?= Html::anchor('document', '<i class="material-icons">description</i>記事'); ?></li>
				<?php if (Authplus::check([1])): ?>
				<li><div class="divider"></div></li>
				<li><?= Html::anchor('mypage', 'マイページ'); ?></li>
				<?php endif; ?>
			</ul>
			<ul class="right hide-on-med-and-down">
				<li><?= Html::anchor('result/list', 'ゲーム結果'); ?></li>
				<li><?= Html::anchor('profile/list', '部員一覧'); ?></li>
				<li><?= Html::anchor('cards/list', 'カード一覧'); ?></li>
				<li><?= Html::anchor('ranking', '統計'); ?></li>
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
