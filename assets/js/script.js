const canvas = document.getElementById('signature-pad');
const ctx = canvas.getContext('2d');

canvas.width = 400;
canvas.height = 150;

let drawing = false;

canvas.addEventListener('mousedown', () => drawing = true);
canvas.addEventListener('mouseup', () => {
  drawing = false;
  ctx.beginPath();
});

canvas.addEventListener('mousemove', draw);

function draw(e) {
  if (!drawing) return;

  ctx.lineWidth = 2;
  ctx.lineCap = 'round';

  ctx.lineTo(e.offsetX, e.offsetY);
  ctx.stroke();
  ctx.beginPath();
  ctx.moveTo(e.offsetX, e.offsetY);
}

function clearSignature() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
}

document.getElementById('pdfForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const signature = canvas.toDataURL();

  const formData = new FormData(this);
  formData.append('signature', signature);

  const response = await fetch('backend/generate-pdf.php', {
    method: 'POST',
    body: formData
  });

  const blob = await response.blob();
  const url = window.URL.createObjectURL(blob);

  document.getElementById('result').innerHTML =
    `<a href="${url}" target="_blank">📥 Download Generated PDF</a>`;
});