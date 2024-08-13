<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                500: '#3b82f6', // Example primary color
                            },
                            secondary: {
                                500: '#f59e0b', // Example secondary color
                                700: '#d97706', // Example secondary hover color
                            },
                        },
                    },
                },
            }
        </script>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
