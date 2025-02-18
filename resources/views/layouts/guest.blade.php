<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
        ])
        @vite([
            'resources/js/app.js',
        ])

        @stack('style')
    </head>
    <body class="min-h-screen flex flex-col bg-base-200 h-full">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-20 bg-base-200">
            <div class="my-5 mx-4">
                <a href="/" class="fill-current text-primary">
                    <img src="{{ asset('storage/utils/adaro_telemetry.svg') }}" alt="Uploaded Image">
                </a>
            </div>

            <main class="w-10/12 ms-4 me-4 justify-center justify-items-center">
                {{ $slot }}
            </main>
        </div>

        @include('layouts.apps.footer')
    </body>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $(function(){
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
        })
    </script>
</html>

