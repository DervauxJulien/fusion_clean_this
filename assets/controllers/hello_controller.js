// import { Controller } from '@hotwired/stimulus';

// /*
//  * This is an example Stimulus controller!
//  *
//  * Any element with a data-controller="hello" attribute will cause
//  * this controller to be executed. The name "hello" comes from the filename:
//  * hello_controller.js -> "hello"
//  *
//  * Delete this file or adapt it for your use!
//  */
// export default class extends Controller {
//     connect() {
//         this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
//     }

// }

// document.addEventListener('DOMContentLoaded', () => {
//     function getLog(userId) {
//         localStorage.setItem("log", userId);
//         console.log("tu as clické sur l'utilisateur avec l'ID :", userId);
//     }

//     // Vérifiez que le script est chargé et que l'événement est attaché
//     console.log("Script chargé et écouteurs d'événements ajoutés.");

//     const terminerLinks = document.querySelectorAll('.btn-style');
//     terminerLinks.forEach(link => {
//         link.addEventListener('click', function(event) {
//             event.preventDefault(); // Empêche la navigation par défaut pour le test
//             getLog(this.dataset.userId);
//             // Pour naviguer après le stockage, utilisez:
//             // window.location.href = this.href;
//         });
//     });

//     // Fonctionnalité pour afficher les informations du localStorage
//     // const getLogBtn = document.getElementById('get-log-btn');
//     // const logOutput = document.getElementById('log-output');

//     getLogBtn.addEventListener('click', () => {
//         const storedLog = localStorage.getItem("log");
//         logOutput.textContent = storedLog ? `Log stocké: ${storedLog}` : "Aucun log stocké.";
//     });
// });
