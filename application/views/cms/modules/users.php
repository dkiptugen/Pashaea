<div class="col-md-12">
	<div class="well col-md-11">
		
			<div class="pull-left">
				<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">+ New User</button>
			</div>
			<div class="pull-right">
				<input type="text" placeholder="Search"  />
			</div>
		    <div class="clearfix"></div>
	</div>
</div>
<div class="col-md-11">
    <?=($msg!="")?"<div class=\"alert alert-warning alert-dismissable\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" style='text-decoration:none;'>×</a>".$msg."</div>":$msg; ?>
	<table class="table table-condensed table-striped">
		<thead>
			<tr>
				<th></th>
				<th>username</th>
				<th>Name</th>
				<th>Email</th>
				<th>Password Status</th>
				<th>Access</th>
			</tr>
		</thead>
		<tbody>
		<?php
		
		if($user!=NULL)
			{   

				foreach ($user as $value) {
					
				$pass_state=($value->pass_status==0)?'okay':'default';
				$class=($value->user_status==0)?'alert-danger':'';
				$button=($value->user_status==1)?'<a class="dropdown-item col-md-12" href="'.site_url('cms/users/inactivate/'.$value->id).'">inactivate</a>':'<a class="dropdown-item col-md-12" href="'.site_url('cms/users/activate/'.$value->id).'">activate</a>';
				echo'
					<tr class="'.$class.'">
						<td >
							<div class="dropdown show">
							  <a class="btn btn-secondary dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Action
							  </a>
							  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							    <a class="dropdown-item col-md-12" href="#">Edit</a>
							    '.$button.'
							    <a class="dropdown-item col-md-12" href="'.site_url('cms/users/delete/'.$value->id).'">Delete</a>
							  </div>
							</div>
						</td>
						<td>'.$value->username.'</td>
						<td>'.ucfirst($value->Name).'</td>
						<td>'.$value->email.'</td>
						<td>'.$pass_state.'</td>
						<td>'.$value->role.'</td>
					</tr>';
					}
			}
			?>
		</tbody>
	</table>
	<div class="pull-right"><?=$link; ?></div>
	<div class="clearfix"></div>
</div>
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg" role="document">
      <div class="panel panel-primary">
      	<div class="panel-heading">Add User</div>
      	<div class="panel-body">
      		<div class="container">
      		    <form action="<?=site_url("cms/users/add"); ?>" class="form form-horizontal" role="form" method="post">
      				<div class="form-group">
      					<label for="" class="control-label col-md-3 text-left">First Name</label>
      					<div class="col-md-6">
      						<input type="text" class="form-control" name="f_name" />
      					</div>
      				</div>
      				<div class="form-group">
      					<label for="" class="control-label col-md-3">Last Name</label>
      					<div class="col-md-6">
      						<input type="text" class="form-control" name="l_name" />
      					</div>
      				</div>
      				<div class="form-group">
      					<label for="" class="control-label col-md-3">User Name</label>
      					<div class="col-md-6">
      						<input type="text" class="form-control" name="username" />
      					</div>
      				</div>
      				<div class="form-group">
      					<label for="" class="control-label col-md-3">Password</label>
      					<div class="col-md-6">
      						<input type="text" class="form-control" name="password" />
      					</div>
      				</div>
      				<div class="form-group">
      					<label for="" class="control-label col-md-3">Email</label>
      					<div class="col-md-6">
      						<input type="text" class="form-control" name="email" />
      					</div>
      				</div>
      				<div class="col-md-offset-3 col-md-6">
      					<div class="col-md-6">
	      					<div class="form-check">
							    <label class="form-check-label">
							      <input type="checkbox" class="form-check-input"  name="Inactive" value="1" />
							      Inactive
							    </label>
							</div>
						</div>
						<div class="col-md-6">
	      					<div class="form-check">
							    <label class="form-check-label">
							      <input type="checkbox" class="form-check-input"  name="col" value="1" />
							      Change Password on next login
							    </label>
							</div>
						</div>
      				</div>
      				
      				
      			
      		</div>
      	</div>
      	<div class="panel-footer ">
      	   	<div class="my-auto">
      			<button type="submit" class="btn btn-success" name="save" value="1">save</button>
      			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      		</div>
      		</form>
      	</div>
    
    </div>
  </div>
</div>


