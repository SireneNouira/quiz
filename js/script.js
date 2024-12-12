document.addEventListener("DOMContentLoaded", () => {
    const questions = document.querySelectorAll(".question");
    let currentQuestionIndex = 0;

    questions[currentQuestionIndex].classList.add("active");

    document.querySelector("#next-btn").addEventListener("click", () => {
        questions[currentQuestionIndex].classList.remove("active");
        currentQuestionIndex++;
        if (currentQuestionIndex < questions.length) {
            questions[currentQuestionIndex].classList.add("active");
        } else {
            window.location.href = "results.php";
        }
    });

    document.querySelectorAll("li").forEach((li) => {
        li.addEventListener("click", () => {
            if (li.dataset.correct === "1") {
                li.classList.add("correct");
            } else {
                li.classList.add("incorrect");
                li.parentElement.querySelector('[data-correct="1"]').classList.add("correct");
            }
        });
    });
});
let score = 0;

document.querySelectorAll("li").forEach((li) => {
    li.addEventListener("click", () => {
        if (li.dataset.correct === "1") {
            li.classList.add("correct");
            score += 10;
        } else {
            li.classList.add("incorrect");
            li.parentElement.querySelector('[data-correct="1"]').classList.add("correct");
        }
    });
});

// Envoie du score à la fin du quiz
document.querySelector("#next-btn").addEventListener("click", () => {
    if (currentQuestionIndex === questions.length - 1) {
        window.location.href = `results.php?quiz_id=1&score=${score}`;
    }
});
