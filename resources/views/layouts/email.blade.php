<!DOCTYPE html> <html lang="en" xmlns="http://www.w3.org/1999/xhtml" 
xmlns:v="urn:schemas-microsoft-com:vml" 
xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <meta charset="utf-8"> <!-- utf-8 works for most cases -->
        <meta name="viewport" content="width=device-width"> <!-- Forcing 
initial-scale shouldn't be necessary -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use 
the latest (edge) version of IE rendering engine -->
        <meta name="x-apple-disable-message-reformatting"> <!-- Disable 
auto-scale in iOS 10 Mail entirely -->
        <title>Registration Successful!</title>
        <link type="text/css" href="{{ asset('css/email.css') }}" 
rel="stylesheet">
    </head>
    <body width="100%" style="margin: 0; padding: 0 !important; 
mso-line-height-rule: exactly; background-color: #222222;"> <center 
style="width: 100%; background-color: #222222;">
        @yield('content')
    </body>
</html>
