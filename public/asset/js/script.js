document.addEventListener('DOMContentLoaded', () => {


  // Fonction pour gérer le drop des fichiers
  function dropHandler(event) {
    let files = [];
    console.log("Fichiers drop");
    event.preventDefault();

    if (event.dataTransfer.items) {
      [...event.dataTransfer.items].forEach((item, i) => {
        if (item.kind === "file") {
          const file = item.getAsFile();
          console.log(`… file[${i}].name = ${file.name}`);
          files.push(file);
        }
      });
    } else {
      [...event.dataTransfer.files].forEach((file, i) => {
        console.log(`… file[${i}].name = ${file.name}`);
        files.push(file);
      });
    }
    console.log(files);
  }

  // Fonction pour gérer le drag over des fichiers
  function dragOverHandler(event) {
    console.log("Fichiers dans la zone de drop");
    event.preventDefault();
  }

  // Gestion des champs d'adresse
  const listeRue = document.getElementById("form_adresse_Nom_Rue");
  const listeVille = document.getElementById("form_adresse_Nom_Ville");
  const listeCP = document.getElementById("form_adresse_CP");
  const adressList = document.querySelector(".rue-list");
  const villeList = document.querySelector(".ville-list");
  const cpList = document.querySelector(".cp-list");

  let adressDatas = [];

  // Fonction pour récupérer les données d'adresse à partir de l'API
  const fetchDatas = async (inputElement, listElement, renderFunction) => {
    inputElement.addEventListener("input", async (e) => {
      if (e.target.value.length > 3) {
        const baseUrl = "https://api-adresse.data.gouv.fr/search/";
        const queryParams = new URLSearchParams({ q: e.target.value });
        const URL = `${baseUrl}?${queryParams}`;
        console.log(URL);
        const response = await fetch(URL);
        const data = await response.json();
        adressDatas = data.features;
        renderFunction(listElement);
      }
    });
  };

  // Fonction pour rendre la liste des suggestions d'adresses
  const renderAdressList = (listElement) => {
    listElement.innerHTML = "";
    adressDatas.forEach(({ properties }) => {
      const li = document.createElement("li");
      li.textContent = properties.label;
      li.classList.add("content");
      listElement.appendChild(li);
      li.addEventListener("click", () => {
        listeRue.value = properties.name;
        listeVille.value = properties.city;
        listeCP.value = properties.postcode;
        adressList.style.display = "none";
        villeList.style.display = "none";
        cpList.style.display = "none";
      });
    });
    listElement.style.display = "block";
  };

  // Appel de la fonction fetchDatas pour les trois champs d'adresse
  fetchDatas(listeRue, adressList, renderAdressList);
  fetchDatas(listeVille, villeList, renderAdressList);
  fetchDatas(listeCP, cpList, renderAdressList);






  // Fonction pour changer de langue
  // function changeLanguage(locale) {
  //   window.location.href = '/change-language/' + locale;
  // }
});
