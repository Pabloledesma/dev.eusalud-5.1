<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Eusalud</title>

	<link href='http://fonts.googleapis.com/css?family=PT+Serif+Caption' rel='stylesheet' type='text/css'>
    <link href="{{ public_path() }}/css/pdf_styles.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="{{ asset('/js/jquery-1.8.3.js') }}"></script>
</head>
<body>
    
    <div class="no_border">
        @yield('content')
    </div>
    
</body>
</html>
