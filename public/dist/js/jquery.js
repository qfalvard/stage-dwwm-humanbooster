console.log('jquery.js')

// Autocomplétion dans les champs Select
$('select').select2({
    theme: 'bootstrap4',
});

// Rend impossible la saisie d'une date supérieure à aujourd'hui lors d'une évaluation
if ($('#dateEvaluation').length) {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //Janvier est 0
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }
    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("dateEvaluation").setAttribute("max", today);
}

function acquisitions(id) {
    if ($("#aquisition" + id + " option:selected").val() == 15) {
        $('#commentaire' + id).addClass('hide');
        $('#commentaire' + id).removeAttr('required');
    } else if ($("#aquisition" + id + " option:selected").val() == 5 
            || $("#aquisition" + id + " option:selected").val() == 10) {
        $('#commentaire' + id).removeClass('hide')
        $('#commentaire' + id).attr('required', 'true');
        $('#commentaire' + id).addClass('border-danger');
        $('#commentaire' + id).attr("placeholder", "Commentaire obligatoire");
    } else {
        $('#commentaire' + id).removeClass('hide border-danger');
        $('#commentaire' + id).attr('required', 'false');
        $('#commentaire' + id).attr("placeholder", "Commentaire");
    }
}

// function acquisitions() {

//     let arrayAcquis = document.querySelectorAll('.acquisition')
//     let arrayText = document.querySelectorAll('.textarea')

//     arrayAcquis.forEach(element => {
//         if (element.value == 15){
//             arrayText.forEach(element2 => {
//                 if(element.id == element2.id){
//                     element2.classList.add('hide')
//                     element2.removeAttribute("required")
//                 }
//             })
//         } else if (element.value == 5 || element.value == 10){
//             arrayText.forEach(element2 => {
//                 if (element.id == element2.id) {
//                     element2.classList.remove('hide')
//                     element2.placeholder = "Commentaire obligatoire";
//                     element2.classList.add('border-danger');
//                     element2.required = "true";
//                 }
//             })
//         } else {
//             arrayText.forEach(element2 => {
//                 if (element.id == element2.id) {
//                     element2.classList.remove("hide", "border-danger")
//                     element2.placeholder = "Commentaire";
//                 }
//             })
//         }
//     });
