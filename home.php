<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vaikuntha</title>
    <link rel="stylesheet" href="styles.css" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
      rel="stylesheet"
    />
  </head>
  
  
  <?php
  $un = $_COOKIE["username"];
  $pp = $_COOKIE["profile_picture"];
  $num = $_COOKIE["unique_number"];
  $eml = $_COOKIE["email"];
  ?>


  
  <body>
    <div class="container">
      <!-- Header Section -->
      <div class="header">
        <div class="logo">Vaikuntha</div>
        <div class="search-bar">
          <input type="text" id="searchInput" placeholder="Search..." onkeyup="searchUser()" />
        </div>
        <div id="searchResults"></div> <!-- Search results will be displayed here -->

        <div class="header-buttons">
          <button id="menu-toggle">Menu</button>
          <button id="profile-toggle">Profile</button>
        </div>
      </div>

      <!-- Main Section -->
      <div class="main">
        <!-- Left Sidebar -->
        <div class="menu" id="menu">
          <ul>
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">Friends</a></li>
            <li><a href="#">Groups</a></li>
            <li><a href="#" onclick="showRequests()">Requests</a></li>
            <li><a href="#">Messages</a></li>
            <li><a href="#">Events</a></li>
          </ul>
          <!-- Settings Button -->
          <div class="settings">
            <a href="#"> <i class="fa fa-cog"></i> Settings </a>
          </div>
        </div>

        <!-- Content Section -->
        <div class="content" id="content">
             <div id="requestsContainer" >
                <div class="request-tabs" style="display: none;">
                    <button id="sentTab" class="active" onclick="showSent()">Sent</button>
                    <button id="receivedTab" onclick="showReceived()">Received</button>
                </div>
                <div id="requestsList">
                      <!-- Sent/Received requests will be displayed here -->
                </div>
            </div>

          <!-- Button to open the post div -->
          <div class="toggle-post-button">
            <button id="togglePost">+</button>
          </div>
          <div class="shown"></div>
          <!-- Overlay to disable other functionality -->
          <div class="overlay" id="overlay" style="display: none"></div>

          <!-- Post section, initially hidden -->
          <div class="post" id="post" style="display: none">
            <div class="post-content">
            <div class="share" id="text-share">
    <form action="">
        <div class="input-container">
            <textarea id="text-input" placeholder="What's on your mind?" rows="1"></textarea>
            <button type="submit" class="send-button">
                <img src="https://cdn-icons-png.flaticon.com/512/1946/1946498.png" alt="Send" />
            </button>
        </div>
    </form>
</div>



              <div class="share" id="content-share">
                <div class="upload" id="image-upload">
                  <label for="imageInput">
                    <img
                      src="https://cdn-icons-png.flaticon.com/512/1829/1829584.png"
                      alt="Upload Image"
                    />
                  </label>
                  <span>Upload Image</span>
                  <input type="file" id="imageInput" accept="image/*" hidden />
                </div>
                <div class="upload" id="video-upload">
                  <label for="videoInput">
                    <img
                      src="https://cdn-icons-png.flaticon.com/512/1829/1829528.png"
                      alt="Upload Video"
                    />
                  </label>
                  <span> upload Video</span>
                  <input type="file" id="videoInput" accept="video/*" hidden />
                </div>
                <div class="upload" id="audio-upload">
                  <label for="audioInput">
                    <img
                      src="https://cdn-icons-png.flaticon.com/512/1829/1829531.png"
                      alt="Upload Audio"
                    />
                  </label>
                  <span>Upload Audio</span>
                  <input type="file" id="audioInput" accept="audio/*" hidden />
                </div>
                <div class="upload" id="document-upload">
                  <label for="documentInput">
                    <img
                      src="https://cdn-icons-png.flaticon.com/512/1829/1829565.png"
                      alt="Upload PDF"
                    />
                  </label>
                  <span>Upload PDF</span>
                  <input
                    type="file"
                    id="documentInput"
                    accept="application/pdf"
                    hidden
                  />
                </div>
              </div>
              <button id="Post">Post</button>
              <button id="closePost">Close</button>
            </div>
          </div>
        </div>

        <!-- Right Sidebar -->
        <div class="profile" id="profile">
          <h3>Your Profile</h3>
          <div class="profile-pic-box">
            <div class="profile-pic">
              <img src="uploads/<?php echo $pp; ?>" alt="Profile Picture" />
            </div>
            <div class="profile-buttom-box">
              <div class="unique number"><h1><?php echo $num; ?></h1></div>
              <div class="profile-pic-edit"></div>
            </div>
          </div>
          <p><strong>Name:</strong> <?php echo $un; ?></p>
          <p><strong>Email:</strong> <?php echo $eml; ?></p>
          <p><strong>Location:</strong> </p>
        </div>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
