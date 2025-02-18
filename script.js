// Toggle Menu and Profile Sidebar
document.getElementById('menu-toggle').addEventListener('click', () => {
    const menu = document.getElementById('menu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
});

document.getElementById('profile-toggle').addEventListener('click', () => {
    const profile = document.getElementById('profile');
    profile.style.display = profile.style.display === 'block' ? 'none' : 'block';
});
/* add post icon */
// JavaScript to toggle the visibility of the post div
const togglePostButton = document.getElementById("togglePost");
const closePostButton = document.getElementById("closePost");
const postDiv = document.getElementById("post");
const overlay = document.getElementById("overlay");

//text share
const textarea = document.getElementById("text-input");

textarea.addEventListener("input", function () {
    this.style.height = "40px"; // Reset height
    this.style.height = this.scrollHeight + "px"; // Expand dynamically
});



// Function to open the post div and disable the rest of the page
togglePostButton.addEventListener("click", function () {
    postDiv.style.display = "block";
    overlay.style.display = "block";
    document.body.style.overflow = "hidden"; // Prevent scrolling
});

// Function to close the post div and re-enable the page
closePostButton.addEventListener("click", function () {
    postDiv.style.display = "none";
    overlay.style.display = "none";
    document.body.style.overflow = "auto"; // Restore scrolling
});

// Close post and overlay if the user clicks the overlay
overlay.addEventListener("click", function () {
    postDiv.style.display = "none";
    overlay.style.display = "none";
    document.body.style.overflow = "auto";
});


function resizeTextarea(element) {
    element.style.height = "fit-content"; // Reset height
    element.style.height = element.scrollHeight + "px"; // Adjust based on content
  }
  

  // show profile

document.querySelector("#register-form").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch("your-php-endpoint.php", {
            method: "POST",
            body: formData,
        });

        const result = await response.json();

        if (result.status === "success") {
            // Update the profile box
            document.getElementById("profile").innerHTML = `
                <h3>Your Profile</h3>
                <div class="profile-pic-box">
                    <div class="profile-pic">
                        <img src="uploads/${result.data.profile_picture}" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 50%;">
                    </div>
                    <div class="profile-buttom-box">
                        <div class="unique-number">Unique ID: ${result.data.unique_number}</div>
                    </div>
                </div>
                <p><strong>Name:</strong> ${result.data.name}</p>
                <p><strong>Email:</strong> ${result.data.email}</p>
                <p><strong>Location:</strong> ${result.data.location}</p>
            `;
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error("Error:", error);
        alert("An error occurred while registering.");
    }
});
// search user
    function searchUser() {
    let query = document.getElementById("searchInput").value.trim();

    if (query.length === 0) {
        document.getElementById("searchResults").innerHTML = ""; // Clear results if empty
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "searchUser.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("searchResults").innerHTML = xhr.responseText;
        }
    };

    xhr.send("query=" + encodeURIComponent(query));
} 
//request section
// ... (other JavaScript code)

function showRequests() {
    document.getElementById("content").style.display = "none";
    document.getElementById("requestsContainer").style.display = "block";
    showSent(); // Show Sent requests by default
}

function hideRequests() {
    document.getElementById("requestsContainer").style.display = "none";
    document.getElementById("content").style.display = "block";
}


function showSent() {
    getRequests("sent");
}

function showReceived() {
    getRequests("received");
}

function getRequests(type) {
  const requestsList = document.getElementById("requestsList");
  requestsList.innerHTML = "<p>Loading requests...</p>";

  fetch(`getRequests.php?type=${type}`) // Use fetch API
    .then(response => response.json())
    .then(data => {
      if (data.status === "success") {
        requestsList.innerHTML = ""; // Clear loading message
        if (data.requests.length === 0) {
          requestsList.innerHTML = "<p>No requests found.</p>";
        } else {
            const ul = document.createElement('ul');
            data.requests.forEach(request => {
                const li = document.createElement('li');
                li.textContent = request.username; // Display username
                const button = document.createElement('button');
                button.textContent = (type === 'sent') ? 'Cancel' : (type === 'received' ? 'Accept' : 'Decline');
                button.addEventListener('click', () => {
                    // Handle cancel, accept, decline logic here
                    alert(`${type === 'sent' ? 'Cancel' : (type === 'received' ? 'Accept' : 'Decline')} request from ${request.username}`);
                });
                li.appendChild(button);
                ul.appendChild(li);
            });
            requestsList.appendChild(ul);
        }
      } else {
        requestsList.innerHTML = `<p>Error: ${data.message}</p>`;
        console.error(data.message);
      }
    })
    .catch(error => {
      requestsList.innerHTML = "<p>Error fetching requests.</p>";
      console.error("Error:", error);
    });
}


// ... (rest of your JavaScript code)