<h1><?= $error_title; ?></h1>

<p><?= $message; ?></p>

<script type='text/javascript'>
    setTimeout(function(){
        window.location.href = '/npg'; // Replace '/frontpage' with your actual front page URL
    }, 3000); // 5000 milliseconds = 5 seconds
</script>