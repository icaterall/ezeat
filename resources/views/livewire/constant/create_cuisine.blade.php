<div>
	<div class="panel panel-default">

		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Sorry!</strong> invalid input.<br><br>
			<ul style="list-style-type:none;">
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif


		<div class="form-group">
			<label for="name">Name</label>
			<input wire:model="name" id="name" type="text" class="form-control input-sm">
			<small id="help" class="form-text text-muted">min 5 characters.</small>
		</div>
 <button type="button" wire:click.prevent="store()" class="btn btn-success font-weight-bold">Submit</button>
	</div>
</div>

