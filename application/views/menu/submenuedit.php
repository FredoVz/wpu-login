<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<div class="row">
        <div class="col-lg-8">

		<?= $this->session->flashdata('message'); ?>
		<form action="<?= base_url('menu/submenuedit'); ?>" method="post">
			<div class="form-group">
                <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title" value="<?= $sub_menu['title']; ?>" required>
        	</div>
			<div class="form-group">
				<select name="menu_id" id="menu_id" class="form-control">
					<option value="">Select Menu</option>
					<?php foreach ($menu as $m): ?>
					<option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group">
				<input type="text" class="form-control" id="url" name="url" placeholder="Submenu url" value="<?= $sub_menu['url']; ?>" required>
			</div>

			<div class="form-group">
				<input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon" value="<?= $sub_menu['icon']; ?>" required>
			</div>
			<div class="form-group">
				<div class="form-check">
					<input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
					<label class="form-check-label" for="is_active">
						Active?
					</label>
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
