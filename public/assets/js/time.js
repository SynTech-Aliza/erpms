function updateDateTime() {
          // Create a new Date object to get the current date and time
          var now = new Date();

          // Get the individual components of the date and time
          var time = now.toLocaleTimeString(); // Format: HH:MM:SS AM/PM

          // Update the HTML content to display the live date and time
          document.getElementById('time').innerHTML = time;
        }

        // Call updateDateTime function initially to show the date and time immediately
        updateDateTime();

        // Update the date and time every second (1000 milliseconds)
        setInterval(updateDateTime, 1000);