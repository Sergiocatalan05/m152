<?php
require_once("./bd/fonctions.php");
$commenataire = filter_input(INPUT_POST, "commentaire");
$publish = filter_input(INPUT_POST, "publish");
$err = "";
$totFileSize = 0;
$PostDejaCreer = false;
$arrayType = array();
define("SIZE_MIN", 3 * 1024 * 1024);
define("SIZE_MAX", 70 * 1024 * 1024);

if ($publish != null) {
	if ($_FILES['upload']['name'][0] != null) {
		$err = verifFichier($_FILES);
		if ($err == "") {
			foreach ($_FILES['upload']['name'] as $key => $value) {

				$file_name = $_FILES["upload"]['name'][$key];
				$file_type = $_FILES["upload"]['type'][$key];
				$file_tmp = $_FILES["upload"]['tmp_name'][$key];

				if ($PostDejaCreer == false) {
					if (ajouterUnePublication($commenataire)) {
						$PostDejaCreer = true;
					}
				}
						$err= $file_type;
				$idPost = lireId()->idPost;
				$ext = explode(".", $file_name)[1];
				$file_name = uniqid(explode(".", $file_name)[0]);

				if (move_uploaded_file($file_tmp, "./upload/" . $file_name . "." . $ext)) {

					if (!ajouterUneImage($file_type, $file_name . "." . $ext, $idPost)) {
						unlink($file_name . "." . $ext);
					}
				}
			}

			 header("Location: facebook.php");
			 exit;
		}
	} else {
		ajouterUnePublication($commenataire);

		header("Location: facebook.php");
		exit;
	}
}



function verifFichier($fichier)
{
	$typeValide = array("image/jpeg", "image/jpg", "image/png", "video/mp4", "video/m4v", "audio/mpeg", "audio/mp3", "audio/wav", "audio/ogg");
	$err = "";
	$totalSize = 0;
	$nbFichier = count($fichier['upload']['name']);
	for ($i = 0; $i < $nbFichier; $i++) {
		$file_type = $fichier["upload"]['type'][$i];
		$file_size = $fichier["upload"]['size'][$i];

		$totalSize += $file_size;
		if ($file_size > SIZE_MIN) {
			$err .= "Le fichier " . $_FILES["upload"]["name"] . " est trop volumineux.";
		}
		if (!in_array($file_type, $typeValide)) {
			$err .= "le fichier selectioné n'est pas fonctionnel";
		}
		if ($totalSize > SIZE_MAX) {
			$err .= "Les fichiers sont trop volumineux";
		}
	}
	return $err;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Facebook Theme Demo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
	<link href="assets/css/facebook.css" rel="stylesheet">
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
										<form action="#" method="post" enctype='multipart/form-data'>
											<textarea name="commentaire" cols="60" rows="3"></textarea>
											<input type="file" name="upload[]" accept="image/*, video/*, audio/*" multiple>
											<input type="submit" name="publish">
										</form>
										<p>
											<?= $err ?>
										</p>
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