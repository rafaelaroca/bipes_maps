<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

<script>
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
 
<?php foreach($css_files as $file): ?>
   
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
 
<style type='text/css'>
body
{
    font-family: Arial;
    font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
    text-decoration: underline;
}
</style>
</head>
<body>
<div>

</div>

    <div style='height:20px;'></div>  
    <div>
<?php echo $output; ?>
 
    </div>


<!-- Beginning footer -->
<div>
<br>

<button onclick="goBack()">Back</button>

<script>
function goBack() {
    window.history.back();
}
</script>

</div>
<!-- End of Footer -->
</body>
</html>
