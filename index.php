<?php

// By DreamWeb:Hosting (Dream Technologies Group doo)

$domain = $_SERVER['HTTP_HOST'];

$json = @file_get_contents("http://public.dreamwebhosting.net/parking/config.json");
$config = json_decode($json, true);

if ($config['dreamweb']) $dreamweb = $config['dreamweb']; else $dreamweb = "http://www.dreamwebhosting.net";	

if ($config['override_header']) $header = @file_get_contents("http://public.dreamwebhosting.net/parking/header.inc.html");
if ($config['override_content']) $content = @file_get_contents("http://public.dreamwebhosting.net/parking/content.inc.html");
if ($config['override_footer']) $footer = @file_get_contents("http://public.dreamwebhosting.net/parking/footer.inc.html");


// Header
// =============================================================

if (!$header)
{
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DreamWeb:Hosting - Under Construction</title>
<style type="text/css">
body {
	background-color: #00375B;
	font-family:Arial, Helvetica, sans-serif;
	font-size:0.95em;
}
img {
	border:0px;
}
.Root {
	margin-top: 90px;
	margin-right: auto;
	margin-left: auto;
	width: 800px;	
}
.Logo {
	display:block;
	position: relative;
	left: -20px;
	padding-bottom: 10px;
}
.Logo img:hover {
	filter:alpha(opacity=80);
	-moz-opacity: 0.80;
	opacity: 0.8;
	
}
.MainBox {
	background-color: #FFF;	
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	-khtml-border-radius: 10px;
	border-radius: 10px;	
	-webkit-box-shadow:0 0 15px #000;
	-moz-box-shadow:0 0 15px  #000;
	box-shadow:0 0 15px #000;
	line-height: 1.5em;
}
h1{
	font-family:  Calibri, Arial, Helvetica, sans-serif;
	font-size:3.2em;
	line-height:0.7em;
	color: #F29200;
	margin-top:5px;
	margin-bottom:25px;
}
h2{
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size:1.7em;
	margin-top:10px;
	margin-bottom:15px;

}
.BoxContent {
	padding: 20px;
	padding-bottom: 5px;
}
.BoxContent ul {
	line-height:30px;
	margin:0px;
	padding-left:25px;
}
.BoxContent a.Link{
	color: #00548C;
	text-decoration:none;
	border-bottom:#F90 dashed 1px;
}
.BoxContent a.Link:hover{
	color: #EC7600;
	text-decoration:none;	
}

.OrangeLight{
	color: #FAA61A;
}
.OrangeDark{
	color: #C85A24;
}
.Footer{
	text-align:right;
	margin-top:10px;
	margin-right:5px;
	color:#CCC;
	font-size:0.9em;
}
.Footer a{
	color:#CCC;
	text-decoration:none;
}
.Footer a:hover{
	color:#FFF;
}
a.Button {
	color:#FFF;
	background-color: #C85A24;
	margin-top: 25px;
	margin-bottom: 10px;
	padding-top: 7px;
	padding-right: 20px;
	padding-bottom: 7px;
	padding-left: 20px;
	text-decoration:none;
	text-align:center;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size:1.3em;
	font-weight:bold;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	-khtml-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow:0 1px 3px #000;
	-moz-box-shadow:0 1px 3px  #000;
	box-shadow:0 1px 3px #000;
	display: block;
	background-image: url(button-background-1.png);
	background-repeat: repeat-x;
}
a.Button:hover {
	color:#FFF;
	background-color: #C85A24;
	background-image: none;
	-webkit-box-shadow:0 1px 6px #000;
	-moz-box-shadow:0 1px 6px  #000;
	box-shadow:0 1px 6px #000;
}
.ImageContainer{
	float: right;
	width:auto;
	height:160px;
}
.ImageDiv{
	position:relative;
	top: -105px;
	padding-left:10px;
}
.ImageDiv img{
	border: 3px #FFF solid;
}
</style>
</head>

<body>
    <div class="Root">
    	<div class="Logo"><a href="<?=$dreamweb?>"><img src="http://public.dreamwebhosting.net/images/dreamwebhosting-logo.png" width="281" height="99" /></a></div>
    	<div class="MainBox">
        
       	  <div class="BoxContent">
            
				<div class="ImageContainer">
	            	<div class="ImageDiv">
	       	    	  <img src="http://public.dreamwebhosting.net/images/parking-image.jpg" width="335" />
                	</div>
            	</div>

                
<?php	

}
else
{
	echo $header;
	
}


// Domain
// =============================================================

echo  "<h2>$domain</h2>";


// Content
// =============================================================

if (!$content)
{
?>

                
           		<h1>Sajt je u pripremi</h1>
                    
              	<p>Ovaj domen je parkiran na <a href="<?=$dreamweb?>" class="Link" target="_blank">DreamWeb</a> hosting serverima, a u vlasništvu je  jednog od DreamWeb:Hosting korisnika.</p>
              	<p>Ovaj domen je samo hostovan na <a href="<?=$dreamweb?>" class="Link" target="_blank">DreamWeb</a> serverima, a samo vlasnik odlučuje da li će i kako domen upotrebiti.</p>
              	<p>Ako ste vlasnik ovog domena, osnovne informacije za postavljanje sajta, kreiranje email adresa i druge operacije nad svojim hosting nalogom i domenom možete naći u našoj <a href="http://go.dreamweb.rs/kb" class="Link" target="_blank">bazi znanja</a>, a za sve dodatne informacije i potrebnu pomoć možete kontaktirati našu <a href="http://go.dreamweb.rs/support" class="Link" target="_blank">tehničku podršku</a>.</p>
    

<?php	

}
else
{
	echo $content;
	
}


// Footer
// =============================================================

if (!$footer)
{
?>

       	  </div>

      </div>
	  <div class="Footer">
			Hosted by <a href="<?=$dreamweb?>" target="_blank">DreamWeb</a>
      </div>
    </div>
</body>
</html>

<?php	

}
else
{
	echo $footer;
	
}

?>