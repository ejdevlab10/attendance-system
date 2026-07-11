<div class="container mt-4" style="max-width: 850px;">
  <h2>Scan QR Code to Record Attendance</h2>
  <div id="reader" style="width: 100%;"></div>
</div>

<!-- SweetAlert2 -->
<script src="<?= base_url('assets/'); ?>js/sweetalert2@11.js"></script>
<!-- html5-qrcode JS -->
<script src="<?= base_url('assets/'); ?>js/html5-qrcode.min.js"></script>

<script>
  // This function will be triggered when a QR code is successfully scanned
  function onScanSuccess(decodedText, decodedResult) {
    // Clear the scanner after successful scan
    html5QrcodeScanner.clear().then(() => {
      // Send the QR result to the server
      fetch("<?= base_url('qr_con/scan_qr') ?>", {
        method: "POST",  // Ensure you are sending a POST request
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ qr_code: decodedText })  // Send the scanned QR code
      })
      .then(response => response.json())
      .then(data => {
        // Show success or error alert based on server response
        Swal.fire({
          icon: data.status === 'success' ? 'success' : data.status === 'info' ? 'info' : 'error',
          title: data.message
        }).then(() => {
          // Restart the scanner after alert is closed
          html5QrcodeScanner.render(onScanSuccess);
        });
      })
      .catch(err => {
        // Handle any errors that occur during the fetch request
        Swal.fire("Error", "Something went wrong while sending the request.", "error");
        // Restart the scanner after error alert
        html5QrcodeScanner.render(onScanSuccess);
      });
    });
  }

  // Initialize the QR scanner
  let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: { width: 500, height: 500 }  // You can adjust size as needed
  });

  // Set the callback function to handle QR code scan success
  html5QrcodeScanner.render(onScanSuccess);
</script>
