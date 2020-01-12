<div class="listado-chicas">

	<?php  foreach ( $this->vars[ 'chicas_list' ] as $index => $chica ): ?>
       <div class="<?= $chica->getTags()  ?>">
          <a class="link" href="<?= $chica->getWebCamLink() ?>?nats=[[ECHO_PHP]] $this->site->get( 'nats_webcams' ) [[CLOSE_PHP]]"
             title="<?= $chica->getName() ?>">
             <span class="thumb"><img src="[[ECHO_PHP]] $this->getCdnUrl('images/lazy.gif') [[CLOSE_PHP]]" data-src="<?= $chica->getImageUrl() ?>" width="175"
                                      height="150" alt="Foto de <?= $chica->getName() ?>" title="<?= $chica->getName() ?>"/></span>
             <span class="nombre-chica"> <span class="ico-<?= $chica->getStatus(); ?>"></span> <?= $chica->getName() ?></span>
             <span id="favorito" class="ico-favorito"></span>
          </a>
       </div>
	<?php endforeach;  ?>

</div>

<div class="clear"></div>

<div class="btns">
	[[PHP]] if ( $this->vars[ 'page' ] > 1 ): [[CLOSE_PHP]]
       <a class="btn-mas-modelos" href="/[[ECHO_PHP]] ( $this->vars[ 'page' ] - 1 ) [[CLOSE_PHP]]" title="Mostrar más modelos">Anterior Página</a>
	[[PHP]] endif; [[CLOSE_PHP]]

   <a class="btn-mas-modelos" href="/[[ECHO_PHP]] $this->vars[ 'page' ] + 1 [[CLOSE_PHP]]" title="Mostrar más modelos">Siguiente Página</a>
</div>

<div id="iframe--modal">
   <a href="javascript:void(0)"><img src="[[ECHO_PHP]] $this->getCdnUrl('images/x.png') [[CLOSE_PHP]]" width="25" height="29" /></a>
</div>

<div class="iframe--modal--background">&nbsp;</div>
