<!DOCTYPE html>
<html>
<head>
    <title>{{ config('l5-swagger.documentations.'.$documentation.'.api.title', 'API Documentation') }}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700|Roboto:300,400,700" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div id="redoc"></div>

    <script src="https://cdn.redoc.ly/redoc/latest/bundles/redoc.standalone.js"> </script>
    <script>
        Redoc.init(
            '{{ route("l5-swagger.default.docs") }}',
            {
                theme: {
                    colors: {
                        primary: {
                            main: '#1976d2'
                        }
                    },
                    typography: {
                        fontFamily: 'Montserrat, sans-serif',
                        headings: {
                            fontFamily: 'Montserrat, sans-serif',
                        }
                    }
                }
            },
            document.getElementById('redoc')
        );
    </script>
</body>
</html>
