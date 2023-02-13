<?php
require_once("./bd/fonctions.php");
$commenataire = filter_input(INPUT_POST, "commentaire", FILTER_SANITIZE_STRING);
$publish = filter_input(INPUT_POST, "publish");
$err = "";
$message = "";
$totFileSize = 0;
$PostDejaCreer = false;
$arrayType = array();
define("SIZE_MIN", 3*1024*1024);
define("SIZE_MAX", 70*1024*1024);
if (isset($publish)) {
	if($_FILES['upload']['name'][0]){	
	foreach ($_FILES['upload']['name'] as $key => $value) {
		$file_size = $_FILES['upload']['size'][$key];
		$file_name = $_FILES['upload']['name'][$key];
		$file_tmp = $_FILES['upload']['tmp_name'][$key];
		$file_type = $_FILES['upload']['type'][$key];
		
		if ($file_size <= SIZE_MIN) {
			if ($totFileSize < SIZE_MAX && $err == "") {			
			$totFileSize += $file_size;
			if($PostDejaCreer == false){
            if (ajouterUnePublication($commenataire)) {
				$PostDejaCreer = true;
				$message = "ajout";
			}
		}
		}
			if ($file_type == "image/jpeg" || $file_type == "image/jpg" || $file_type == "image/png") {
				$message = "Votre publication a bien été posté";
				 $idPost = lireId()->idPost;
				 $ext = explode(".", $file_name)[1];
				 $file_name = uniqid(explode(".", $file_name)[0]);
				 
				move_uploaded_file($file_tmp, "./upload/".$file_name.".".$ext);
				ajouterUneImage($file_type,$file_name.".".$ext,$idPost);
			} else {
				$err += "Le fichier: " . $file_name . " n'est pas une image" . "<br>";
			}
		} else {
			$err += "Le fichier" . $file_name . " est trop volumineux" . "<br>";
		}
	}
	$message = $err;	
	
}
}
else {
	ajouterUnePublication($commenataire);
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
											<input type="file" name="upload[]" accept="image/*" multiple>
											<input type="submit" name="publish">
										</form>
										<?= $message ?>
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