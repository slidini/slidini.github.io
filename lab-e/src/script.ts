const styleLink : HTMLLinkElement = document.createElement('link');
styleLink.rel = 'stylesheet';
styleLink.href = 'public/style-1.css';
document.head.appendChild(styleLink);
let styles : string[];
styles = ['public/style-1.css', 'public/style-2.css', 'public/style-3.css'];

function changeStyles (styleNumber : number) : void{
    if(styleNumber === 0){
        styleLink.href = styles[0];
    }
    if (styleNumber === 1) {
        styleLink.href = styles[1];
    }
    if (styleNumber === 2){
        styleLink.href = styles[2];
    }
}


const footer = document.getElementById("footerContent") as HTMLDivElement;

const buttonFirst = document.createElement('button');
buttonFirst.id = 'firstStyleButton';
buttonFirst.className = 'buttons';
buttonFirst.innerText = '1';

const buttonSecond : HTMLElement = document.createElement('button');
buttonSecond.id = 'secondStyleButton';
buttonSecond.className = 'buttons';
buttonSecond.innerText = '2';

const buttonThird : HTMLElement = document.createElement('button');
buttonThird.id = 'thirdStyleButton';
buttonThird.className = 'buttons';
buttonThird.innerText = '3';

footer.appendChild(buttonFirst);
footer.appendChild(buttonSecond);
footer.appendChild(buttonThird);


buttonFirst.addEventListener('click', (event) => {
    if(event){
        changeStyles(0);
    }
});

buttonSecond.addEventListener('click', (event) => {
    if(event){
        changeStyles(1);
    }
});

buttonThird.addEventListener('click', (event) => {
    if(event){
        changeStyles(2);
    }
});