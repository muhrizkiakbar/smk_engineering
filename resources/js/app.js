import './bootstrap';
import $ from 'jquery'
import './library';
import maplibregl from 'maplibre-gl';
import { Chart } from 'chart.js/auto';
import flatpickr from 'flatpickr';

window.$ = $;
window.jQuery = $;
window.jquery = $;
window.flatpickr = flatpickr;
window.maplibregl = maplibregl;

window.Chart = Chart;

$("input[data-type='currency']").on({
    keyup: function () {
        formatCurrency($(this));
    },
    blur: function () {
        formatCurrency($(this), "blur");
    }
});


$(function () {
    flatpickr(".input-date", {
        enableTime: true, // Aktifkan time picker
        dateFormat: "Y-m-d H:i", // Format tanggal
        time_24hr: true // Gunakan format 24 jam
    });

    $('.clear_used_at').click(function () {
        $('input[name="used_at"]').val('');
    })

    $('.clear_bought_at').click(function () {
        $('input[name="bought_at"]').val('');
    })

    $('.clear_tanggal').click(function () {
        $('input[name="tanggal"]').val('');
    })

    flatpickr(".input-date-dialog", {
        enableTime: false,
        appendTo: document.querySelector('#my_modal_5'),
    });

    flatpickr(".input-date-dialog2", {
        enableTime: false,
        appendTo: document.querySelector('#modal_generate'),
    });
})
