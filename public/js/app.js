document.addEventListener('submit', function (e) {
  var pesan = e.target.dataset ? e.target.dataset.confirm : null;
  if (pesan && !window.confirm(pesan)) { e.preventDefault(); }
});
