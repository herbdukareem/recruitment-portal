<div class="sidebar transition overlay-scrollbars animate__animated  animate__slideInLeft">
		<div class="sidebar-content w-100">
			<div id="sidebar">

				<!-- Logo -->
				<div class="logo mt-4 mx-5">
					<img class="img-fluid w-50 h-50" src="./assets/images/logo.jpg" alt="">
					<!-- <h2 class="mb-0"><img src=""> Un</h2> -->
				</div>

				<ul class="side-menu">
					<li>
						<a onclick="showDiv('dashboard')" class="active">
							<i class='bx bxs-dashboard icon'></i> Dashboard
						</a>
					</li>
					<li>
						<a onclick="showDiv('applicant')" class="active">
							<i class='bx bxs-dashboard icon'></i> Add Applicant
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<script>
        function showDiv(id) {
            // Hide all divs with the class 'content-div'
            var allDivs = document.querySelectorAll('.position');
            allDivs.forEach(function(div) {
                div.style.display = 'none';
            });

            // Show the clicked div
            document.getElementById(id).style.display = 'flex';
        }
    </script>