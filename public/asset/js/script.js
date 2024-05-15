
function dropHandler(event) {
  
  let files = [];

  console.log("Fichiers drop");

  // Prevent default empèche le fichier de s'ouvrir

  event.preventDefault();

  if (event.dataTransfer.items) {
    // Utilisation de l'interface DataTransferItemList pour accéder aux fichiers
    [...event.dataTransfer.items].forEach((item, i) => {
      // Si les objets drop ne sont pas des fichiers, ils seront rejetés
      if (item.kind === "file") {
        // vérification si l'objet est un fichier
        const file = item.getAsFile(); // création de la variable file avec application de la method getAsFile qui va retourner un objet file si la donnée de l'objet drag est un fichier.
        console.log(`… file[${i}].name = ${file.name}`); // on récupère dans la console le nom du fichier
        files.push(file); // on ajoute au tableau un autre fichier sans écraser celui existant
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
function dragOverHandler(event) {
  console.log("Fichiers dans la zone de drop");

  event.preventDefault();
}

// Stan
// Api gouv

let listeRue = document.getElementById("form_adresse_Nom_Rue");
let listeVille = document.getElementById("form_adresse_Nom_Ville");
let listeCP = document.getElementById("form_adresse_CP");
let adressList = document.querySelector(".rue-list");
let villeList = document.querySelector(".ville-list");
let cpList = document.querySelector(".cp-list");

let adressDatas = [];

let fetchDatas = async () => {
  listeRue.addEventListener("input", async (e) => {
    if (e.target.value.length > 3) {
      const baseUrl = "https://api-adresse.data.gouv.fr/search/"
      const queryParams = new URLSearchParams({
        q: e.target.value
      });
      const URL = `${baseUrl}?${queryParams}`;
      console.log(URL);
      const response = await fetch(URL);
      const data = await response.json();
      adressDatas = data.features;
      renderAdressListRue();
      renderAdressListCp();
      renderAdressListVille();
    }
  });
};

const renderAdressListRue = () => {
  adressList.innerHTML = "";
  adressDatas.forEach(({properties}, index) =>{
    const li = document.createElement("li");
    const p1 = document.createElement("p");

    p1.textContent = properties.name;
    

    li.appendChild(p1);
    li.classList.add("content");

    adressList.appendChild(li);

    li.addEventListener("click", () =>  {
      listeRue.value = li.textContent;
      listeVille.value = properties.city;
      listeCP.value = properties.citycode;
      villeList.style.display = "none";
      cpList.style.display = "none";
      adressList.style.display = "none";
    });
  });
  villeList.style.display = "block";
  cpList.style.display = "block";
  adressList.style.display = "block";
};

const renderAdressListVille = () => {
  villeList.innerHTML = "";
  adressDatas.forEach(({properties}, index) =>{
    const li = document.createElement("li");
    const p1 = document.createElement("p");

    p1.textContent = properties.city;
    

    li.appendChild(p1);
    li.classList.add("content");

    villeList.appendChild(li);

    li.addEventListener("click", () =>  {
      listeVille.value = li.textContent;
      villeList.style.display = "none";
    });
  });
  adressList.style.display = "block";
};

const renderAdressListCp = () => {
  cpList.innerHTML = "";
  adressDatas.forEach(({properties}, index) =>{
    const li = document.createElement("li");
    const p1 = document.createElement("p");

    p1.textContent = properties.citycode;
    

    li.appendChild(p1);
    li.classList.add("content");
 
    cpList.appendChild(li);

    li.addEventListener("click", () =>  {
      listeCP.value = li.textContent;
      cpList.style.display = "none";
    });
  });
  adressList.style.display = "block";
};




fetchDatas();

// Julien
// Création de la fonction "descriptionClient()" pour la page "templates\add_operation\index.html.twig"
// afin de gérer l'affichage des description client

function descriptionClient(cardId) {
  let descriptionElement = document.getElementById(cardId); // Je vais chercher l'id
  descriptionElement.classList.toggle("d-none"); // Je change le style via les class Bootstrap
}
