(function ($) {
  class ManageHotspot {
    HOTSPOT_ACTIVE_CLASS = "app-active-hotspot"; //app-hotspot

    constructor(hotspots) {
      this.hotspots = hotspots;

      //
      this.init();
    }

    loadTemplate($) {
      this.previewerWrapper = $("#theElement-0");
      this.previewHotSpots = $("#theElement-0 .HotspotPlugin_Hotspot");
      this.previewSpotWrapper = $("#preview-spot-wrapper");
      this.previewSpotTitle = $("#preview-spot-title");
      this.previewSpotDescImage = $("#preview-spot-desc-image");
      this.previewSpotDesc = $("#preview-spot-desc");
      this.previewSpotCloseBtns = $(".app-st-box-close-btn");
    }

    init() {
      this.loadTemplate(jQuery);
      this.bindListeners();
      this.addSpotsToAnnotatedImage();
      // this.activePoint();
      this.activeDefaultSpot();
    }

    addSpotToPreviewer(x, y) {
      const point = $(
        `<div class="app-hotspot" data-id="${this.getSpotLocationId(
          x,
          y
        )}" style="cursor: pointer; width: 20px; height: 20px; border-radius:50%; background: #1abc9c; position: absolute; top: calc(${y}% - 10px); left: calc(${x}% - 10px)"></div>`
      );

      point.click(() => {
        const clickedSpot = this.getHotspotByCoordonatesId(x, y);
        if (!clickedSpot) {
          alert("Invalid spot");
          return;
        }
        this.activePoint(point);
        this.previewHotspot(clickedSpot.locationId);
      });
      this.previewerWrapper.append(point);
    }

    activePoint(pointEl) {
      this.deactivateAllSpot();
      pointEl.addClass(this.HOTSPOT_ACTIVE_CLASS);
    }

    activeDefaultSpot() {
      const point = this.hotspots[0];
      if (!point) return;

      const pointEl = this.previewerWrapper.find(
        `[data-id="${this.getSpotLocationId(point.x, point.y)}"]`
      );

      // console.log("Default spot", pointEl);

      this.activePoint(pointEl);
      this.previewHotspot(point.locationId, false);
    }

    getAllSpot() {
      const hotspotsTemplate = $("#theElement-0").find(".app-hotspot");
      // console.log("Hotspot Template: ", hotspotsTemplate);
      return hotspotsTemplate;
    }

    deactivateAllSpot() {
      this.getAllSpot().map((_, spot) => {
        const spotEl = $(spot);
        // console.log(">>>> ", spotEl);
        spotEl.removeClass(this.HOTSPOT_ACTIVE_CLASS);
        // console.log(">>>> ", spotEl);
      });
    }

    getSpotLocationId(x, y) {
      return `${x}-${y}`;
    }

    getHotspotByCoordonatesId(x, y) {
      const locationId = this.getSpotLocationId(x, y);
      return this.hotspots.find((spot) => spot.locationId === locationId);
    }

    addSpotsToAnnotatedImage() {
      this.hotspots.map((spot) => {
        this.addSpotToPreviewer(spot.x, spot.y);
      });
    }

    bindListeners() {
      this.previewSpotCloseBtns.map((index, btn) => {
        const hotspotActiveClass = "app-active-hotspot";

        $(btn).click(function () {
          function deactivateAllSpot() {
            $("#theElement-0")
              .find(".app-hotspot")
              .map((_, spot) => {
                const spotEl = $(spot);
                spotEl.removeClass(hotspotActiveClass);
              });
          }

          deactivateAllSpot();
          $(this).parent().parent().css("display", "none");
        });
      });

      // this.bindPreviewSpotListeners(jQuery);
    }

    // bindPreviewSpotListeners($) {
    // 	this.getPreviewSpot($).map((index, spot) => {
    // 		// console.log("-->>", spot);
    // 		const previewSpot = $(spot);
    // 		const wrapper = previewSpot.find(".HotspotPlugin_Hotspot_Hidden");

    // 		// console.log("Wrapper: ", wrapper);
    // 		wrapper.css("display", "none!impotant");

    // 		// console.log(spot);
    // 		previewSpot.click(() => {
    // 			const locationIdEl = previewSpot.find(".Hotspot_locationId");
    // 			// console.log("locationId: ", locationIdEl.text());
    // 			this.previewHotspot(locationIdEl.text());
    // 		});
    // 	});
    // }

    getPreviewSpot($) {
      this.previewHotSpots = $("#theElement-0 .HotspotPlugin_Hotspot");
      return this.previewHotSpots;
    }

    previewHotspot(locationId, inMobileScreen = true) {
      // console.log("Preview spot: ", locationId);

      const hotspot = this.hotspots.find(
        (spot) => spot.locationId === locationId
      );

      if (!hotspot) {
        alert("Invalid hotspot");
        return;
      }

      // console.log("PREVIEW HOTSPOT", hotspot);

      const image = hotspot.image;

      if (this.isMobileScreen()) {
        if (inMobileScreen) {
          const prewiewerTitle = $("#front-preview-spot-title");
          const previewerDesc = $("#front-preview-spot-desc");
          const previewerImage = $("#front-preview-spot-desc-image");
          prewiewerTitle.text(hotspot.title);
          previewerDesc.text(hotspot.description);
          previewerImage.attr("src", image.url);

          this.previewSpotWrapper.css("display", "none");

          // open modal
          this.openModal(hotspot.title);
        }
      } else {
        this.previewSpotTitle.text(hotspot.title);
        this.previewSpotDesc.html(hotspot.description);
        this.previewSpotDescImage.attr("src", image.url);
        // console.log(previewSpotDescImage, image.url);
        this.previewSpotWrapper.css("display", "block");
      }
    }

    openModal(title = "") {
      // do not rest currentX, currentY
      //   resetAddHotspotForm(false);
      // const title = title /"Add a new hotspot the the image";
      // const url = "#TB_inline?&width=600&height=550&inlineId=my-content-id";
      // tb_show(title, url);
      // $("#spot-modal").modal();

      const modalBox = $("#spot-modal");
      // console.log("Modal box: ", modalBox);
      modalBox.modal();
    }

    isMobileScreen() {
      return $(window).width() < 700;
    }
  }

  const annotableImage = $("#theElement-0");
  const jsonData = annotableImage.attr("data-image");

  // console.log("its works!!");

  // const decodedData = decodeImageData(jsonData);
  // console.log(decodedData);

  // annotableImage.hotspot({
  // 	mode: "display",
  // 	data: decodedData.data,
  // 	interactivity: "click",
  // });

  const url = annotableImage.attr("data-get-hotspot-endpoint");

  if (url) {
    fetch(url)
      .then((res) => res.json())
      .then((res) => {
        // console.log(res);

        const decodedData = {
          ...res,
          data: JSON.parse(res.data),
          annotated_image: JSON.parse(res.annotated_image),
        };
        // console.log(decodedData);
        new ManageHotspot(decodedData.data);
      });
  } else {
    throw new Error("ERROR: No url to get hotspot from db");
  }

  // console.log(decodedData);
  // new ManageHotspot(decodedData.data);

  // Functions
  // function decodeImageData(jsonData) {
  //   const encodedData = JSON.parse(jsonData);
  //   const decodedData = {
  //     ...encodedData,
  //     data: JSON.parse(encodedData.data),
  //   };
  //   return decodedData;
  // }
})(jQuery);
