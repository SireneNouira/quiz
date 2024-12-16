document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll('[name="answer"]'); // Select all elements whose ID starts with "answer"



  buttons.forEach((button) => {
    button.addEventListener("click", handleAnswerClick);
  });


  

  function handleAnswerClick(event) {
    const button = event.target; // Get the clicked button
 

    const isCorrect = button.getAttribute("data-correct") === "1";


    if (isCorrect) {
      button.classList.add("correct");

    } else {
      button.classList.add("incorrect");
    }

  

    let suivantButton = document.getElementById("suivant-btn");
   
    suivantButton.classList.remove("suivant-btn-off");
    suivantButton.classList.add("suivant-btn-on");

    
  }
});


let scoreElement = document.getElementById('score');

