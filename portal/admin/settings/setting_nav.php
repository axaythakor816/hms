<div class="settings-menu-links">
	<ul class="nav nav-tabs menu-tabs">
		<?php if(has_permission('settings', 'can_view')): ?>
		<li class="nav-item active">
			<a class="nav-link" href="settings/settings.php">General Settings</a>
		</li>
		<?php endif;
		if(has_permission('profiles', 'can_view')): ?>
		<li class="nav-item">
			<a class="nav-link" href="settings/profile.php">My Profile</a>
		</li>	
		<?php endif;
		if(has_permission('profiles', 'can_edit')): ?>
		<li class="nav-item">
			<a class="nav-link" href="settings/change-password.php">Change Password</a>
		</li>
		<?php endif; 
		if(has_permission('roles', 'can_view')): ?>
		<li class="nav-item">
			<a class="nav-link" href="settings/roles/role_list.php">Role Settings</a>
		</li>				
		<?php endif;
		if(has_permission('permissions', 'can_view')): ?>
		<li class="nav-item">
			<a class="nav-link" href="settings/permissions/permission_list.php">Permission Settings</a>
		</li>
		<?php endif; 
		if(has_permission('manage users', 'can_view')): ?>
		<li class="nav-item">
			<a class="nav-link" href="settings/manageusers/user_list.php">Manage Users</a>
		</li>
		<?php endif; ?>
	</ul>
</div>
