//  onclick="handleAnswerClick(event, this)"
const buttons = document.querySelectorAll('.reponses');
buttons.addEventListener("click", handleAnswerClick);
console.log(reponse);


function handleAnswerClick(event) {
    event.preventDefault();  // Empêche la soumission du formulaire lors du clic

    // Récupère si la réponse est correcte ou incorrecte
    const isCorrect = button.getAttribute('data-correct') === '1';
console.log(isCorrect);
    // Ajoute la classe appropriée (correct ou incorrect)
    if (isCorrect == true) {
        button.classList.add('correct');
    } else {
        button.classList.add('incorrect');
    }

    // Désactive tous les boutons après le premier clic

    buttons.forEach(b => b.disabled = true);

    // Vous pouvez soumettre le formulaire après un délai pour éviter des actions multiples
    setTimeout(function() {
        button.form.submit();  // Soumet le formulaire
    }, 500);  // Attendre 500ms avant de soumettre
}
