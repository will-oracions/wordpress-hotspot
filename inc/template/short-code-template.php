<?php
if (!function_exists('deserializeImageData')) {
  function deserializeImageData($data)
  {
    $data->annotated_image = json_decode($data->annotated_image);
    return $data;
  }
}

// die($get_hotspot_endpoint);

if (!$data) return 'No image to display !';

$imageData = deserializeImageData($data);

// print_r($imageData->annotated_image);die();
?>

<div class="app-st-container">
  <div class="app-st-annotated-image">
    <div id="theElement-0" data-get-hotspot-endpoint="<?php echo $get_hotspot_endpoint; ?>">
      <img id="preview-hotspot-image" src="<?php echo $imageData->annotated_image->url ?>" width="100%" alt="Annotated image" />
    </div>
  </div>

  <div id="preview-spot-wrapper" class="app-st-box-wrapper">
    <div class="app-st-box-header">
      <!-- <div id="preview-spot-close-btn"> -->
      <!-- <span class="screen-reader-text">Close</span> -->
      <span class="app-st-box-close-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </span>
      <!-- </div> -->
    </div>
    <div class="app-st-box-content">
      <div class="app-st-box-content-image">
        <img id="preview-spot-desc-image" src="" alt="" alt="hotspot description" />
      </div>

      <div class="app-st-box-content-text">
        <div id="preview-spot-title" class="app-st-box-title"></div>
        <div id="preview-spot-desc"></div>
      </div>
    </div>
  </div>
</div>

<div style="display: none" id="spot-modal">
  <div class="">
    <h5 id="front-preview-spot-title"></h5>
    <div class="">
      <img height="20%" id="front-preview-spot-desc-image" src="" alt="no image" alt="hotspot description" />
    </div>
    <div id="front-preview-spot-desc" class="col-6">

    </div>
  </div>
</div>