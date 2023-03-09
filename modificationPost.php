<?php
require_once("./bd/fonctions.php");
$post = recupereUnPost($_GET['id']);

$media = afficherLesImagesParId($_GET['id']);
$return = $post->commentaire;
$btnModifier = filter_input(INPUT_POST, "modifier");
$comm = filter_input(INPUT_POST, "commentaire");
$err = "";
if ($btnModifier) {
	if ($post != false) {
		$return = "";
		if (isset($comm)) {
			$return = $comm;
		} else {
			$return = $post->commentaire;
		}
		if ($comm != "") {
			modification($_FILES["upload"],$media,$return, $post->idPost);
			header("location: facebook.php");
			exit;
		} else {
			$err = "vous devez mettre un commentaire";
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
	<link href="assets/css/facebook.css" rel="stylesheet">
	<title>Document</title>
</head>

<body>

	<div class="wrapper">
		<div class="box">
			<div class="row row-offcanvas row-offcanvas-left">

				<!-- main right col -->
				<div class="column col-sm-10 col-xs-11" id="main">

					<!-- top nav -->
					<div class="navbar navbar-blue navbar-static-top">
						<div class="navbar-header">

						</div>
						<nav class="collapse navbar-collapse" role="navigation">
							<form class="navbar-form navbar-left">
								<div class="input-group input-group-sm" style="max-width:360px;">
									<input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
									</div>
								</div>
							</form>
							<ul class="nav navbar-nav">
								<li>
									<a href="facebook.php"><i class="glyphicon glyphicon-home"></i> Home</a>
								</li>
								<li>
									<a href="post.php"><i class="glyphicon glyphicon-plus"></i>
										Post</a>
								</li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
									<ul class="dropdown-menu">
										<li><a href="">More</a></li>
										<li><a href="">More</a></li>
										<li><a href="">More</a></li>
										<li><a href="">More</a></li>
										<li><a href="">More</a></li>
									</ul>
								</li>
							</ul>
						</nav>
					</div>

					<div class="padding">
						<div class="full col-sm-9">

							<!-- content -->
							<div class="row">

								<div class="col-sm-7">

									<div class="well">
										<?php
										foreach ($media as $m) {
											if ($m->typeMedia == "video/mp4") {
												echo "<video loop autoplay>  <source src='./upload/" . $m->nomFichierMedia . "' type='" . $m->typeMedia . "'/>  </video>";
											} else if ($m->typeMedia == "image/png" || $m->typeMedia == "image/jpg" || $m->typeMedia == "image/jpeg") {
												echo "<img src='./upload/" . $m->nomFichierMedia . "'>";
											} else if ($m->typeMedia == "audio/mpeg") {
												echo "<audio controls> <source src='./upload/" . $m->nomFichierMedia . "' type='" . $m->typeMedia . "'/> </audio>";
											}
										}
										?>
										<form action="#" method="post" enctype='multipart/form-data'>
											<textarea name="commentaire" cols="60" rows="3"><?php echo $return ?></textarea>
											<input type="file" name="upload[]" accept="image/*, video/*, audio/*" multiple>
											<input type="submit" name="modifier" value="Confirmer">

										</form>
										<? $err ?>
									</div>
								</div>

							</div>
						</div>
						<!--/row-->



					</div><!-- /col-9 -->
				</div><!-- /padding -->
			</div>
		</div>
	</div>

	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
</body>

</html>