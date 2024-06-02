import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

//Mise en place listener pour le l'input file

//if (document.getElementById('band_file') !== null){

if (document.querySelector('.form-control-file') !== null){
//selection de l'input file qui a la classe form-control-file

var fileInput = document.querySelector('.form-control-file');


fileInput.addEventListener('change', function (e) {

const fileInput = e.target;
            const files = fileInput.files;
            if (files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="previewImage" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('imagePreview').innerHTML = '';
            }


});

}
