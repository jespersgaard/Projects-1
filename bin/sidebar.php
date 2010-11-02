		<div id="sidebar" class="span-6 last">
            <ul id="s_tabs">
				<li class="first"><a class="sb_views" href="#">Views</a></li>
				<li><a class="sb_people" href="#">People</a></li>
				<li><a class="sb_projects" href="#">Projects</a></li>
			</ul>
			<div id="s-views">
			</div>
			<div id="s-people">
			</div>
			<div id="s-projects">
			<?php
			getProjectByUserId($id);
			?>
			<a href="#" id="pclose">Close</a>
			</div>
				<?php 
				getTaskByUserId($id);
				?>
		</div><!-- end sidebar -->
		