        <!--# content #-->
        <div class="content">

          <div class="page-title">
            <div class="title-overlay">
              <h1>{$oMod->getName()}</h1>
            </div>
            <img src="{#IMAGE_PATH#}/default-title-bg.jpg" class="img-fluid">
          </div>

          <div class="container">
            <br><br>
            {foreach $aGallery as $gallery}
            <h6>{$gallery->getName()}</h6>
            {assign var=images value=GalleryPicturePeer::getByGroup($gallery)}
            {if $images|count > 0}
            <div class="row">
              {foreach $images as $image}
              <div class="col-md-3">
                <a href="{$image->getPictureUrl()}" title="{$image->getName()}" data-fancybox="{$gallery->getId()}" data-caption="{$image->getName()}">
                  <img src="{$image->getThumbnailURL(400, 300, 1)}" class="img-fluid img-thumbnail" alt="{$image->getName()}">
                </a>
                <div style="height: 30px"></div>
              </div>
              {/foreach}
            </div>
            <br>
            {/if}
            {/foreach}
            <br><br>
          </div>

        </div>
        <!--# content #-->