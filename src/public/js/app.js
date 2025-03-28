// Configuración de DataTables
$(document).ready(function() {
    $('.datatable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']]
    });
});

// Función para mostrar notificaciones
function showNotification(title, message, type = 'success') {
    Swal.fire({
        title: title,
        text: message,
        icon: type,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

// Función para confirmar acciones
function confirmAction(title, text, callback) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

// Función para manejar errores de formularios
function handleFormError(errors) {
    Object.keys(errors).forEach(key => {
        const input = document.querySelector(`[name="${key}"]`);
        if (input) {
            input.classList.add('border-red-500');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-red-500 text-sm mt-1';
            errorDiv.textContent = errors[key];
            input.parentNode.appendChild(errorDiv);
        }
    });
}

// Función para limpiar errores de formularios
function clearFormErrors() {
    document.querySelectorAll('.border-red-500').forEach(input => {
        input.classList.remove('border-red-500');
        const errorDiv = input.parentNode.querySelector('.text-red-500');
        if (errorDiv) {
            errorDiv.remove();
        }
    });
}

// Función para formatear moneda
function formatCurrency(amount) {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'EUR'
    }).format(amount);
}

// Función para formatear fecha
function formatDate(date) {
    return new Intl.DateTimeFormat('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(new Date(date));
}

// Exportar funciones para uso global
window.showNotification = showNotification;
window.confirmAction = confirmAction;
window.handleFormError = handleFormError;
window.clearFormErrors = clearFormErrors;
window.formatCurrency = formatCurrency;
window.formatDate = formatDate; 