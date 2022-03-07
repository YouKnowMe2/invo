require('./bootstrap');
window.$ = window.jQuery = require('jquery');
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


jQuery(document).ready(function (){
    setTimeout(() =>{
        $('#status_message').slideUp('slow');
    },2000);


    $('#taskFilterBtn').on('click',function(){
        const text = $(this).text();

        if(text == 'Filter'){
            $(this).text('Close');
        }
        if(text == 'Close'){
            $(this).text('Filter');
        }
        $('#taskFilter').slideToggle('slow');
    });
});
