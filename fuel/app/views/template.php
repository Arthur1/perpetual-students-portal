<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title><?= isset($title) ? $title : ''; ?></title>
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
			<a href="#" class="brand-logo left">ぶらつき学生ポータル</a>
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
			&copy; 2017 Arthur
		</div>
	</div>
</footer>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<?= Asset::js('materialize.min.js'); ?>
<?= Asset::js('footerFixed.js'); ?>
<?= Asset::render('add_js'); ?>
</body>
</html>
