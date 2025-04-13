import Dropzone from "dropzone";
import Swal from 'sweetalert2';

Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#dropzone", {
    dictDefaultMessage: "Arrastra aquí tu imagen",
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar archivo",
    maxFiles: 1,
    uploadMultiple: false,
    maxFilesize: 5, // 2MB máximo
    dictFileTooBig: "La imagen es demasiado grande. Tamaño máximo: 2MB.",
    dictInvalidFileType: "Solo se permiten imágenes (PNG, JPG, JPEG, GIF)",

    //La siguiente función hace que si nos falta algún campo del formulario, no perdamos la imagen que hemos subido.
    init: function() {
        if(document.querySelector('[name="image"]').value.trim()) {
            const publishedImage = {};
            publishedImage.size = 1234;
            publishedImage.name = document.querySelector('[name="image"]').value;

            this.options.addedfile.call(this, publishedImage);
            this.options.thumbnail.call(this, publishedImage, `/uploads/${publishedImage.name}`);

            publishedImage.previewElement.classList.add(
                "dz-success",
                "dz-complete"
            );
        }
    }
});


dropzone.on('success', function(file, response){
    Swal.fire({
        title: '¡Éxito!',
        text: 'La imagen se ha subido correctamente',
        icon: 'success',
        confirmButtonText: 'Ok'
    });
    
    console.log('Respuesta completa:', response);
    console.log('Nombre de la imagen:', response.image);
    
    // Buscar el input o crearlo si no existe
    let imageInput = document.querySelector('[name="image"]');
    if (!imageInput) {
        imageInput = document.createElement('input');
        imageInput.setAttribute('type', 'hidden');
        imageInput.setAttribute('name', 'image');
        document.querySelector('form').appendChild(imageInput);
    }
    imageInput.value = response.image;
});

dropzone.on('error', function(file, message){
    Swal.fire({
        title: '¡Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'Ok'
    });
});

dropzone.on('removedfile', function(){
    // Buscar el input hidden
    const imageInput = document.querySelector('[name="image"]');
    if (imageInput) {
        // Limpiar el valor
        imageInput.value = '';
        console.log('Input hidden vacío:', imageInput.value); // Para debugging
    }
    
    Swal.fire({
        title: 'Archivo eliminado',
        text: 'El archivo se ha eliminado correctamente',
        icon: 'info',
        timer: 2000,
        showConfirmButton: false
    });
});