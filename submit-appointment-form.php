<?php
function submit_appointment_form() {
    check_ajax_referer( 'submit_appointment_form', 'nonce' );

    $form_data = $_POST['formData'];

    $name = $form_data['firstName'] . ' ' . $form_data['lastName'];
    $phone = $form_data['phone'];
    $email = $form_data['email'];
    $date = $form_data['date'];
    $time = $form_data['time'];
    $service = $form_data['service'];
    $message = $form_data['message'];

    global $wpdb;
    $database_name = 'hbbuhjstbr'; // Replace with your actual database name
    $table_name = 'appointments'; // Use the table name directly without the prefix

    $wpdb->select($database_name); // Select the specific database

    $data = array(
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'date' => $date,
        'time' => $time,
        'service' => $service,
        'message' => $message
    );

    $wpdb->insert($table_name, $data);

    $to = 'stylishbeautybarsb@gmail.com';
    $subject = 'New Appointment Booked';
    $message = "A new appointment has been booked:\n\n";
    $message .= "Name: $name\n";
    $message .= "Phone: $phone\n";
    $message .= "Email: $email\n";
    $message .= "Date: $date\n";
    $message .= "Time: $time\n";
    $message .= "Service: $service\n";
    $message .= "Message: $message";
    $headers = array(
        'From: WordPress <noreply@stylishbeautybar.com>', // Replace with your WordPress site domain
        'Content-Type: text/plain; charset=UTF-8'
    );
    wp_mail($to, $subject, $message, $headers);

    wp_send_json_success( array( 'message' => 'Appointment submitted successfully.' ) );
}
add_action( 'wp_ajax_submit_appointment_form', 'submit_appointment_form' );
add_action( 'wp_ajax_nopriv_submit_appointment_form', 'submit_appointment_form' );
function create_appointments_table() {
    global $wpdb;
    $database_name = 'hbbuhjstbr'; // Replace with your actual database name
    $table_name = 'appointments'; // Use the table name directly without the prefix
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        email VARCHAR(100) NOT NULL,
        date DATE NOT NULL,
        time TIME NOT NULL,
        service VARCHAR(50) NOT NULL,
        message TEXT NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $wpdb->select($database_name); // Select the specific database
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'create_appointments_table' );