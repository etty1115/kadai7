// script.js
document.getElementById('uploadForm').addEventListener('submit', function(event) {
  event.preventDefault();

  var file = document.getElementById('pdfUpload').files[0];
  var formData = new FormData();
  formData.append('pdf', file);

  fetch('parsePdf.php', {
      method: 'POST',
      body: formData,
  })
  .then(response => response.text())
  .then(text => {
      var downloadLink = document.getElementById('downloadLink');
      downloadLink.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(text);
      downloadLink.style.display = 'block';
  });
});
