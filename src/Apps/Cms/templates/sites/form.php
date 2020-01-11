<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-12">

         <div class="card">
            <div class="card-header">
	            <?php if( $this->site->exists() ): ?>
                   <h3 class="card-title">Edit <strong><?= $this->site->get('name') ?></strong> &lt; <?= $this->site->get('domain') ?> &gt;</h3>
               <?php else: ?>
                  <h3 class="card-title">Add a <strong>new site</strong></h3>
               <?php endif; ?>
            </div>
            <!-- /.box-header -->
            <div class="card-body">

               <div class="col-10">
                     <form action="/save/<?= $this->site->get('domain') ?>" class="form-horizontal" method="post">
                        <div class="box-body">
                           <div class="form-group row">
                              <label for="name" class="col-sm-2 control-label">Name</label>

                              <div class="col-sm-10">
                                 <input value="<?= $this->site->get('name') ?>" class="form-control" name="site_form[name]" id="name" placeholder="Name of site. E.g: Cerdas" type="text" minlength="3" maxlength="75">
                              </div>
                           </div>

	                        <?php if( $this->site->exists() ): ?>
                                 <div class="form-group  row">
                                    <label for="url" class="col-sm-2 control-label">Url</label>

                                    <div class="col-sm-10">
                                       <input value="http://<?= $this->site->get('domain') ?>" class="form-control" name="site_form[url]" id="url" placeholder="Url of site. E.g: http://cerdas.com" type="url" minlength="8" maxlength="75" <?php if( $this->site->exists() ): ?>disabled="disabled" <?php endif; ?>>
                                    </div>
                                 </div>
                                 <input type="hidden" name="site_form[domain]" value="http://<?= $this->site->get('domain') ?>" />
                           <?php else: ?>
                              <div class="form-group  row">
                                 <label for="url" class="col-sm-2 control-label">Url</label>

                                 <div class="col-sm-10">
                                    <input value="http://<?= $this->site->get('domain') ?>" class="form-control" name="site_form[domain]" id="url" placeholder="Url of site. E.g: http://cerdas.com" type="url" minlength="8" maxlength="75">
                                 </div>
                              </div>
                           <?php endif; ?>

                           <div class="form-group  row">
                              <label for="nats" class="col-sm-2 control-label">NATS</label>

                              <div class="col-sm-10">
                                 <input value="<?= $this->site->get('nats') ?>" class="form-control" name="site_form[nats]" id="nats" placeholder="NATS code. E.g: MjYwNS4xLjIuMi4wLjAuMC4wLjA" type="text" minlength="3" maxlength="75">
                              </div>
                           </div>

                           <div class="form-group  row">
                              <label for="nats_webcams" class="col-sm-2 control-label">NATS webcam</label>

                              <div class="col-sm-10">
                                 <input value="<?= $this->site->get('nats_webcams') ?>" class="form-control" name="site_form[nats_webcams]" id="nats_webcams" placeholder="NATs code for webcams. E.g: MjYwNS4xLjIuMi4wLjAuMC4wLjA" type="text" minlength="3" maxlength="75">
                              </div>
                           </div>

                           <div class="form-group  row">
                              <label for="analytics" class="col-sm-2 control-label">Analytics</label>

                              <div class="col-sm-10">
                                 <input value="<?= $this->site->get('analytics') ?>" class="form-control" name="site_form[analytics]" id="analytics" placeholder="Analytics code. E.g: UA-26020144-23" type="text" minlength="3" maxlength="75">
                              </div>
                           </div>

                        <!-- /.box-body -->
                        <div class="box-footer">
                           <button type="submit" class="btn btn-default" formaction="/">Cancel</button>

                           <button type="submit" class="btn btn btn-primary pull-right">Save</button>
                        </div>
                        <!-- /.box-footer -->
                     </form>
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
