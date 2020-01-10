<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-12">

         <div class="card">
            <div class="card-header">
               <h3 class="card-title">Available sites</h3>

               <div class="card-tools">
                  <div class="input-group input-group-sm hidden-xs" style="width: 150px;">

                     <div class="input-group-btn">
                        <a href="/add/" class="btn  btn-primary"><i class="fa fa-plus"></i> New site</a>
                     </div>
                  </div>
               </div>
            </div>

            <!-- /.box-header -->
            <div class="card-body">

               <table id="sites"  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                     <th>Name</th>
                     <th>Domain</th>
                     <th>Analytics</th>
                     <th>Nats</th>
                     <th>Nats webcam</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($this->vars['sites'] as $site): ?>
                     <tr>
                        <td><a href="/edit/<?= $site->get('domain'); ?>"><?= $site->get('name') ?></a></td>
                        <td><a href="<?= $site->getUrl(); ?>" target="_blank"><?= $site->get('domain') ?></a></td>
                        <td><?= $site->get('analytics') ?></td>
                        <td><?= $site->get('nats') ?></td>
                        <td><?= $site->get('nats_webcams') ?></td>
                     </tr>
                  <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                  <tr>
                     <th>Name</th>
                     <th>Domain</th>
                     <th>Analytics</th>
                     <th>Nats</th>
                     <th>Nats webcam</th>
                  </tr>
                  </tfoot>
               </table>
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
