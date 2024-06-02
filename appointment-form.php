<?php
/*
Plugin Name: Appointment Form
Description: A plugin to add an appointment form to your WordPress site.
Version: 1.0
Jacob Broussard
https://Jacobsjob.com
*/

include_once 'submit-appointment-form.php';

function enqueue_appointment_scripts() {
    wp_enqueue_script( 'appointment-form', plugin_dir_url( __FILE__ ) . 'appointment-form.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'appointment-form', 'appointment_form_object', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'submit_appointment_form' )
    ) );
    
    wp_enqueue_style( 'appointment-form-style', plugin_dir_url( __FILE__ ) . 'appointment-form.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_appointment_scripts' );

function appointment_form_shortcode() {
    ob_start();
    ?>
    <style>
        #appointment-form {
    max-width: 500px;
    margin: 0 auto;
}

#appointment-form label {
    display: block;
    margin-bottom: 10px;
}

#appointment-form input[type="text"],
#appointment-form input[type="tel"],
#appointment-form input[type="email"],
#appointment-form input[type="date"],
#appointment-form input[type="time"],
#appointment-form select,
#appointment-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

#appointment-form button[type="submit"] {
    background-color: pink;
    color: black;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
}

#appointment-form button[type="submit"]:hover {
    background-color: #45a049;
    color: white;
}</style>
    <form id="appointment-form">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required>

        <label for="service">Service:</label>
        <select id="service" name="service" required>
            <option value="" disabled selected>Select a Service</option>
            <option value="hair">Hair</option>
            <option value="facial">Facial</option>
            <option value="waxing">Waxing</option>
            <option value="eyebrows">Eyebrows</option>
            <option value="eyelashes">Eyelashes</option>
            <option value="henna">Henna</option>
        </select>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Book Appointment</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('appointment_form', 'appointment_form_shortcode');