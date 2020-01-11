<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-12">

			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Save operation</h3>
				</div>

				<!-- /.box-header -->
				<div class="card-body">
					<?php if( empty($this->vars['notices']['error']) ): ?>
						<div class="alert alert-success">
							<h4><i class="icon fa fa-check"></i> Site saved!</h4>
					<?php else: ?>
							<div class="alert alert-dangere">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-ban"></i> Site error!</h4>
					<?php endif; ?>

							<?php if( !empty($this->vars['notices']['msg']) ): ?>
								<ul>
									<?php foreach( $this->vars['notices']['msg'] as $msg) : ?>
									<li><?= $msg ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box-card -->
		</div>
		<!-- /.box-col12 -->
	</div>
	<!-- /.box-row -->

</section>
<!-- /.content -->
