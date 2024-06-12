import "./bootstrap.js";

import "./styles/app.css";

//Fonction pour gérer l'affichage des sous-menus

document.addEventListener("DOMContentLoaded", function () {
  var menuItems = document.querySelectorAll(".menu-item > a");

  menuItems.forEach(function (item) {
    item.addEventListener("click", function (event) {
      // Prevent the default link behavior for menu items
      event.preventDefault();

      // Toggle the visibility of the sub-menu
      var subMenu = this.nextElementSibling;
      if (subMenu.classList.contains("sub-menu-visible")) {
        subMenu.classList.remove("sub-menu-visible");
        this.querySelector(".toggle-arrow").innerHTML = "&#9660;";
      } else {
        subMenu.classList.add("sub-menu-visible");
        this.querySelector(".toggle-arrow").innerHTML = "&#9650;";
      }
    });
  });

  var subMenuLinks = document.querySelectorAll(".sub-menu a");
  subMenuLinks.forEach(function (link) {
    link.addEventListener("click", function (event) {
      // Allow default behavior for sub-menu links
      event.stopPropagation();
    });
  });
});

// Fonction pour afficher l'image sélectionnée dans les formulaires groupes/artistes et partenaires
function displayImage(e) {
  const fileInput = e.target;
  const files = fileInput.files;
  if (files.length > 0) {
    const file = files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
      const imagePreview = document.getElementById("imagePreview");
      imagePreview.innerHTML = `<img src="${e.target.result}" class="previewImage" alt="Preview"><button type="button" onclick="window.removeImage()">Supprimer image</button>`;
    };
    reader.readAsDataURL(file);
  } else {
    document.getElementById("imagePreview").innerHTML = "";
  }
}

// Fonction pour supprimer l'affichage de l'image
window.removeImage = function () {
  document.querySelector(".form-control-file").value = ""; // Réinitialise l'input file
  document.getElementById("imagePreview").innerHTML = ""; // Supprime le nom de l'image affiché
};

// Vérifie si un input file avec la classe .form-control-file existe
const fileInput = document.querySelector(".form-control-file");
if (fileInput !== null) {
  // Ajoute un écouteur d'événements onchange à l'input file
  fileInput.addEventListener("change", displayImage);
}

/**********************Gestion de la carte leaflet**********************/

console.log(mapPoints);

if (document.getElementById("map") !== null) {
  console.log("ok map");
  var mymap = L.map("map").setView([48.7689, 2.09454], 14);
  //ajout de la carte
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
  }).addTo(mymap);

  //ajout d'un marker

  var centerMarker = L.marker([48.7689, 2.09454]).addTo(mymap);
  centerMarker.bindPopup("Site du festival").openPopup();

  //ajout de tous les markers avec les coordonnées de mapPoints

  // Ajouter des marqueurs à la carte
  mapPoints.forEach(function (point) {
    let lat = parseFloat(point.latitude);
    let lng = parseFloat(point.longitude);

    var marker = L.marker([lat, lng]).addTo(mymap);
    // Ajouter un popup au marqueur avec titre et description
    marker
      .bindPopup(`<b>${point.title}</b><br>${point.description}`)
      .openPopup();
  });

  mymap.on("contextmenu", function (e) {
    var lat = parseFloat(e.latlng.lat).toFixed(7);
    var lng = parseFloat(e.latlng.lng).toFixed(7);

    console.log(lat + ", " + lng);

    let latInput = document.getElementById("map_point_entity_Latitude");
    let lngInput = document.getElementById("map_point_entity_Longitude");

    latInput.value = lat;
    lngInput.value = lng;
  });
}
