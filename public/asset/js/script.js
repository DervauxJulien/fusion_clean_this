let files = [];

function dropHandler(event) {
    console.log("Fichiers drop");
  
    // Prevent default empèche le fichier de s'ouvrir
    
    event.preventDefault();
  
    if (event.dataTransfer.items) {
      // Utilisation de l'interface DataTransferItemList pour accéder aux fichiers
      [...event.dataTransfer.items].forEach((item, i) => {
        // Si les objets drop ne sont pas des fichiers, ils seront rejetés
        if (item.kind === "file") {                           // vérification si l'objet est un fichier
          const file = item.getAsFile();                      // création de la variable file avec application de la method getAsFile qui va retourner un objet file si la donnée de l'objet drag est un fichier.
          console.log(`… file[${i}].name = ${file.name}`);    // on récupère dans la console le nom du fichier
          files.push(file);                                   // on ajoute au tableau un autre fichier sans écraser celui existant
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

  function descriptionClient(cardId) {
    let descriptionElement = document.getElementById(cardId);
    console.log(descriptionElement);
    descriptionElement.classList.toggle("d-none");
}




