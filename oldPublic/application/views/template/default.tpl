<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>{$title}</title>
		<link rel="stylesheet" href="{base_url()}assets/css/lib/bootstrap.min.css" />
		<link rel="stylesheet" href="{base_url()}assets/css/lib/bootstrap-theme.min.css" />
		<link rel="stylesheet" href="{base_url()}assets/css/lib/font-awesome.min.css" />
		<link rel="stylesheet" href="{base_url()}assets/css/main.css" />
		{foreach from=$cssList item=css}
		 	<link rel="stylesheet" href="{base_url()}assets/css/{$css}" />
		{/foreach}
		<script src="{base_url()}jsCfgGen"></script>
		<script src="{base_url()}assets/js/lib/jquery-3.1.0.min.js"></script>
		<script src="{base_url()}assets/js/lib/bootstrap.min.js"></script>
		<script src="{base_url()}assets/js/main.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		      </button>
		      <a class="navbar-brand" href="{base_url()}">Dev</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li class="active"><a href="{base_url()}">Acceuil <span class="sr-only">(current)</span></a></li>
		        <li><a href="{base_url()}Library">Library</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		</nav>
		<div id="main" class="container-fluid">
			<div class="col-xs-12">

				{$content}
			</div>
		</div>
	{foreach from=$jsList item=js}
	 	<script src="{base_url()}assets/js/{$js}"></script>
	{/foreach}
	</body>
<html>