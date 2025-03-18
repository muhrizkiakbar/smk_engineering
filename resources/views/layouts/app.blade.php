<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Telemetry Adaro') }}</title>
        <link rel="icon" type="image/png" href="https://minioapi.telemetry-adaro.id/adarolaravelproduction/favicon.png">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Popper -->
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <style>
            .my-swal {
                z-index: 100000000000 !important;
            }
            .flatpickr-calendar.open {
                z-index: 999999999999999 !important;
                top: 0;
            }
        </style>
        <!-- Main Styling -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        @vite([
            'resources/css/app.css',
        ])
        @vite('resources/js/app.js')
        @stack('style')

        <!-- Scripts -->
    </head>
    <body class="min-h-screen flex flex-col bg-base-200 h-full">

        @include('layouts.apps.navigation')
        <main class="flex-grow">
            @yield('content')
        </main>
        @include('layouts.apps.footer')
    </body>

    @stack('scripts')

    <script>
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
          $('html').attr('data-theme', savedTheme);
          $('.theme-controller').prop('checked', savedTheme === 'dark');
        } else {
          // Default theme is light if nothing is saved
          $('html').attr('data-theme', 'light');
          $('.theme-controller').prop('checked', false);
        }

        // Listen for checkbox state changes
        $('.theme-controller').change(function () {
          const newTheme = this.checked ? 'dark' : 'light';

          // Apply the new theme by updating the data-theme attribute
          $('html').attr('data-theme', newTheme);

            const container = $('.choices');
            const choices_item = $('.choices__item')
            const choices_list = $('.choices__list')
            const choices_input = $('.choices__input')
            const choices_search = $('.choices__input.choices__input--cloned')
            const no_choices = $('.choices__item.choices__item--choice.choices__notice.has-no-choices')
            if (newTheme == 'dark') {
              if (container) {
                container.addClass('dark');
                choices_item.addClass('dark');
                choices_list.addClass('dark')
                choices_input.addClass('dark')
                choices_search.addClass('dark')

                choices_search.attr('style', function(index, currentStyle) {
                    return (currentStyle || '') + 'background-color: #1d232a !important;';
                });

                no_choices.attr('style', function(index, currentStyle) {
                    return (currentStyle || '') + 'background-color: #1d232a !important;';
                });
              }
            } else {
              if (container) {
                container.removeClass('dark');
                choices_item.removeClass('dark');
                choices_list.removeClass('dark')
                choices_input.removeClass('dark')
                choices_search.removeClass('dark')

                choices_search.attr('style', function(index, currentStyle) {
                    return (currentStyle || '') + 'background-color: #f9f9f9 !important;';
                });

                no_choices.attr('style', function(index, currentStyle) {
                    return (currentStyle || '') + 'background-color: #f9f9f9 !important;';
                });
              }
            }

          // Save the new theme to localStorage
          localStorage.setItem('theme', newTheme);
        });
    </script>
</html>
