
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

// Je récupère l'id de mes widget et les classe de mes ul et les stock dans des variables.

let listeRue = document.getElementById("form_adresse_Nom_Rue");
let listeVille = document.getElementById("form_adresse_Nom_Ville");
let listeCP = document.getElementById("form_adresse_CP");
let adressList = document.querySelector(".rue-list");
let villeList = document.querySelector(".ville-list");
let cpList = document.querySelector(".cp-list");

// Je créer une variable qui sera un tableau vide.

let adressDatas = [];

let fetchDatas = async (param) => {

  // Je fais une fonction asyncrone pour utiliser mon api gouv, ici je créer une condition pour faire apparaitre mes listes d'adresses à partir de 4 caractères.

  param.addEventListener("input", async (e) => {
    if (e.target.value.length > 3) {

      // Je stocke dans des variables l'url et les query ("ce qui sera écris dans les input"), j'instancie de la classe URLSearchParams pour spécifier que je cible la valeur de mon input grace au .value.

      const baseUrl = "https://api-adresse.data.gouv.fr/search/"
      const queryParams = new URLSearchParams({
        q: e.target.value
      });

      // Je stocke dans ma variable URL l'url final qui utilisera la base de l'api gouv et les querys.

      const URL = `${baseUrl}?${queryParams}`;
      console.log(URL);

      // J'établi la promesse de récuperer l'url en ajoutant la retranscription en JSON.

      const response = await fetch(URL);
      const data = await response.json();

      // Je vais stocker dans mon tableau le résultat de la recherche.


      adressDatas = data.features;

      // Je rapelle ma fonction renderAdressList avec en paramètres les champs souhaités dans mon formulaire.

      renderAdressList(villeList);
      renderAdressList(adressList);
      renderAdressList(cpList);
    }
  });
};


const renderAdressList = (param) => {
  param.innerHTML = "";
  adressDatas.forEach(({properties}) =>{
    const li = document.createElement("li");
    const p1 = document.createElement("p");

    p1.textContent = properties.city;
    

    li.appendChild(p1);
    li.classList.add("content");
    
    param.appendChild(li);
    console.log(param);

    li.addEventListener("click", (param) =>  {
      param.value = li.textContent;
      
      param.style.display = "none";
      
    });
  });
  param.style.display = "block";
};


fetchDatas(listeRue);
fetchDatas(listeCP);
fetchDatas(listeVille);

// Julien
// Création de la fonction "descriptionClient()" pour la page "templates\add_operation\index.html.twig"
// afin de gérer l'affichage des description client

function descriptionClient(cardId) {
  let descriptionElement = document.getElementById(cardId); // Je vais chercher l'id
  descriptionElement.classList.toggle("d-none"); // Je change le style via les class Bootstrap
}
