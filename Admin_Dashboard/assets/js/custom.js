const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, {
      type: 'bar', // Change this to 'line', 'bar', etc. if needed
      data: {
        // labels: [
        //     "AC",   // Administrative Cadre
        //     "EOC",  // Executive Officer Cadre
        //     "COC",  // Clerical Officer Cadre
        //     "SC",   // Secretarial Cadre
        //     "SAC",  // Secretarial Assistant Cadre
        //     "P",    // Porter
        //     "OAC",  // Office Assistant Cadre
        //     "ACC",  // Accountant Cadre
        //     "EOAC", // Executive Officer (Accounts) Cadre
        //     "SOC",  // Stores Officers' Cadre
        //     "SA",   // Store Attendant
        //     "IAC",  // Internal Auditors' Cadre
        //     "EOA",  // Executive Officer (Audit) Cadre
        //     "IOC",  // Information Officer Cadre
        //     "POC",  // Protocol Officer Cadre
        //     "PC",   // Photographer Cadre
        //     "VCOC", // Video Camera Operator Cadre
        //     "IAC",  // Information Assistant Cadre
        //     "EOIC", // Executive Officer (Information) Cadre
        //     "DC",   // Doctors Cadre
        //     "PC",   // Pharmacists Cadre
        //     "NOC",  // Nursing Officer Cadre
        //     "PTC",  // Pharmacy Technician Cadre
        //     "MLTC", // Medical Laboratory Technologist Cadre
        //     "MLTC", // Medical Laboratory Technician Cadre
        //     "MLAC", // Medical Laboratory Assistant Cadre
        //     "HRO",  // Health Records Officer
        //     "EHOC", // Environmental Health Officer Cadre
        //     "VOC",  // Veterinary Officer Cadre
        //     "LOC",  // Legal Officer Cadre
        //     "LBOC", // Library Officer Cadre
        //     "LAC",  // Library Assistant Cadre
        //     "BOC",  // Bindery Officers' Cadre
        //     "BAC",  // Bindery Assistant Cadre
        //     "DOIC", // Data Operator/I.T. Operator Cadre
        //     "DAC",  // Data Analyst Cadre
        //     "CEEC", // Computer Electronics Engineer Cadre
        //     "SPAC", // Systems Programmer/Analyst Cadre
        //     "D-COMSIT", // Director, COMSIT
        //     "ENGC", // Engineer Cadre
        //     "ARC",  // Architect Cadre
        //     "QSC",  // Quantity Surveyor Cadre
        //     "PPU",  // Physical Planning Unit
        //     "MO",   // Maintenance Officer
        //     "WASC", // Workshop Attendant/Assistant/Superintendent Cadre
        //     "DC",   // Driver Cadre
        //     "DMC",  // Driver/Mechanic Cadre
        //     "CMC",  // Craftsman (Carpentry & Mason, Welding, Plumbing, Electrical, R&G, Mechanical, etc.)
        //     "TOC",  // Technical Officer Cadre
        //     "AC",   // Artisan/Craftsman
        //     "PSOC", // Power Station Operator Cadre
        //     "HGC",  // Horticulturist Cadre (Parks & Gardens)
        //     "EOC",  // Estate Officers' Cadre
        //     "GSC",  // Gardening Staff (Biological and Parks & Gardens Units)
        //     "TKC",  // Turnstile Keeper Cadre
        //     "ZKC",  // Zoo Keeper Cadre
        //     "CC",   // Curator Cadre
        //     "FOM",  // Farm Officer/Manager
        //     "AAFC", // Agricultural/Animal Health/Forestry Superintendent Cadre
        //     "FLS",  // Farm/Livestock Supervisor
        //     "TC",   // Technologist Cadre
        //     "LS",   // Laboratory Supervisor
        //     "SSC1", // Staff School Cadre I (Lower Basic)
        //     "SSC2", // Staff School Cadre II (Upper Basic)
        //     "SC",   // Security Cadre
        //     "POC",  // Planning Officer Cadre
        //     "CC",   // Coach Cadre
        //     "C-SIWES", // Coordinator Cadre (SIWES)
        //     "CC",   // Counsellor Cadre
        //     "SIC",  // Signer (Interpreter) Cadre
        //     "AAC",  // Archives Assistant Cadre
        //     "AOC",  // Archives' Officer Cadre
        //     "ARC",  // Archivist Cadre
        //     "GAAC", // Graphic Arts Assistant Cadre
        //     "GAOC", // Graphic Arts Officers' Cadre
        //     "CSCOC", // Cook/Steward/Catering Officer Cadre
        //     "LC",   // Laundry Cadre
        //     "FC",   // Fireman Cadre
        //     "FSC",  // Fire Superintendent Cadre - 120
        //     "FOC"   // Fire Officer Cadre - 122
    // ],
         // Your labels
         labels: [
                "Administrative Cadre",
                "Executive Officer Cadre",
                "Clerical Officer Cadre",
                "Secretarial Cadre",
                "Secretarial Assistant Cadre",
                "Porter",
                "Office Assistant Cadre",
                "Accountant Cadre",
                "Executive Officer (Accounts) Cadre",
                "Stores Officers' Cadre",
                "Store Attendant",
                "Internal Auditors' Cadre",
                "Executive Officer (Audit) Cadre",
                "Information Officer Cadre",
                "Protocol Officer Cadre",
                "Photographer Cadre",
                "Video Camera Operator Cadre",
                "Information Assistant Cadre",
                "Executive Officer (Information) Cadre",
                "Doctors Cadre",
                "Pharmacists Cadre",
                "Nursing Officer Cadre",
                "Pharmacy Technician Cadre",
                "Medical Laboratory Technologist Cadre",
                "Medical Laboratory Technician Cadre",
                "Medical Laboratory Assistant Cadre",
                "Health Records Officer",
                "Environmental Health Officer Cadre",
                "Veterinary Officer Cadre",
                "Legal Officer Cadre",
                "Library Officer Cadre",
                "Library Assistant Cadre",
                "Bindery Officers' Cadre",
                "Bindery Assistant Cadre",
                "Data Operator/I.T. Operator Cadre",
                "Data Analyst Cadre",
                "Computer Electronics Engineer Cadre",
                "Systems Programmer/Analyst Cadre",
                "Director, COMSIT",
                "Engineer Cadre",
                "Architect Cadre",
                "Quantity Surveyor Cadre",
                "Physical Planning Unit",
                "Maintenance Officer",
                "Workshop Attendant/Assistant/Superintendent Cadre",
                "Driver Cadre",
                "Driver/Mechanic Cadre",
                "Craftsman (Carpentry & Mason, Welding, Plumbing, Electrical, R&G, Mechanical, etc.)",
                "Technical Officer Cadre",
                "Artisan/Craftsman",
                "Power Station Operator Cadre",
                "Horticulturist Cadre (Parks & Gardens)",
                "Estate Officers' Cadre",
                "Gardening Staff (Biological and Parks & Gardens Units)",
                "Turnstile Keeper Cadre",
                "Zoo Keeper Cadre",
                "Curator Cadre",
                "Farm Officer/Manager",
                "Agricultural/Animal Health/Forestry Superintendent Cadre",
                "Farm/Livestock Supervisor",
                "Technologist Cadre",
                "Laboratory Supervisor",
                "Staff School Cadre I (Lower Basic)",
                "Staff School Cadre II (Upper Basic)",
                "Security Cadre",
                "Planning Officer Cadre",
                "Coach Cadre",
                "Coordinator Cadre (SIWES)",
                "Counsellor Cadre",
                "Signer (Interpreter) Cadre",
                "Archives Assistant Cadre",
                "Archives' Officer Cadre",
                "Archivist Cadre",
                "Graphic Arts Assistant Cadre",
                "Graphic Arts Officers' Cadre",
                "Cook/Steward/Catering Officer Cadre",
                "Laundry Cadre",
                "Fireman Cadre",
                "Fire Superintendent Cadre - 120",
                "Fire Officer Cadre - 122"

            ],
         datasets: [{
              label: 'Count',
              data: [
                65, 89, 42, 17, 76, 12, 34, 98, 56, 3, 91, 44, 22, 77, 5, 64, 99, 11, 85, 9, 
                27, 70, 58, 36, 48, 73, 92, 18, 60, 8, 67, 51, 21, 43, 37, 15, 82, 94, 40, 66, 
                23, 49, 30, 84, 6, 53, 19, 72, 96, 13, 39, 88, 28, 7, 57, 47, 32, 63, 79, 1, 
                74, 25, 4, 50, 62, 14, 45, 33, 61, 80, 2, 71, 55, 24, 31, 10, 78, 35, 59
            ], // Your data
              backgroundColor: [
                '#2BC155', '#FF9B52', '#3F9AE0', '#FFC107', '#8E44AD', '#E74C3C', '#3498DB', 
                '#1ABC9C', '#F39C12', '#9B59B6', '#34495E', '#2ECC71', '#16A085', '#F1C40F', 
                '#E67E22', '#E74C3C', '#7D3C98', '#A569BD', '#EC7063', '#5DADE2', '#48C9B0', 
                '#F5B041', '#58D68D', '#DC7633', '#F1948A', '#AAB7B8', '#2874A6', '#1F618D', 
                '#17A589', '#B7950B', '#CB4335', '#5B2C6F', '#F8C471', '#52BE80', '#AF7AC5', 
                '#76448A', '#C0392B', '#1A5276', '#1ABC9C', '#D4AC0D', '#C0392B', '#F1C40F', 
                '#E59866', '#7FB3D5', '#73C6B6', '#F7DC6F', '#5499C7', '#45B39D', '#F0B27A', 
                '#E74C3C', '#2980B9', '#27AE60', '#D35400', '#F7F9F9', '#BDC3C7', '#95A5A6', 
                '#2C3E50', '#8E44AD', '#F4D03F', '#C0392B', '#BDC3C7', '#7D6608', '#7B7D7D', 
                '#D35400', '#2ECC71', '#1ABC9C', '#3498DB', '#16A085', '#F39C12', '#9B59B6', 
                '#34495E', '#2BC155', '#FF9B52', '#3F9AE0', '#FFC107', '#8E44AD', '#E74C3C', 
                '#3498DB', '#1ABC9C', '#F39C12'
            ],
              borderColor: [
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', 
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff',
                  '#fff', '#fff', '#fff'
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