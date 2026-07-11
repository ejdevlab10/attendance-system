<div class="container mt-5 d-flex justify-content-center">
  <div class="card shadow-lg p-4 text-center" style="max-width: 500px; width: 100%;">
    <h4 class="mb-4">Your QR Code</h4>

    <img id="qrImage"
         src="<?= base_url('images/qrcodes/') . $account['qr_image']; ?>" 
         alt="Your QR Code" 
         class="img-fluid border p-3 mb-3"
         style="width: 100%; height: auto;">

    <a id="downloadBtn" 
       href="<?= base_url('images/qrcodes/') . $account['qr_image']; ?>" 
       download="my_qr_code.png"
       class="btn btn-primary">
      Download QR Code
    </a>
  </div>
</div>
