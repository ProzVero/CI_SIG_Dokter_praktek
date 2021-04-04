<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Test FCM - Index</title>
	<link href="<?= base_url('sb-admin') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="<?= base_url('sb-admin') ?>/css/sb-admin-2.min.css" rel="stylesheet">
	<link href="<?= base_url('sb-admin') ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-light">

	<div class="container">

		<!-- Outer Row -->
		<div class="row justify-content-center">

			<div class="col-sm-12 col-md-9">

				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
							<div class="col-lg-12">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 bg-gradient-info">
								<div class="p-5">
									<div class="text-center">
										<h2 class="h3 mb-4 text-white">Selamat Datang di Aplikasi Test Firebase Cloud Message</h2>
										<h4 class="h6 mb-4 text-white">Pesan</h4>
									</div>
									<form class="user" method="POST" action="<?= base_url('index/sendNotification') ?>">
										<div class="form-group">
											<input type="text" class="form-control" id="topic" placeholder="Masukkan topic" autocomplete="off" required name="topic">
										</div>
										<div class="form-group">
											<input type="text" class="form-control" id="pesan" placeholder="Masukkan pesan" required name="pesan">
										</div>
						
										<button type="submit" class="btn btn-danger btn-block" name="kirim">
											kirim
										</button>
										<hr>
										<!--<div class="text-center">
											<a class="small" href="forgot-password.html">Forgot Password?</a>
										</div>-->
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>

	</div>

	<script src="<?= base_url('sb-admin') ?>/vendor/jquery/jquery.min.js"></script>
	<script src="<?= base_url('sb-admin') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url('sb-admin') ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
	<script src="<?= base_url('sb-admin') ?>/js/sb-admin-2.min.js"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->

    <script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyC5Df2uIuNa9vEdO4ZatMK3rD36dvhKlSo",
        authDomain: "test-pv-13797.firebaseapp.com",
        projectId: "test-pv-13797",
        storageBucket: "test-pv-13797.appspot.com",
        messagingSenderId: "782373021405",
        appId: "1:782373021405:web:c498f50f29faaf3771dd34"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    </script>
</body>

</html>
