<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ciqrcode {

    public function __construct() {
        // Include the phpqrcode library
        include_once(APPPATH.'libraries/phpqrcode/qrlib.php');
    }

    // Method to generate QR code
    public function generate($params) {
        // Default parameters
        $defaults = [
            'data' => '',  // Data to encode
            'level' => 'L',  // Error correction level (L, M, Q, H)
            'size' => 3,  // Size of the QR code
            'savename' => '',  // Save path of the generated QR code
        ];

        // Merge provided params with defaults
        $params = array_merge($defaults, $params);

        // Generate the QR code
        QRcode::png($params['data'], $params['savename'], $params['level'], $params['size']);
    }
}
?>
