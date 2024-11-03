<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<div class="row">
        <div class="col-lg-8">

		<?= $this->session->flashdata('message'); ?>
		<form action="<?= base_url('admin/edit'); ?>" method="post">
			<div class="form-group row">
				<label for="email" class="col-sm-2 col-form-label">Role</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="role" name="role" value="<?= $role['role']; ?>" readonly>
				</div>
            </div>

			<div class="form-group row justify-content-end">
				<div class="col-sm-10">
					<button type="submit" class="btn btn-primary">Edit</button>
				</div>
            </div>
		</form>
		</div>
	</div>
    
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
