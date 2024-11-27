const labels = Array.from(document.querySelectorAll('label'));
const mismatchedLabels = labels.filter(label => {
  const forAttribute = label.getAttribute('for');
  return forAttribute && !document.getElementById(forAttribute);
});

const data = {
  mismatchedLabels: mismatchedLabels.map(label => ({
    forAttribute: label.getAttribute('for'),
    labelHtml: label.outerHTML
  }))
};
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('gameForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        fetch('gameController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())  // Parse JSON response
        .then(data => {
            alert(data.message);  // Display message
            if (data.next_level) {
                window.location.href = `../views/game.php?level=${data.next_level}`;
            } else if (data.lives !== undefined) {
                document.getElementById('lives').innerText = `Lives remaining: ${data.lives}`;
            } else if (data.game_over) {
                document.getElementById('restartButton').style.display = 'block';
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
