<div class="listado-chicas">

	<?php  foreach ( $this->vars[ 'chicas_list' ] as $index => $chica ): ?>
       <div class="<?= $chica->getTags()  ?>">
          <a class="link" href="<?= $chica->getWebCamLink() ?>?nats=<?= $this->site->get( 'nats_webcams' ) ?>"
             title="<?= $chica->getName() ?>">
             <span class="thumb"><img src="<?= $this->getCdnUrl('images/lazy.gif') ?>" data-src="<?= $chica->getImageUrl() ?>" width="175"
                                      height="150" alt="Foto de <?= $chica->getName() ?>" title="<?= $chica->getName() ?>"/></span>
             <span class="nombre-chica"> <span class="ico-<?= $chica->getStatus(); ?>"></span> <?= $chica->getName() ?></span>
             <span id="favorito" class="ico-favorito"></span>
          </a>
       </div>
	<?php endforeach;  ?>

</div>

<div class="clear"></div>

<div class="btns">
	<?php if ( $this->vars[ 'page' ] > 1 ): ?>
       <a class="btn-mas-modelos" href="/<?= ( $this->vars[ 'page' ] - 1 ) ?>" title="Mostrar más modelos">Anterior Página</a>
	<?php endif; ?>

   <a class="btn-mas-modelos" href="/<?= $this->vars[ 'page' ] + 1 ?>" title="Mostrar más modelos">Siguiente Página</a>
</div>

<div id="iframe--modal">
   <a href="javascript:void(0)"><img src="<?= $this->getCdnUrl('images/x.png') ?>" width="25" height="29" /></a>
</div>

<div class="iframe--modal--background">&nbsp;</div>
