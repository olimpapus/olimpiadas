<?php

    session_start();

    if (empty($_SESSION['id_user'])) {
        $response = array(
            'success' => false
        );
        header('Content-type: application/json');
        echo json_encode($response);
    }else {
        $response = array(
            'success' => true
        );
        header('Content-type: application/json');
        echo json_encode($response);
    }