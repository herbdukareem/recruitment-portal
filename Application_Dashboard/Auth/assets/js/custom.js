const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, {
      type: 'bar', // Change this to 'line', 'bar', etc. if needed
      data: {
          labels: ['Application Received', 'Users', 'Approved Applicants', 'Employees'], // Your labels
          datasets: [{
              label: 'Count',
              data: [65, 85, 50, 80], // Your data
              backgroundColor: [
                  '#2BC155',
                  '#FF9B52',
                  '#3F9AE0',
                  '#FFC107' // Added color for Users
              ],
              borderColor: [
                   // Added border color for Users
              ],
              borderWidth: 1
          }]
      },
      options: {
          responsive: true, // Make the chart responsive
          plugins: {
              legend: {
                  position: 'top', // Position of the legend
              },
              title: {
                  display: true,
                  text: 'Application Statistics' // Title of the chart
              }
          }
      }
  });