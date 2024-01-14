import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aqui tu imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    //Funcion que inicializa dropzon
    init: function () {
        if (document.querySelector('[name="imagen"]').value.trim()) {
            const imagenPublicada = {}
            imagenPublicada.size = 1234;
            imagenPublicada.name =
                document.querySelector('[name="imagen"]').value;

            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            imagenPublicada.previewElement.classList.add(
                "dz-success",
                "dz-complete"
            )
        }
    },
});

// dropzone.on('sending', function(file, xhr, formData){
//     console.log(file)
// });
// // SI SE ENVIO CORRECTAMENTE
dropzone.on('success', function (file, response) {
    document.querySelector('[name="imagen"]').value = response.imagen;
})



// //EN CASO OCURRE UN ERROR
// dropzone.on('error', function(file, message){
//     console.log(message)
// })

// //EN CASO SE REMUEVE EL ARCHIVO(ELIMINA)
dropzone.on('removedfile', function () {
    document.querySelector('[name="imagen"]').value ="";
})