<!-- public/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Music Player</title>
  <!-- Add Bootstrap CSS link -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      text-align: center;
      margin: 20px;
    }

    h1 {
      color: #333;
    }

    audio {
      width: 100%;
      max-width: 400px;
      margin: 20px auto;
      display: block;
    }

    ul {
      list-style: none;
      padding: 0;
      display: flex;
      justify-content: center;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
    }

    li {
      margin: 0 10px;
      cursor: pointer;
    }

    li:hover {
      text-decoration: underline;
    }

    div {
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<div class="container">
  <h1 class="mt-5">Music Player</h1>
  <audio id="audioPlayer" controls onended="playNext()">
    <source src="" type="audio/mp3">
    Your browser does not support the audio element.
  </audio>
  <ul id="playlist" class="mt-3">
    <?php
    // Specify the directory path
    $directory = 'music';

    // Get all files in the directory
    $files = scandir($directory);

    // Display each file as a list item
    foreach ($files as $file) {
      // Exclude current directory (.) and parent directory (..)
      if ($file !== "." && $file !== "..") {
        // Provide only the filename without the "Music" prefix
        $escapedFileName = htmlspecialchars($file, ENT_QUOTES, 'UTF-8');
        echo '<li onclick="playSong(\'' . rawurlencode($file) . '\')" class="btn btn-link">' . $escapedFileName . '</li>';
      }
    }
    ?>
  </ul>

  <script>
    // Define playSong function in the global scope
    function playSong(song) {
      const audioPlayer = document.getElementById('audioPlayer');
      audioPlayer.src = `music/${decodeURIComponent(song)}`;
      audioPlayer.play();
      markCurrentSongPlaying(song);
    }

    // Define playNext function in the global scope
    function playNext() {
      const playlist = document.getElementById('playlist');
      const currentSongIndex = Array.from(playlist.children).findIndex(li => li.classList.contains('playing'));

      if (currentSongIndex !== -1 && currentSongIndex < playlist.children.length - 1) {
        const nextSong = playlist.children[currentSongIndex + 1];
        playSong(encodeURIComponent(nextSong.textContent.trim()));
      }
    }

    function markCurrentSongPlaying(song) {
      const playlist = document.getElementById('playlist');
      Array.from(playlist.children).forEach(li => li.classList.remove('playing'));

      const currentSong = Array.from(playlist.children).find(li => {
        return decodeURIComponent(song) === encodeURIComponent(li.textContent.trim());
      });

      if (currentSong) {
        currentSong.classList.add('playing');
      }
    }

    document.addEventListener('DOMContentLoaded', function () {
      // Your other JavaScript code (if any) goes here
    });
  </script>
</div>

<!-- Add Bootstrap JS and Popper.js scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
