const question = document.getElementById("quesiton");
const choices = Array.from(document.getElementsByClassName("answer-text"));
const progressText = document.getElementById("progressText");
const scoreText = document.getElementById("score");
const loading = document.getElementById("loader");
const quiz = document.getElementById("quiz");

let currentQuestion = {};

let acceptingAnswers = false;

let score = 0;

let counter = 0;

let available = [];

const correct_Score = 5;

const num_Question = 10;

//API KEY: oYbaEScTr1LZr32eCHgZMBGzOSJi5pL4oxxZMV6f
//"https://quizapi.io/api/v1/questions6apiKey=oYbaEScTr1LZr32eCHgZMBGzOSJi5pL4oxxZMV6flimit=10"
//question format:
/*[{
        question: question,
        choice1: choices1,
        choice2: choices2,
        choice3: choices3,
        choice4: choices4,
        answer: 1 >> which choise is the answer?
    }
];*/

let url = "https://opentdb.com/api.php?amount=10&category=18&type=multiple";
fetch(url).then(resp => {
    return resp.json();
}).then(apiQuestions => {
    console.log(apiQuestions.results);
    questions = apiQuestions.results.map(apiQuestion => {
        const genratedQuestion = { question: apiQuestion.question };
        genratedQuestion.answer = Math.floor(Math.random() * 4) + 1;
        const choices = [...apiQuestion.incorrect_answers];
        choices.splice(genratedQuestion.answer - 1, 0, apiQuestion.correct_answer);
        choices.forEach((choice, index) => {
            genratedQuestion["choice" + (index + 1)] = choice;
        })
        return genratedQuestion;
    });
    play();

}).catch(err => {
    console.error(err);
});

choices.forEach(choice => {
    choice.addEventListener("click", e => {
        if (!acceptingAnswers) return;

        acceptingAnswers = false;
        const selectedChoice = e.target;
        const selectedAnswer = selectedChoice.dataset["num"];

        const classToApply = selectedAnswer == currentQuestion.answer ? "correct" : "incorrect";

        if (classToApply == "correct") {
            incrementScore(correct_Score);
        }
        selectedChoice.parentElement.classList.add(classToApply);
        setTimeout(() => {
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
    quiz.classList.remove("hidden");
    loading.classList.add("hidden");
};


nextQuestion = () => {
    if (available.length === 0) {
        localStorage.setItem("mostRecentScore", score);
        return window.location.assign("end.html");
    }

    counter++;
    progressText.innerText = `Question ${counter}/${num_Question}`;
    progressBarFull.style.width = `${(counter / num_Question) * 100}%`;

    const selectedIndex = Math.floor(Math.random() * available.length);

    currentQuestion = available[selectedIndex];

    question.innerText = currentQuestion.question;

    choices.forEach(choice => {
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