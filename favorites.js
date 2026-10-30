// SVG icons used across the page
const heartSVG = `<svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>`;
const playSVG  = `<svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>`;
const imgSVG   = `<svg viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>`;
// Returns a heart button that removes the card when clicked
function heartBtn() {
  return `<button class="heart-btn" onclick="removeCard(this)">${heartSVG}</button>`;
}
// Add 22 video cards to the video row
const videoRow = document.getElementById('videoRow');
for (let i = 0; i < 22; i++) {
  const card = document.createElement('div');
  card.className = 'video-card';
  card.innerHTML = `<div class="play-circle">${playSVG}</div>${heartBtn()}`;
  videoRow.insertBefore(card, document.getElementById('emptyVideo'));
}
// Add 12 tool cards to the tools row
const toolRow = document.getElementById('toolRow');
for (let i = 0; i < 12; i++) {
  const card = document.createElement('div');
  card.className = 'tool-card';
  card.innerHTML = `<div class="img-placeholder">${imgSVG}</div>${heartBtn()}`;
  toolRow.insertBefore(card, document.getElementById('emptyTool'));
}
// Remove a card with animation, show empty message if no cards are left
function removeCard(btn) {
  const card = btn.closest('.video-card, .tool-card');
  const row  = card.closest('.cards-row');
  card.classList.add('removing');
  setTimeout(() => {
    card.remove();
    if (!row.querySelectorAll('.video-card, .tool-card').length) {
      row.querySelector('.empty-row').classList.add('on');
    }
  }, 380);
}