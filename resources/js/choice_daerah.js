$(function() {

    const choices_province_from = new Choices('.select_province.from', {
        searchEnabled: true,
        shouldSort: false,
        removeItemButton: true,
    });
    const choices_province_destination = new Choices('.select_province.destination', {
        searchEnabled: true,
        shouldSort: false,
        removeItemButton: true,
    });

    fetch('https://muhrizkiakbar.github.io/api-wilayah-indonesia/static/api/provinces.json')
        .then(response => response.json())
        .then(data => {
          const formattedChoices = data.map(option => ({
            value: option.id,
            label: option.name,
            selected: false,
          }));

          choices_province_from.setChoices(formattedChoices);
          choices_province_destination.setChoices(formattedChoices);
        })
        .catch(error => console.error('Error loading options:', error));

    const choices_residence_from = new Choices('.select_residence.from', {
        searchEnabled: true,
        shouldSort: false,
        removeItemButton: true,
    });
    const choices_residence_destination = new Choices('.select_residence.destination', {
        searchEnabled: true,
        shouldSort: false,
        removeItemButton: true,
    });

    $('.select_province.from').on('change', function(){
        const province_id = $(this).val(); // Get selected parent ID

        // Clear child choices
        choices_residence_from.clearChoices();

        $.ajax({
          url: `https://muhrizkiakbar.github.io/api-wilayah-indonesia/static/api/regencies/${province_id}.json`, // Replace with your API endpoint
          method: 'GET',
          success: function (data) {
            // Format data for Choices.js
            const childOptions = data.map(item => ({
              value: item.id,
              label: item.name,
            }));

            // Update child dropdown
            choices_residence_from.setChoices(childOptions);
          },
          error: function (error) {
            console.error('Error fetching child options:', error);
          },
        });
    })

    $('.select_province.destination').on('change', function(){
        const province_id = $(this).val(); // Get selected parent ID

        // Clear child choices
        choices_residence_destination.clearChoices();

        $.ajax({
          url: `https://muhrizkiakbar.github.io/api-wilayah-indonesia/static/api/regencies/${province_id}.json`, // Replace with your API endpoint
          method: 'GET',
          success: function (data) {
            // Format data for Choices.js
            const childOptions = data.map(item => ({
              value: item.id,
              label: item.name,
            }));

            // Update child dropdown
            choices_residence_destination.setChoices(childOptions);
          },
          error: function (error) {
            console.error('Error fetching child options:', error);
          },
        });
    })

    const applyDarkMode = () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme == 'dark') {
          const container = $('.choices');
          const choices_item = $('.choices__item')
          const choices_list = $('.choices__list')
          const choices_input = $('.choices__input')
          const choices_search = $('.choices__input.choices__input--cloned')
          const no_choices = $('.choices__item.choices__item--choice.choices__notice.has-no-choices')
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
        }
    };

    // Apply dark mode styles on load
    applyDarkMode();

    // Observe for changes in the dark mode class
    const observer = new MutationObserver(() => {
      applyDarkMode();
    });

    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

})
