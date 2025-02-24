<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('l5-swagger.documentations.'.$documentation.'.api.title') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Source+Code+Pro:300,600|Titillium+Web:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ l5_swagger_asset($documentation, 'swagger-ui.css') }}">
    <link rel="icon" type="image/png" href="{{ l5_swagger_asset($documentation, 'favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ l5_swagger_asset($documentation, 'favicon-16x16.png') }}" sizes="16x16"/>
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            background: #fafafa;
        }
    </style>
</head>

<body>
    <div id="redoc-container"></div>
    <script src="https://cdn.jsdelivr.net/npm/redoc@2.0.0-rc.55/bundles/redoc.standalone.min.js"></script>
    <script>
        Redoc.init(
            '{{ route("l5-swagger.{$documentation}.docs", ['format' => 'json']) }}',
            {
                scrollYOffset: 50,
                hideDownloadButton: true,
                expandResponses: '200,201',
                theme: {
                    colors: {
                        primary: {
                            main: '#32329f'
                        }
                    },
                    typography: {
                        fontSize: '16px',
                        fontFamily: 'Roboto, sans-serif',
                        headings: {
                            fontFamily: 'Montserrat, sans-serif'
                        },
                        code: {
                            fontSize: '14px'
                        }
                    },
                    sidebar: {
                        backgroundColor: '#fafafa'
                    }
                }
            },
            document.getElementById('redoc-container')
        );
    </script>
</body>
</html>
