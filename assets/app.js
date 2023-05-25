/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/header.scss';
import './styles/proj-header.scss';
import './styles/main.scss';
import './styles/proj-main.scss';
import './styles/library.scss';
import './styles/lucky.scss';
import './styles/flash.scss';
import './styles/card.scss';
import './styles/cardgame.scss';
import './styles/buttons.scss';
import './styles/footer.scss';
import './styles/proj-footer.scss';

// start javaScript
let hello = require('./js/hello.js');

let number = require('./js/number.js');

number.generateCards();
number.randomNumber();

// start the Stimulus application
import './bootstrap';
