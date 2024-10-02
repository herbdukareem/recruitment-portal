const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, {
      type: 'bar', // Change this to 'line', 'bar', etc. if needed
      data: {
          labels: ['Application Received', 'Users', 'Approved Applicants', 'Employees'], // Your labels
          datasets: [{
              label: 'Count',
              data: [65, 3000, 5500, 256], // Your data
              backgroundColor: [
                  '#2BC155',
                  '#FF9B52',
                  '#3F9AE0',
                  '#FFC107' // Added color for Users
              ],
              borderColor: [
                  '#fff',
                  '#fff',
                  '#fff',
                  '#fff' // Added border color for Users
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