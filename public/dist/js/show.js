console.log('show.js')

function hideStag(){
    console.log('stagiaire +')
    document.querySelector('#hideStag').classList.toggle('hide')
}
function hideForm(){
    console.log('formateur +')
    document.querySelector('#hideForm').classList.toggle('hide')
    window.location.hash = $(this).attr("href");
}
function hideEnc(){
    console.log('encadrant +')
    document.querySelector('#hideEnc').classList.toggle('hide')
}

document.addEventListener('DOMContentLoaded', function(){
    document.querySelector('#stag').addEventListener('click', hideStag)
    document.querySelector('#form1').addEventListener('click', hideForm)
    document.querySelector('#form2').addEventListener('click', hideForm)
    document.querySelector('#encadrant').addEventListener('click', hideEnc)
});