document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', handleFormSubmit);
});

function handleFormSubmit(event) {
    event.preventDefault();

    const formData = new FormData(event.target);

    const firstName = formData.get('firstName');
    const lastName = formData.get('lastName');
    const phone = formData.get('phone');
    const email = formData.get('email');
    const date = formData.get('date');
    const time = formData.get('time');
    const selectedService = formData.get('service');
    const message = formData.get('message');

    const requiredFields = ['firstName', 'lastName', 'phone', 'email', 'date', 'time', 'service', 'message'];

    if (requiredFields.some(field => !formData.get(field))) {
        alert('Please complete all fields to schedule');
        return;
    }

    const data = {
        action: 'submit_appointment_form',
        formData: Object.fromEntries(formData),
        nonce: appointment_form_object.nonce
    };

    jQuery.post(appointment_form_object.ajax_url, data, function(response) {
        if (response.success) {
            console.log(response.data.message);
            event.target.reset();
        } else {
            console.error(response.data.error);
        }
    });
}