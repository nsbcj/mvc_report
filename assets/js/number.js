// javaScript file

'use strict'

module.exports = {
    generateCards: generateCards,
    randomNumber: randomNumber
};

function generateCards(interval=1000, timeout=5000) {
    let numberContainer = document.querySelector(".card-wrapper");

    if (numberContainer) {
        for (let i = 0; i < (timeout / interval); i++) {
            let randomInt = Math.floor(Math.random(0, 1) * 100);

            let newCard = document.createElement("div");

            let newCardNumber = document.createElement("span");

            newCard.classList = "card-number";

            newCardNumber.innerHTML = randomInt;

            newCard.style.position = "absolute";

            numberContainer.append(newCard);

            newCard.append(newCardNumber);
        }
        let luckyNumber = document.querySelector(".lucky");
        luckyNumber.style.backgroundColor = "rgb(223, 192, 27)";
        luckyNumber.style.visibility = "visible";
    }
}

function randomNumber() {
    let generateNumber = () => {
        let cardWrapper = document.querySelector(".card-wrapper");

        let prevAnimation = document.querySelector(".card-animation");

        if (prevAnimation) {
            cardWrapper.removeChild(prevAnimation);
        };

        let cardContainer = document.querySelector(".card-wrapper").lastChild;

        cardContainer.classList = "card-number card-animation";
    };
    let setInter = setInterval(generateNumber, 1000);
    let clearInter = () => {
        let cardWrapper = document.querySelector(".card-wrapper");

        let prevAnimation = document.querySelector(".card-animation");

        clearInterval(setInter);

        cardWrapper.removeChild(prevAnimation);
    };
    setTimeout(clearInter, 6000);
};
