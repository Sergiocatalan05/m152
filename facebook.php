<?php
require_once("./bd/fonctions.php");
$posts = afficherTousLesPosts();


?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>CFPT POST</title>
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
							<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a href="" class="navbar-brand logo">C</a>
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
									<a href="#"><i class="glyphicon glyphicon-home"></i> Home</a>
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
					<!-- /top nav -->
					<div class="padding">
						<div class="full col-sm-9">
							<!-- content -->
							<div class="row">
								<div class="col-sm-7">
									<div class="well">
										<h1>Bienvenue sur CFPT Post</h1>
										<p>Montrer a travers ce reseau social vos inspiration et votre creativité
										</p>
									</div>
									<?php
									foreach ($posts as $post) {
										echo $post->commentaire . "<p></p> <form method='post'> <input type='submit' name ='supprimer$post->idPost' value='Supprimer'> <a href='modificationPost.php?id=".$post->idPost."'>Modification</a></form>";
										$tousLesMedias = afficherLesImagesParId($post->idPost);
										$nbMedia = count($tousLesMedias);
										if($nbMedia == 0){
											if (filter_input(INPUT_POST, "supprimer$post->idPost")) {												
												if(supprimerEtPostImages($post->idPost,$nbMedia)){
													header("Location: facebook.php");
												}
											}
										}
										for ($i = 0; $i < $nbMedia; $i++) {
											
											if (filter_input(INPUT_POST, "supprimer$post->idPost")) {												
												if(supprimerEtPostImages($post->idPost,$nbMedia,$tousLesMedias[$i]->nomFichierMedia)){
													header("Location: facebook.php");
												}
											}

											if ($tousLesMedias[$i]->typeMedia == "video/mp4") {
												echo "<video loop autoplay>  <source src='./upload/" . $tousLesMedias[$i]->nomFichierMedia . "' type='" . $tousLesMedias[$i]->typeMedia . "'/>  </video>";
											} else if ($tousLesMedias[$i]->typeMedia == "image/png" || $tousLesMedias[$i]->typeMedia == "image/jpg" || $tousLesMedias[$i]->typeMedia == "image/jpeg") {
												echo "<img src='./upload/" . $tousLesMedias[$i]->nomFichierMedia . "'>";
											} else if ($tousLesMedias[$i]->typeMedia == "audio/mpeg") {
												echo "<audio controls> <source src='./upload/" . $tousLesMedias[$i]->nomFichierMedia . "' type='" . $tousLesMedias[$i]->typeMedia . "'/> </audio>";
											}
											
										}

									}
									

									?>
								</div>
							</div>
						</div>
						<!--/row-->
					</div><!-- /col-9 -->
				</div><!-- /padding -->
			</div>
			<script type="text/javascript" src="assets/js/jquery.js"></script>
			<script type="text/javascript" src="assets/js/bootstrap.js"></script>
</body>

</html>