const question = document.getElementById("quesiton");
const choices = Array.from(document.getElementsByClassName("answer-text"));
const progressText = document.getElementById("progressText");
const scoreText = document.getElementById("score");

let currentQuestion = {};

let acceptingAnswers = false;

let score = 0;

let counter = 0;

let available = [];

const correct_Score = 5;

const num_Question = 2;


let questions = [{
        question: "4+4?",
        choice1: "<8>",
        choice2: "<2>",
        choice3: "<1>",
        choice4: "<0>",
        answer: 1
    },
    {
      question: "4-4?",
      choice1: "<8>",
      choice2: "<2>",
      choice3: "<1>",
      choice4: "<0>",
      answer: 4
    },

];


choices.forEach(choice => {
    choice.addEventListener("click", e => {
        if (!acceptingAnswers) return;

        acceptingAnswers = false;
        const selectedChoice = e.target;
        const selectedAnswer = selectedChoice.dataset["num"];

        const classToApply = selectedAnswer == currentQuestion.answer ? "correct" : "incorrect";

        if(classToApply == "correct"){
          incrementScore(correct_Score);
        }
        selectedChoice.parentElement.classList.add(classToApply);
        setTimeout(() =>{
          selectedChoice.parentElement.classList.remove(classToApply);
          nextQuestion();
        }, 1000);

    });
});

play = () => {
    counter = 0;
    score = 0;
    available = [...questions];
    console.log(available);
    nextQuestion();
};


nextQuestion = () => {
    if (available.length === 0) {
        localStorage.setItem("mostRecentScore", score);
        return window.location.assign("/end.html");
    }

    counter++;
    progressText.innerText = `Question ${counter}/${num_Question}`;
    progressBarFull.style.width = `${(counter / num_Question) * 100}%`;

    const selectedIndex = Math.floor(Math.random() * available.length);

    currentQuestion = available[selectedIndex];

    question.innerText = currentQuestion.question;

    choices.forEach(  choice => {
        const number = choice.dataset["num"];
        choice.innerText = currentQuestion["choice" + number];
    });

    available.splice(selectedIndex, 1);
    acceptingAnswers = true;
};

incrementScore = num => {
  score += num;
  scoreText.innerText = score;
};

play();
