/*
 * Atrana
 */

/*
 * this is the javascipt for the Atrana template.
 * if you want to change, please create a new javascript, 
 * because if one is missing in the original Atrana javascript it will fall apart
 */


//preloader
$(document).ready(function () {
    // Hide loader after 700ms
    setTimeout(function () {
        $(".loader, .loader-overlay").fadeOut();
    }, 700);

    // Sidebar toggle
    $("#sidebar-toggle, .sidebar-overlay").click(function () {
        $(".sidebar").toggleClass("sidebar-show");
        $(".sidebar-overlay").toggleClass("d-block");
    });

    // Sidebar menu dropdown (jQuery version)
    $("#sidebar .side-dropdown").each(function () {
        let dropdown = $(this);
        let link = dropdown.parent().find("a:first");

        link.click(function (e) {
            e.preventDefault(); // Prevent jumping if the link has an href

            // Close other open dropdowns
            if (!$(this).hasClass("active")) {
                $("#sidebar .side-dropdown").each(function () {
                    $(this).removeClass("show");
                    $(this).parent().find("a:first").removeClass("active");
                });
            }

            // Toggle the clicked dropdown
            $(this).toggleClass("active");
            dropdown.toggleClass("show");
        });
    });
});

 
document.getElementById('basic').addEventListener('click', () => {
    Toastify({
        text: "This is a toast",
        duration: 3000
    }).showToast();
})
document.getElementById('background').addEventListener('click', () => {
    Toastify({
        text: "This is a toast",
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
    }).showToast();
})
document.getElementById('close').addEventListener('click', () => {
    Toastify({
        text: "Click close button",
        duration: 3000,
        close:true,
        backgroundColor: "#4fbe87",
    }).showToast();
})
document.getElementById('top-left').addEventListener('click', () => {
    Toastify({
        text: "This is toast in top left",
        duration: 3000,
        close:true,
        gravity:"top",  
        position: "left",
        backgroundColor: "#4fbe87",
    }).showToast();
})
document.getElementById('top-center').addEventListener('click', () => {
    Toastify({
        text: "This is toast in top center",
        duration: 3000,
        close:true,
        gravity:"top",
        position: "center",
        backgroundColor: "#081A51",
    }).showToast();
})
document.getElementById('top-right').addEventListener('click', () => {
    Toastify({
        text: "This is toast in top right",
        duration: 3000,
        close:true,
        gravity:"top",
        position: "right",
        backgroundColor: "#081A51",
    }).showToast();
})
document.getElementById('bottom-right').addEventListener('click', () => {
    Toastify({
        text: "This is toast in bottom right",
        duration: 3000,
        close:true,
        gravity:"bottom",
        position: "right",
        backgroundColor: "#081A51",
    }).showToast();
})
document.getElementById('bottom-center').addEventListener('click', () => {
    Toastify({
        text: "This is toast in bottom center",
        duration: 3000,
        close:true,
        gravity:"bottom",
        position: "center",
        backgroundColor: "#081A51",
    }).showToast();
})
document.getElementById('bottom-left').addEventListener('click', () => {
    Toastify({
        text: "This is toast in bottom left",
        duration: 3000,
        close:true,
        gravity:"bottom",
        position: "left",
        backgroundColor: "#4fbe87",
    }).showToast();
})
 


  /** Chartjs Pages **/
  
  

const supPositionSelect = document.getElementById("supPosition");
const positionSelect = document.getElementById("position");

// Pre-selected values from PHP
const preSelectedSupPosition = "<?php echo isset($user_data['supPosition']) ? $user_data['supPosition'] : ''; ?>";
const preSelectedPosition = "<?php echo isset($user_data['position']) ? $user_data['position'] : ''; ?>";

// Example data structure (You should replace this with your actual data)
const positionAndSupPosition = {
    "Administrative Cadre": [
        "Administrative Cadre",
        "Executive Officer Cadre",
        "Clerical Officer Cadre",
        "Secretarial Cadre",
        "Secretarial Assistant Cadre",
        "Portel",
        "Office Assistant Cadre"
    ],
    "Academic Staff": [
        "Professor",
        "Associate Professor/Reader",
        "Lecturer I",
        "Lecturer II",
        "Assistant Lecturer",
        "Graduate Assistant"
    ],
    "Bursary": [
        "Accountant Cadre",
        "Executive Officer (Accounts) Cadre",
        "Stores Officers' Cadre",
        "Store Attendant"
    ],
    "Internal Audit Unit": [
        "Internal Auditors' Cadre",
        "Executive Officer (Audit) Cadre"
    ],
    "Directorate of Corporate Affairs": [
        "Information Officer Cadre",
        "Protocol Officer Cadre",
        "Photographer Cadre",
        "Video Camera Operator Cadre",
        "Information Assistant Cadre",
        "Executive Officer (Information) Cadre"
    ],
    "Health Services": [
        "Doctors Cadre",
        "Pharmacists Cadre",
        "Nursing Officer Cadre",
        "Pharmacy Technician Cadre",
        "Medical Laboratory Technologist Cadre",
        "Medical Laboratory Technician Cadre",
        "Medical Laboratory Assistant Cadre",
        "Health Records Officer",
        "Environmental Health Officer Cadre",
        "Veterinary Officer Cadre"
    ],
    "Legal Unit": [
        "Legal Officer Cadre"
    ],
    "University Library": [
        "Library Officer Cadre",
        "Library Assistant Cadre",
        "Bindery Officers' Cadre",
        "Bindery Assistant Cadre"
    ],
    "Directorate of COMSIT": [
        "Data Operator/I.T. Operator Cadre",
        "Data Analyst Cadre",
        "Computer Electronics Engineer Cadre",
        "Systems Programmer/Analyst Cadre",
        "Director, COMSIT"
    ],
    "Works Unit": [
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
        "Gardening Staff (Biological and Parks & Gardens Units)"
    ],
    "Zoo/Biological Garden": [
        "Turnstile Keeper Cadre",
        "Zoo Keeper Cadre",
        "Curator Cadre"
    ],
    "University Farm": [
        "Farm Officer/Manager",
        "Agricultural/Animal Health/Forestry Superintendent Cadre",
        "Farm/Livestock Supervisor"
    ],
    "Laboratory": [
        "Technologist Cadre",
        "Laboratory Supervisor"
    ],
    "University School": [
        "Staff School Cadre I (Lower Basic)",
        "Staff School Cadre II (Upper Basic)"
    ],
    "Directorate of Security": [
        "Security Cadre"
    ],
    "Academic Planning Unit": [
        "Planning Officer Cadre"
    ],
    "Sport": [
        "Coach Cadre"
    ],
    "SIWES": [
        "Coordinator Cadre (SIWES)"
    ],
    "Counselling Center": [
        "Counsellor Cadre"
    ],
    "Centre for Special Needs": [
        "Signer (Interpreter) Cadre"
    ],
    "Archives Centre": [
        "Archives Assistant Cadre",
        "Archives' Officer Cadre",
        "Archivist Cadre"
    ],
    "Educational Technology": [
        "Graphic Arts Assistant Cadre",
        "Graphic Arts Officers' Cadre"
    ],
    "Guest Houses": [
        "Cook/Steward/Catering Officer Cadre",
        "Laundry Cadre"
    ],
    "Fire Services": [
        "Fireman Cadre",
        "Fire Superintendent Cadre - 120",
        "Fire Officer Cadre - 122"
    ]

};

// Populate supPosition dropdown
supPositionSelect.innerHTML = '<option value="">--Select Supervisory Position--</option>';
for (let sup in positionAndSupPosition) {
    let option = document.createElement("option");
    option.value = sup;
    option.textContent = sup;

    if (sup === preSelectedSupPosition) {
        option.selected = true;
    }

    supPositionSelect.appendChild(option);
}

// Populate Positions based on the pre-selected supPosition (if available)
populatePositions();

function populatePositions() {
    const selectedSupPosition = supPositionSelect.value;
    positionSelect.innerHTML = '<option value="">--Select Position--</option>';

    if (selectedSupPosition && positionAndSupPosition[selectedSupPosition]) {
        positionAndSupPosition[selectedSupPosition].forEach(position => {
            let option = document.createElement("option");
            option.value = position;
            option.textContent = position;

            if (position === preSelectedPosition) {
                option.selected = true;
            }

            positionSelect.appendChild(option);
        });
    }
}

// Attach event listener to update positions when supPosition changes
supPositionSelect.addEventListener("change", populatePositions);



const stateSelect = document.getElementById("state");
const lgaSelect = document.getElementById("lga");

// Pre-selected values from PHP (if available)
const preSelectedState = "<?php echo isset($user_data['stateOfOrigin']) ? $user_data['stateOfOrigin'] : ''; ?>";
const preSelectedLGA = "<?php echo isset($user_data['lga']) ? $user_data['lga'] : ''; ?>";

// Example states and LGAs data (Replace with actual data)
const statesAndLGAs = {
    "Abia": [
        "Aba North",
        "Aba South",
        "Arochukwu",
        "Bende",
        "Ikwuano",
        "Isiala-Ngwa North",
        "Isiala-Ngwa South",
        "Isuikwato",
        "Obi Nwa",
        "Ohafia",
        "Osisioma",
        "Ngwa",
        "Ugwunagbo",
        "Ukwa East",
        "Ukwa West",
        "Umuahia North",
        "Umuahia South",
        "Umu-Neochi"
    ],
    "Adamawa": [
        "Demsa",
        "Fufore",
        "Ganaye",
        "Gireri",
        "Gombi",
        "Guyuk",
        "Hong",
        "Jada",
        "Lamurde",
        "Madagali",
        "Maiha",
        "Mayo-Belwa",
        "Michika",
        "Mubi North",
        "Mubi South",
        "Numan",
        "Shelleng",
        "Song",
        "Toungo",
        "Yola North",
        "Yola South"
    ],
    "Anambra": [
        "Aguata",
        "Anambra East",
        "Anambra West",
        "Anaocha",
        "Awka North",
        "Awka South",
        "Ayamelum",
        "Dunukofia",
        "Ekwusigo",
        "Idemili North",
        "Idemili south",
        "Ihiala",
        "Njikoka",
        "Nnewi North",
        "Nnewi South",
        "Ogbaru",
        "Onitsha North",
        "Onitsha South",
        "Orumba North",
        "Orumba South",
        "Oyi"
    ],
    "Akwa Ibom": [
        "Abak",
        "Eastern Obolo",
        "Eket",
        "Esit Eket",
        "Essien Udim",
        "Etim Ekpo",
        "Etinan",
        "Ibeno",
        "Ibesikpo Asutan",
        "Ibiono Ibom",
        "Ika",
        "Ikono",
        "Ikot Abasi",
        "Ikot Ekpene",
        "Ini",
        "Itu",
        "Mbo",
        "Mkpat Enin",
        "Nsit Atai",
        "Nsit Ibom",
        "Nsit Ubium",
        "Obot Akara",
        "Okobo",
        "Onna",
        "Oron",
        "Oruk Anam",
        "Udung Uko",
        "Ukanafun",
        "Uruan",
        "Urue-Offong/Oruko ",
        "Uyo"
    ],
    "Bauchi": [
        "Alkaleri",
        "Bauchi",
        "Bogoro",
        "Damban",
        "Darazo",
        "Dass",
        "Ganjuwa",
        "Giade",
        "Itas/Gadau",
        "Jama'are",
        "Katagum",
        "Kirfi",
        "Misau",
        "Ningi",
        "Shira",
        "Tafawa-Balewa",
        "Toro",
        "Warji",
        "Zaki"
    ],
    "Bayelsa": [
        "Brass",
        "Ekeremor",
        "Kolokuma/Opokuma",
        "Nembe",
        "Ogbia",
        "Sagbama",
        "Southern Jaw",
        "Yenegoa"
    ],
    "Benue": [
        "Ado",
        "Agatu",
        "Apa",
        "Buruku",
        "Gboko",
        "Guma",
        "Gwer East",
        "Gwer West",
        "Katsina-Ala",
        "Konshisha",
        "Kwande",
        "Logo",
        "Makurdi",
        "Obi",
        "Ogbadibo",
        "Oju",
        "Okpokwu",
        "Ohimini",
        "Oturkpo",
        "Tarka",
        "Ukum",
        "Ushongo",
        "Vandeikya"
    ],
    "Borno": [
        "Abadam",
        "Askira/Uba",
        "Bama",
        "Bayo",
        "Biu",
        "Chibok",
        "Damboa",
        "Dikwa",
        "Gubio",
        "Guzamala",
        "Gwoza",
        "Hawul",
        "Jere",
        "Kaga",
        "Kala/Balge",
        "Konduga",
        "Kukawa",
        "Kwaya Kusar",
        "Mafa",
        "Magumeri",
        "Maiduguri",
        "Marte",
        "Mobbar",
        "Monguno",
        "Ngala",
        "Nganzai",
        "Shani"
    ],
    "Cross River": [
        "Akpabuyo",
        "Odukpani",
        "Akamkpa",
        "Biase",
        "Abi",
        "Ikom",
        "Yarkur",
        "Odubra",
        "Boki",
        "Ogoja",
        "Yala",
        "Obanliku",
        "Obudu",
        "Calabar South",
        "Etung",
        "Bekwara",
        "Bakassi",
        "Calabar Municipality"
    ],
    "Delta": [
        "Oshimili",
        "Aniocha",
        "Aniocha South",
        "Ika South",
        "Ika North-East",
        "Ndokwa West",
        "Ndokwa East",
        "Isoko south",
        "Isoko North",
        "Bomadi",
        "Burutu",
        "Ughelli South",
        "Ughelli North",
        "Ethiope West",
        "Ethiope East",
        "Sapele",
        "Okpe",
        "Warri North",
        "Warri South",
        "Uvwie",
        "Udu",
        "Warri Central",
        "Ukwani",
        "Oshimili North",
        "Patani"
    ],
    "Ebonyi": [
        "Edda",
        "Afikpo",
        "Onicha",
        "Ohaozara",
        "Abakaliki",
        "Ishielu",
        "lkwo",
        "Ezza",
        "Ezza South",
        "Ohaukwu",
        "Ebonyi",
        "Ivo"
    ],
    "Enugu": [
        "Enugu South,",
        "Igbo-Eze South",
        "Enugu North",
        "Nkanu",
        "Udi Agwu",
        "Oji-River",
        "Ezeagu",
        "IgboEze North",
        "Isi-Uzo",
        "Nsukka",
        "Igbo-Ekiti",
        "Uzo-Uwani",
        "Enugu Eas",
        "Aninri",
        "Nkanu East",
        "Udenu."
    ],
    "Edo": [
        "Esan North-East",
        "Esan Central",
        "Esan West",
        "Egor",
        "Ukpoba",
        "Central",
        "Etsako Central",
        "Igueben",
        "Oredo",
        "Ovia SouthWest",
        "Ovia South-East",
        "Orhionwon",
        "Uhunmwonde",
        "Etsako East",
        "Esan South-East"
    ],
    "Ekiti": [
        "Ado",
        "Ekiti-East",
        "Ekiti-West",
        "Emure/Ise/Orun",
        "Ekiti South-West",
        "Ikere",
        "Irepodun",
        "Ijero,",
        "Ido/Osi",
        "Oye",
        "Ikole",
        "Moba",
        "Gbonyin",
        "Efon",
        "Ise/Orun",
        "Ilejemeje."
    ],
    "FCT": [
        "Abaji",
        "Abuja Municipal",
        "Bwari",
        "Gwagwalada",
        "Kuje",
        "Kwali"
    ],
    "Gombe": [
        "Akko",
        "Balanga",
        "Billiri",
        "Dukku",
        "Kaltungo",
        "Kwami",
        "Shomgom",
        "Funakaye",
        "Gombe",
        "Nafada/Bajoga",
        "Yamaltu/Delta."
    ],
    "Imo": [
        "Aboh-Mbaise",
        "Ahiazu-Mbaise",
        "Ehime-Mbano",
        "Ezinihitte",
        "Ideato North",
        "Ideato South",
        "Ihitte/Uboma",
        "Ikeduru",
        "Isiala Mbano",
        "Isu",
        "Mbaitoli",
        "Mbaitoli",
        "Ngor-Okpala",
        "Njaba",
        "Nwangele",
        "Nkwerre",
        "Obowo",
        "Oguta",
        "Ohaji/Egbema",
        "Okigwe",
        "Orlu",
        "Orsu",
        "Oru East",
        "Oru West",
        "Owerri-Municipal",
        "Owerri North",
        "Owerri West"
    ],
    "Jigawa": [
        "Auyo",
        "Babura",
        "Birni Kudu",
        "Biriniwa",
        "Buji",
        "Dutse",
        "Gagarawa",
        "Garki",
        "Gumel",
        "Guri",
        "Gwaram",
        "Gwiwa",
        "Hadejia",
        "Jahun",
        "Kafin Hausa",
        "Kaugama Kazaure",
        "Kiri Kasamma",
        "Kiyawa",
        "Maigatari",
        "Malam Madori",
        "Miga",
        "Ringim",
        "Roni",
        "Sule-Tankarkar",
        "Taura",
        "Yankwashi"
    ],
    "Kaduna": [
        "Birni-Gwari",
        "Chikun",
        "Giwa",
        "Igabi",
        "Ikara",
        "jaba",
        "Jema'a",
        "Kachia",
        "Kaduna North",
        "Kaduna South",
        "Kagarko",
        "Kajuru",
        "Kaura",
        "Kauru",
        "Kubau",
        "Kudan",
        "Lere",
        "Makarfi",
        "Sabon-Gari",
        "Sanga",
        "Soba",
        "Zango-Kataf",
        "Zaria"
    ],
    "Kano": [
        "Ajingi",
        "Albasu",
        "Bagwai",
        "Bebeji",
        "Bichi",
        "Bunkure",
        "Dala",
        "Dambatta",
        "Dawakin Kudu",
        "Dawakin Tofa",
        "Doguwa",
        "Fagge",
        "Gabasawa",
        "Garko",
        "Garum",
        "Mallam",
        "Gaya",
        "Gezawa",
        "Gwale",
        "Gwarzo",
        "Kabo",
        "Kano Municipal",
        "Karaye",
        "Kibiya",
        "Kiru",
        "kumbotso",
        "Ghari",
        "Kura",
        "Madobi",
        "Makoda",
        "Minjibir",
        "Nasarawa",
        "Rano",
        "Rimin Gado",
        "Rogo",
        "Shanono",
        "Sumaila",
        "Takali",
        "Tarauni",
        "Tofa",
        "Tsanyawa",
        "Tudun Wada",
        "Ungogo",
        "Warawa",
        "Wudil"
    ],
    "Katsina": [
        "Bakori",
        "Batagarawa",
        "Batsari",
        "Baure",
        "Bindawa",
        "Charanchi",
        "Dandume",
        "Danja",
        "Dan Musa",
        "Daura",
        "Dutsi",
        "Dutsin-Ma",
        "Faskari",
        "Funtua",
        "Ingawa",
        "Jibia",
        "Kafur",
        "Kaita",
        "Kankara",
        "Kankia",
        "Katsina",
        "Kurfi",
        "Kusada",
        "Mai'Adua",
        "Malumfashi",
        "Mani",
        "Mashi",
        "Matazuu",
        "Musawa",
        "Rimi",
        "Sabuwa",
        "Safana",
        "Sandamu",
        "Zango"
    ],
    "Kebbi": [
        "Aleiro",
        "Arewa-Dandi",
        "Argungu",
        "Augie",
        "Bagudo",
        "Birnin Kebbi",
        "Bunza",
        "Dandi",
        "Fakai",
        "Gwandu",
        "Jega",
        "Kalgo",
        "Koko/Besse",
        "Maiyama",
        "Ngaski",
        "Sakaba",
        "Shanga",
        "Suru",
        "Wasagu/Danko",
        "Yauri",
        "Zuru"
    ],
    "Kogi": [
        "Adavi",
        "Ajaokuta",
        "Ankpa",
        "Bassa",
        "Dekina",
        "Ibaji",
        "Idah",
        "Igalamela-Odolu",
        "Ijumu",
        "Kabba/Bunu",
        "Kogi",
        "Lokoja",
        "Mopa-Muro",
        "Ofu",
        "Ogori/Mangongo",
        "Okehi",
        "Okene",
        "Olamabolo",
        "Omala",
        "Yagba East",
        "Yagba West"
    ],
    "Kwara": [
        "Asa",
        "Baruten",
        "Edu",
        "Ekiti",
        "Ifelodun",
        "Ilorin East",
        "Ilorin West",
        "Irepodun",
        "Isin",
        "Kaiama",
        "Moro",
        "Offa",
        "Oke-Ero",
        "Oyun",
        "Pategi"
    ],
    "Lagos": [
        "Agege",
        "Ajeromi-Ifelodun",
        "Alimosho",
        "Amuwo-Odofin",
        "Apapa",
        "Badagry",
        "Epe",
        "Eti-Osa",
        "Ibeju/Lekki",
        "Ifako-Ijaye",
        "Ikeja",
        "Ikorodu",
        "Kosofe",
        "Lagos Island",
        "Lagos Mainland",
        "Mushin",
        "Ojo",
        "Oshodi-Isolo",
        "Shomolu",
        "Surulere"
    ],
    "Nasarawa": [
        "Akwanga",
        "Awe",
        "Doma",
        "Karu",
        "Keana",
        "Keffi",
        "Kokona",
        "Lafia",
        "Nasarawa",
        "Nasarawa-Eggon",
        "Obi",
        "Toto",
        "Wamba"
    ],
    "Niger": [
        "Agaie",
        "Agwara",
        "Bida",
        "Borgu",
        "Bosso",
        "Chanchaga",
        "Edati",
        "Gbako",
        "Gurara",
        "Katcha",
        "Kontagora",
        "Lapai",
        "Lavun",
        "Magama",
        "Mariga",
        "Mashegu",
        "Mokwa",
        "Muya",
        "Pailoro",
        "Rafi",
        "Rijau",
        "Shiroro",
        "Suleja",
        "Tafa",
        "Wushishi"
    ],
    "Ogun": [
        "Abeokuta North",
        "Abeokuta South",
        "Ado-Odo/Ota",
        "Yewa North",
        "Yewa South",
        "Ewekoro",
        "Ifo",
        "Ijebu East",
        "Ijebu North",
        "Ijebu North East",
        "Ijebu Ode",
        "Ikenne",
        "Imeko-Afon",
        "Ipokia",
        "Obafemi-Owode",
        "Ogun Waterside",
        "Odeda",
        "Odogbolu",
        "Remo North",
        "Shagamu"
    ],
    "Ondo": [
        "Akoko North East",
        "Akoko North West",
        "Akoko South Akure East",
        "Akoko South West",
        "Akure North",
        "Akure South",
        "Ese-Odo",
        "Idanre",
        "Ifedore",
        "Ilaje",
        "Ile-Oluji",
        "Okeigbo",
        "Irele",
        "Odigbo",
        "Okitipupa",
        "Ondo East",
        "Ondo West",
        "Ose",
        "Owo"
    ],
    "Osun": [
        "Aiyedade",
        "Aiyedire",
        "Atakumosa East",
        "Atakumosa West",
        "Boluwaduro",
        "Boripe",
        "Ede North",
        "Ede South",
        "Egbedore",
        "Ejigbo",
        "Ife Central",
        "Ife East",
        "Ife North",
        "Ife South",
        "Ifedayo",
        "Ifelodun",
        "Ila",
        "Ilesha East",
        "Ilesha West",
        "Irepodun",
        "Irewole",
        "Isokan",
        "Iwo",
        "Obokun",
        "Odo-Otin",
        "Ola-Oluwa",
        "Olorunda",
        "Oriade",
        "Orolu",
        "Osogbo"
    ],
    "Oyo": [
        "Afijio",
        "Akinyele",
        "Atiba",
        "Atisbo",
        "Egbeda",
        "Ibadan Central",
        "Ibadan North",
        "Ibadan North West",
        "Ibadan South East",
        "Ibadan South West",
        "Ibarapa Central",
        "Ibarapa East",
        "Ibarapa North",
        "Ido",
        "Irepo",
        "Iseyin",
        "Itesiwaju",
        "Iwajowa",
        "Kajola",
        "Lagelu Ogbomosho North",
        "Ogbomosho South",
        "Ogo Oluwa",
        "Olorunsogo",
        "Oluyole",
        "Ona-Ara",
        "Orelope",
        "Ori Ire",
        "Oyo East",
        "Oyo West",
        "Saki East",
        "Saki West",
        "Surulere"
    ],
    "Plateau": [
        "Barikin Ladi",
        "Bassa",
        "Bokkos",
        "Jos East",
        "Jos North",
        "Jos South",
        "Kanam",
        "Kanke",
        "Langtang North",
        "Langtang South",
        "Mangu",
        "Mikang",
        "Pankshin",
        "Qua'an Pan",
        "Riyom",
        "Shendam",
        "Wase"
    ],
    "Rivers": [
        "Abua/Odual",
        "Ahoada East",
        "Ahoada West",
        "Akuku Toru",
        "Andoni",
        "Asari-Toru",
        "Bonny",
        "Degema",
        "Emohua",
        "Eleme",
        "Etche",
        "Gokana",
        "Ikwerre",
        "Khana",
        "Obio/Akpor",
        "Ogba/Egbema/Ndoni",
        "Ogu/Bolo",
        "Okrika",
        "Omumma",
        "Opobo/Nkoro",
        "Oyigbo",
        "Port-Harcourt",
        "Tai"
    ],
    "Sokoto": [
        "Binji",
        "Bodinga",
        "Dange-shnsi",
        "Gada",
        "Goronyo",
        "Gudu",
        "Gawabawa",
        "Illela",
        "Isa",
        "Kware",
        "kebbe",
        "Rabah",
        "Sabon birni",
        "Shagari",
        "Silame",
        "Sokoto North",
        "Sokoto South",
        "Tambuwal",
        "Tqngaza",
        "Tureta",
        "Wamako",
        "Wurno",
        "Yabo"
    ],
    "Taraba": [
        "Ardo-kola",
        "Bali",
        "Donga",
        "Gashaka",
        "Cassol",
        "Ibi",
        "Jalingo",
        "Karin-Lamido",
        "Kurmi",
        "Lau",
        "Sardauna",
        "Takum",
        "Ussa",
        "Wukari",
        "Yorro",
        "Zing"
    ],
    "Yobe": [
        "Bade",
        "Bursari",
        "Damaturu",
        "Fika",
        "Fune",
        "Geidam",
        "Gujba",
        "Gulani",
        "Jakusko",
        "Karasuwa",
        "Karawa",
        "Machina",
        "Nangere",
        "Nguru Potiskum",
        "Tarmua",
        "Yunusari",
        "Yusufari"
    ],
    "Zamfara": [
        "Anka",
        "Bakura",
        "Birnin Magaji",
        "Bukkuyum",
        "Bungudu",
        "Gummi",
        "Gusau",
        "Kaura",
        "Namoda",
        "Maradun",
        "Maru",
        "Shinkafi",
        "Talata Mafara",
        "Tsafe",
        "Zurmi"
    ]
};

// Populate the state dropdown
stateSelect.innerHTML = '<option value="">--Select State--</option>';
for (let state in statesAndLGAs) {
    let option = document.createElement("option");
    option.value = state;
    option.textContent = state;

    if (state === preSelectedState) {
        option.selected = true;
    }

    stateSelect.appendChild(option);
}

// Function to populate LGA dropdown
function populateLGAs() {
    const selectedState = stateSelect.value;
    lgaSelect.innerHTML = '<option value="">--Select LGA--</option>';

    if (selectedState && statesAndLGAs[selectedState]) {
        statesAndLGAs[selectedState].forEach(lga => {
            let option = document.createElement("option");
            option.value = lga;
            option.textContent = lga;

            if (lga === preSelectedLGA) {
                option.selected = true;
            }

            lgaSelect.appendChild(option);
        });
    }
}

// Populate LGAs based on pre-selected state (if available)
populateLGAs();

// Update LGAs when state selection changes
stateSelect.addEventListener("change", populateLGAs);