<?php require_once("main.php");?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>S.SSingh.Net</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Header -->
			<header id="header">
				<div class="inner">
					<a href="#" class="image avatar"><img src="https://www.ssingh.net/images/slogo.png" alt="" /></a>
					<h1><strong>S.SSingh.Net</strong><br/>A URL Shortener from SSingh.Net</h1>
				</div>
			</header>

		<!-- Main -->
			<div id="main">

				<!-- One -->
					<section id="one">
						<header class="major">
							<center><h1 style="color: #E34444;"><?php echo $errorMsg ?></h1></center>
						</header>
						<form action="/" method="post">
						    <div class="row gtr-uniform gtr-50">
								<div class="col-6 col-12-xsmall">
									<h3>Original Url:</h3><br/>
									<input type="text" name="originUrl" required pattern="https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)" value="<?php echo $_POST['originUrl']; ?>"> 
									<br/><h4><i>(follow https://website.com/ format)</i></h4>
									<br/>
								</div>
								<div class="col-6 col-12-xsmall">
									<h3>Short Url: (alphanumeric characters only)</h3>
									<p>s.ssingh.net/<input type="text" name="shortUrl" required pattern="[a-zA-Z0-9/]+" value="<?php echo $_POST['shortUrl']; ?>"></p> <br />
								</div>
								<div class="col-12">
									<center><input type="submit" value="Create Short Url" /></center>
								</div>
							</div>
						</form>
					</section>

				
			</div>

		<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					<ul class="icons">
						<li><a href="https://github.com/SSinghNet/S.SSingh.Net" class="icon brands fa-github"><span class="label">Github</span></a></li>
					</ul>
					<ul class="copyright">
						<li>&copy; SSingh.Net</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
<?php $conn->close(); ?>