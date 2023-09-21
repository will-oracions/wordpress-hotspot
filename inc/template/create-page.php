<?php add_thickbox();

if (!$data) return 'No image to display !';

// $imageData = deserializeImageData($data);

?>

<style>
  .HotspotPlugin_Hotspot>div {
    display: none !important;
  }
</style>

<!--  -->
<div id="my-content-id" style="display:none;">
  <?php include WORDPRESS_HOTSPOT_PLUGIN_PATH . 'inc/template/add-spot-form.php' ?>
</div>

<!-- <a href="#TB_inline?&width=600&height=550&inlineId=my-content-id" class="thickbox">View my inline content!</a> -->

<div id="main-page" class="wrap">
  <h1><?php _e("Add new image") ?></h1>

  <!-- options.php -->
  <form id="annotable-image-form" data-get-hotspot-endpoint="<?php echo $get_hotspot_endpoint; ?>" data-get-hotspot-endpoint="<?php echo $get_hotspot_endpoint; ?>" data-annotatedImageHotspot='<?php if (isset($annotatedImageHotspot)) echo json_encode($annotatedImageHotspot) ?>' data-page="<?php echo get_rest_url() . WORDPRESS_HOTSPOT_SAVE_IMAGE_ROUTE ?>" method="post" action="" novalidate="novalidate" enctype="multipart/form-data">
    <!-- <input type="hidden" name="option_page" value="general"><input type="hidden" name="action" value="update"><input type="hidden" id="_wpnonce" name="_wpnonce" value="cb6b72d745"><input type="hidden" name="_wp_http_referer" value="/wp-admin/options-general.php"> -->
    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th scope="row"><label for="blogname"><?php _e("Image Name"); ?></label></th>
          <td><input id="annotated-image-name-input" name="name" type="text" value="" class="regular-text"></td>
        </tr>

        <!-- <tr>
                    <th scope="row"><label for="blogdescription">Tagline</label></th>
                    <td><input name="blogdescription" type="text" id="blogdescription" aria-describedby="tagline-description" value="portez ce whisky au vieux juge blond qui fume" class="regular-text" placeholder="Just another WordPress site">
                    <p class="description" id="tagline-description">In a few words, explain what this site is about.</p></td>
                </tr> -->

        <tr>
          <th scope="row"><label for="blogdescription">Upload Image</label></th>
          <td>
            <!-- <input id="image-file-input" type='file' name='file'> -->
            <button id="upload-hotspot-image-btn" type="button" class="button">Upload Image</button>
            <!-- <button id="my-modal-button" type="button" class="button">Ouvrir la modale</button> -->
            <!-- <p class="description" id="tagline-description">In a few words, explain what this site is about.</p> -->
          </td>
        </tr>

        <tr>
          <th scope="row">
            <!-- <label for="blogdescription"></label> -->
            <div id="theElement-0">
              <img id="preview-hotspot-image" width="100%" />
            </div>
          </th>
          <td>
            <div>

              <?php include WORDPRESS_HOTSPOT_PLUGIN_PATH . 'inc/template/hotspot-preview.php' ?>


            </div>
            <!-- <p class="description" id="tagline-description">In a few words, explain what this site is about.</p> -->
          </td>
        </tr>
      </tbody>
    </table>

    <style>
      #theElement-0 {
        position: relative;
        width: 200px;
      }

      #theElement-a {
        width: 100%;
        max-width: 800px;
        border: 4px solid black;
        position: relative;
      }

      #theElement-a img {
        width: 100%;
      }

      .HotspotPlugin_Overlay p {
        display: none !important;
      }

      .HotspotPlugin_Save {
        /* display: none !important; */
      }

      .HotspotPlugin_Remove {
        /* display: none !important; */
      }

      .hotspot-edit-wrapper {}
    </style>


    <div class="hotspot-edit-wrapper">
      <div id="theElement-a">
        <!-- edit-hotspot-image -->
        <img id="annotatable-image" />
      </div>
    </div>

    <!-- <p class="submit"> -->
    <button id="save-annotated-image-btn" type="button" class="button button-primary button-large" value="<?php _e("Save"); ?>">
      <div id="btn-save-loader" class="app-custom-loader"></div>
      <div id="save-annotated-image-btn-text"><?php _e("Save Image"); ?></div>
    </button>
    <!-- </p> -->
  </form>
</div>

<!-- <style>
#my-modal {
  position: fixed;
  top: 13vh;
  width: 100%;
  max-width: 600px;
  height: 70vh;
  background-color: white;
  box-shadow: 1px 2px 3px rgba(0, 0, 0, .21);
}
</style>
<div id="my-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Titre de la modale</h2>
    <p>Contenu de la modale</p>
  </div>
</div> -->