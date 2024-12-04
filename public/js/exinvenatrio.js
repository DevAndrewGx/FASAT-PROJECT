document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('subirin');
    const alertContainer = document.getElementById('alertContainer');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita el comportamiento por defecto del formulario

        const formData = new FormData(this); // Crea un objeto FormData con los datos del formulario

        fetch('vendor/subirin.php', { // Asegúrate de que esta ruta sea correcta
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Parsear la respuesta como JSON
        .then(data => {
            if (data.success) {
                // Usa SweetAlert2 para mostrar un mensaje de éxito
                Swal.fire({
                    title: 'Éxito',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Refresca la página cuando el usuario haga clic en "OK"
                        window.location.reload();
                    }
                });
            } else {
                // Usa SweetAlert2 para mostrar un mensaje de error
                Swal.fire({
                    title: 'Error',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error en la subida del .',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Refresca la página cuando el usuario haga clic en "OK"
                    window.location.reload();
                }
            });
        });
    });
});
