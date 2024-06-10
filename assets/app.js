

import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

// Fonction pour afficher l'image sélectionnée
function displayImage(e) {
    const fileInput = e.target;
    const files = fileInput.files;
    if (files.length > 0) {
        const file = files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = `<img src="${e.target.result}" class="previewImage" alt="Preview"><button type="button" onclick="window.removeImage()">Supprimer image</button>`;
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').innerHTML = '';
    }
}

// Fonction pour supprimer l'image
window.removeImage = function() {
  
    document.querySelector('.form-control-file').value = ''; // Réinitialise l'input file
    document.getElementById('imagePreview').innerHTML = ''; // Supprime le nom de l'image affiché
};

// Vérifie si un input file avec la classe .form-control-file existe
const fileInput = document.querySelector('.form-control-file');
if (fileInput !== null) {
    // Ajoute un écouteur d'événements onchange à l'input file
    fileInput.addEventListener('change', displayImage);
}

//Mise en place listener pour le l'input file

//if (document.getElementById('band_file') !== null){
/*
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
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="previewImage" alt="Preview"><p>${e.target.result}<button type="button" onclick="removeImage">Supprimer</button></p>`;
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('imagePreview').innerHTML = '';
            }


});

        

}*/
/*
function removeImage() {
    console.log('removeImage');

            document.querySelector('.form-control-file').value = ''; // Réinitialise l'input file
            document.getElementById('imagePreview').innerHTML = ''; // Supprime le nom de l'image affiché
        }
*/

//Gestion de la carte leaflet



if (document.getElementById("map") !== null){
    console.log('ok map');
    var mymap = L.map('map').setView([48.7689, 2.09454], 14);
    //ajout de la carte
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(mymap);

//ajout d'un marker

var centerMarker = L.marker([48.7689, 2.09454]).addTo(mymap);





mymap.on('contextmenu', function(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;

    console.log(lat + ', ' + lng);
});


  
}
/*

document.getElementById('map').addEventListener('contextmenu', function (e) {

    e.preventDefault();

var latlng=map.mouseEventToLatLng(e);
  //    var lat = e.latlng.lat;
    //    var lng = e.latlng.lng;

console.log(latlng);


});*/
