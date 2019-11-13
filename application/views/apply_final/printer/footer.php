</div>
</div>

<br />
<hr/>
<strong><?= lang('get_files_for_app')?></strong>
<br />
<br />

<?
$path   = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=".
base_url()."user/zipapp/".$query['id'];
$file   = file_get_contents($path);
$type   = pathinfo($path, PATHINFO_EXTENSION);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($file);
?>

<img src="<?= $base64 ?>" alt="">





</body>
</html>
