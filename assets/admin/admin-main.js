// (function ($) {
// 	const imageFileInput = $("#image-file-input");
// 	const editHotspotBtn = $("#edit-hotspot-btn");

// 	const previewHotspotImageWrapper = $("#theElement-0");
// 	const editHotspotImageWrapper = $("#theElement-a");
// 	const previewHotspotImage = $("#preview-hotspot-image");
// 	const editHotspotImage = $("#edit-hotspot-image");

// 	let base64Image = null;

// 	let haveFile = false;
// 	let editingHotspot = false;

// 	let hotspotsData = [
// 		// {
// 		// 	x: 27,
// 		// 	y: 56.0178151234486,
// 		// 	Title: "Roue",
// 		// 	Message: "Les roues",
// 		// },
// 		// {
// 		// 	x: 67.375,
// 		// 	y: 67.73901855930929,
// 		// 	Title: "immatriculation",
// 		// 	Message: "Plaque d'immatriculation",
// 		// },
// 	];

// 	main();

// 	function main() {
// 		$(document).ready(function () {
// 			formatUI();
// 			bindListeners();

// 			$("#theElement-0").hotspot({
// 				mode: "display",
// 				data: hotspotsData,
// 				interactivity: "click",
// 			});

// 			setTimeout(() => paint(), 100);

// 			$(window).on("resize", paint);

// 			const selectedSpotTitle = $(".selected-spot-title");
// 			const selectedSpotMessage = $(".selected-spot-message");
// 			const selectedSpotClose = $(".selected-post-close");

// 			let selectedSpot = null;

// 			selectedSpotClose.click(() => {
// 				selectedSpot = null;
// 				hideSelectedSpotWrapper();
// 			});

// 			function paint() {
// 				const spots = $("#the-element-0 .HotspotPlugin_Hotspot");

// 				spots.map((index, spot) => {
// 					const spotEl = $(spot);

// 					spotEl.click((event) => {
// 						console.log("spot: ", spotEl);
// 						if (spotEl === selectedSpot) return;

// 						selectedSpot = spotEl;
// 						const title = spotEl.find(".Hotspot_Title");
// 						const message = spotEl.find(".Hotspot_Message");

// 						console.log("title: ", title.text());
// 						console.log("Message: ", message.text());

// 						selectedSpotTitle.text(title.text());
// 						selectedSpotMessage.text(message.text());
// 						showSelectedSpotWrapper();
// 					});
// 				});
// 			}

// 			function showSelectedSpotWrapper() {
// 				const wrapper = $(".selected-spot-wrapper");
// 				if (wrapper.css("display") === "none") {
// 					wrapper.css("display", "block");
// 				}
// 			}

// 			function hideSelectedSpotWrapper() {
// 				const wrapper = $(".selected-spot-wrapper");
// 				if (wrapper.css("display") === "block") {
// 					wrapper.css("display", "none");
// 				}
// 			}

// 			$("#theElement-a").hotspot({
// 				mode: "admin",
// 				// uncomment
// 				/*ajax: true,
// 				ajaxOptions: {
// 					'url': 'links.to.server'
// 				},*/
// 				interactivity: "click",
// 				LS_Variable: "HotspotPlugin-a",

// 				afterSave: function (err, data) {
// 					if (err) {
// 						console.log("Error occurred", err);
// 						return;
// 					}
// 					// alert("Saved");
// 					// `data` in json format can be stored
// 					//  & passed in `display` mode for the image
// 					console.log(data);
// 					hotspotsData = data;
// 					console.log("Hotspot data: ", hotspotsData);
// 					$("#theElement-0").hotspot({
// 						mode: "display",
// 						data: hotspotsData,
// 						interactivity: "click",
// 					});
// 				},
// 				afterRemove: function (err, message) {
// 					if (err) {
// 						console.log("Error occurred", err);
// 						return;
// 					}
// 					alert(message);
// 					window.location.reload();
// 				},
// 				afterSend: function (err, message) {
// 					if (err) {
// 						console.log("Error occurred", err);
// 						return;
// 					}
// 					alert(message);
// 				},
// 			});

// 			// $("#theElement-b").hotspot({
// 			// 	mode: "admin",
// 			// 	interactivity: "hover",
// 			// 	LS_Variable: "HotspotPlugin-b",
// 			// });
// 		});
// 	}

// 	function formatUI() {
// 		const whenHaveFileDisplay = haveFile ? "block" : "none";
// 		const whenDoNotHaveFileDisplay = haveFile ? "none" : "block";

// 		const whenHaveAndEditionFileDisplay =
// 			haveFile && editingHotspot ? "block" : "none";

// 		// Edit btn
// 		editHotspotBtn.css("display", whenHaveFileDisplay);

// 		// Image
// 		// editHotspotImageWrapper.css("display", whenHaveAndEditionFileDisplay);
// 		previewHotspotImageWrapper.css("display", whenHaveFileDisplay);

// 		// Input file
// 		// imageFileInput.css("display", whenDoNotHaveFileDisplay);
// 	}

// 	async function bindListeners() {
// 		imageFileInput.on("change", function () {
// 			const file = this.files[0];
// 			getBase64(file).then((base64File) => {
// 				// console.log("Change.......", base64File);
// 				base64Image = base64File;
// 				previewHotspotImage.attr("src", base64Image);
// 				haveFile = true;
// 				formatUI();
// 			});
// 		});

// 		editHotspotBtn.click(() => {
// 			if (editingHotspot) return;
// 			editingHotspot = true;
// 			editHotspotImage.attr("src", base64Image);
// 			formatUI();
// 		});
// 	}

// 	const getBase64 = (file) =>
// 		new Promise((resolve, reject) => {
// 			const reader = new FileReader();
// 			reader.readAsDataURL(file);
// 			reader.onload = () => resolve(reader.result);
// 			reader.onerror = reject;
// 		});

// 	// End
// })(jQuery);

jQuery(document).ready(function ($) {
	// UI Elements
	const uploadDescImageBtn = $("#upload-desc-image-btn");
	const previewHotspotImage = $("#preview-hotspot-image");
	const annotableImage = $("#annotatable-image");

	const uploadHotspotImageBtn = $("#upload-hotspot-image-btn");
	const saveHotspotBtn = $("#save-hotspot-btn");
	const deleteHotspotBtn = $("#delete-hotspot-btn");
	const saveAnnotatedImageBtn = $("#save-annotated-image-btn");
	const saveAnnotatedImageBtnText = $("#save-annotated-image-btn-text");

	const newSpotDescImage = $("#desc-hotspot-image");
	const newSpotTitle = $("#spot-title");
	const newSpotDesc = $("#spot-desc");
	const annotatedImageNameInput = $("#annotated-image-name-input");

	const editorWrapper = $("#theElement-a");
	const previewerWrapper = $("#theElement-0");

	// let previewHotSpots = $("#theElement-0 .HotspotPlugin_Hotspot");
	const previewSpotWrapper = $("#preview-spot-wrapper");
	const previewSpotTitle = $("#preview-spot-title");
	const previewSpotDescImage = $("#preview-spot-desc-image");
	const previewSpotDesc = $("#preview-spot-desc");
	const previewSpotCloseBtn = $("#preview-spot-close-btn");
	const btnSaveLoader = $("#btn-save-loader");
	// const hotspotEditWrapper = $(".hotspot-edit-wrapper");

	// const mainPage = $("#main-page");
	// const dataImageId = $("#data-image-id");
	// const imageId = dataImageId.attr("data-imageId");

	// console.log("id: ", dataImageId, imageId);

	const annotableImageForm = $("#annotable-image-form");
	// Endponts
	const actionPageUrl = annotableImageForm.attr("data-page");

	// Variables
	let hotspots = [];
	let currentDescImage = null;
	let currentX = null;
	let currentY = null;
	let annotableMediaImage = null;
	let shortcode = getAnnotatedImageShortCode();

	let loading = false;

	// alert(shortcode);
	const annotatedImageSerialized = annotableImageForm.attr(
		"data-annotatedImageHotspot"
	);
	// console.log("element: ", annotatedImageSerialized);
	let annotatedImageHotspot = null;
	if (annotatedImageSerialized) {
		annotatedImageHotspot = deserializeImageHotspot(annotatedImageSerialized);
	}

	console.log("AnnotatedImage: ", annotatedImageHotspot);

	// Entry point
	main();

	// Utils functions
	// -----------------------------------------
	function bindMediaUploaderListeners(cb) {
		var mediaUploader = wp.media({
			frame: "post",
			state: "insert",
			multiple: false,
		});

		return mediaUploader.on("insert", function () {
			var imageData = mediaUploader.state().get("selection").first().toJSON();

			cb(imageData);
		});
	}

	function throwIfNoImage(condition = !currentDescImage) {
		if (condition) {
			alert("There is no selected image");
			return;
		}
	}

	function uuidv4() {
		return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, (c) =>
			(
				c ^
				(crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (c / 4)))
			).toString(16)
		);
	}

	function setLoading(_) {
		loading = _;
		formatUI();
	}

	function toast(message, duration = 3000) {
		Toastify({
			text: message,
			duration,
			gravity: "bottom",
			position: "right",
			backgroundColor: "#1d2327",
			stopOnFocus: true,
		}).showToast();
	}
	// -----------------------------------------

	// Functions
	function formatUI() {
		const btnSaveLoaderDisplay = loading ? "block" : "none";
		const saveAnnotatedImageBtnTextDisplay = loading ? "none" : "block";
		const btnSaveOpacity = loading ? 0.7 : 1;
		const btnSaveText = loading ? "" : "Save Image";

		// console.log(btnSaveLoader, btnSaveLoaderDisplay);

		btnSaveLoader.css("display", btnSaveLoaderDisplay);
		saveAnnotatedImageBtn.css("opacity", btnSaveOpacity);
		// saveAnnotatedImageBtn.text(btnSaveText);
		// saveAnnotatedImageBtnText.css("display", saveAnnotatedImageBtnTextDisplay);

		if (currentDescImage) {
			// editorWrapper.css("display", "block");
			newSpotDescImage.attr("src", currentDescImage.url);
		} else {
			newSpotDescImage.attr("src", null);
			// editorWrapper.css("display", "none");
		}
		setAnnotableMediaImage();
	}

	function deserializeImageHotspot(serialized) {
		const image = JSON.parse(serialized);
		const hotspots = JSON.parse(image.data);
		const deserialized = {
			...image,
			hotspots,
			// hotspots: hotspots.map((spot) => ({
			// 	...spot,
			// 	image: JSON.parse(spot.image),
			// })),
			annotatedImage: JSON.parse(image.annotated_image),
		};
		return deserialized;
	}

	function getHotspotByCoordonatesId(x, y) {
		const locationId = getSpotLocationId(x, y);
		return hotspots.find((spot) => spot.locationId === locationId);
	}

	function setAnnotableMediaImage() {
		const imageUrl = annotableMediaImage ? annotableMediaImage.url : null;
		previewHotspotImage.attr("src", imageUrl);
		annotableImage.attr("src", imageUrl);
		editorWrapper.css("display", annotableMediaImage ? "block" : "none");
	}

	function openEditHotspotModal() {
		// do not rest currentX, currentY
		resetAddHotspotForm(false);
		const title = "Add a new hotspot the the image";
		const url = "#TB_inline?&width=600&height=550&inlineId=my-content-id";
		tb_show(title, url);
	}

	function closeEditHotspotModal() {
		tb_remove();
	}

	function handleNewHotspot(imageData) {
		const title = newSpotTitle.val();
		const desc = newSpotDesc.val();

		console.log("Desc: ", desc);

		if (!title) {
			alert("title is required");
			return;
		}

		if (!desc) {
			alert("description is required");
			return;
		}

		const exist = getHotspotByCoordonatesId(currentX, currentY);

		if (exist) {
			exist.title = title;
			exist.description = desc;
			exist.image = imageData;
		} else {
			const locationId = getSpotLocationId(currentX, currentY);

			const newHotspot = {
				locationId,
				// content:
				// 	"<img src='" + imageData.url + "' alt='" + imageData.alt + "'>",
				x: currentX,
				y: currentY,
				title,
				description: desc,
				image: imageData,
				// shortcode: getSpotShortCode(locationId),
			};

			hotspots.push(newHotspot);
			// console.log("New spot: ", hotspots);
			addSpotToHotspotEditor(newHotspot.x, newHotspot.y);
			addSpotToPreviewer(newHotspot.x, newHotspot.y);
		}

		// console.log("Spots: ", spots);
		// $("#theElement-0").hotspot({
		// 	mode: "display",
		// 	data: hotspots,
		// 	interactivity: "click",
		// });

		formatUI();
		closeEditHotspotModal();
		resetAddHotspotForm();
	}

	// function getPreviewSpot() {
	// 	previewHotSpots = $("#theElement-0 .HotspotPlugin_Hotspot");
	// 	return previewHotSpots;
	// }

	function previewHotspot(locationId) {
		const hotspot = hotspots.find((spot) => spot.locationId === locationId);

		if (!hotspot) {
			alert("Invalid hotspot");
			return;
		}

		// console.log("PREVIEW HOTSPOT");
		previewSpotTitle.text(hotspot.title);
		previewSpotDesc.html(hotspot.description);
		const image = hotspot.image;
		previewSpotDescImage.attr("src", image.url);
		// console.log(previewSpotDescImage, image.url);
		previewSpotWrapper.css("display", "block");
	}

	// function bindPreviewSpotListeners() {
	// 	getPreviewSpot();
	// 	previewHotSpots.map((index, spot) => {
	// 		// console.log("-->>", spot);
	// 		const previewSpot = $(spot);
	// 		const wrapper = previewSpot.find(".HotspotPlugin_Hotspot_Hidden");

	// 		// console.log("Wrapper: ", wrapper);
	// 		wrapper.css("display", "none!impotant");

	// 		// console.log(spot);
	// 		previewSpot.click(function () {
	// 			const locationIdEl = previewSpot.find(".Hotspot_locationId");
	// 			// console.log("locationId: ", locationIdEl.text());
	// 			previewHotspot(locationIdEl.text());
	// 		});
	// 	});
	// }

	function bindListeners() {
		// if (annotatedImageHotspot) {
		// 	$(window).on("resize", addSpotToPreviewer());
		// }
		// Medias Uploader
		const spotImageUploader = bindMediaUploaderListeners(function (imageData) {
			currentDescImage = imageData;
			formatUI();
		});

		const annotableImageUploader = bindMediaUploaderListeners(function (
			imageData
		) {
			throwIfNoImage(!imageData);
			annotableMediaImage = imageData;
			formatUI();
		});

		uploadDescImageBtn.click(function () {
			spotImageUploader.open();
		});

		uploadHotspotImageBtn.click(function () {
			annotableImageUploader.open();
		});

		// Buttons
		saveHotspotBtn.click(function () {
			throwIfNoImage();
			handleNewHotspot(currentDescImage);
			// previewHotspotImage.attr("src", currentDescImage.url);
		});

		deleteHotspotBtn.click(function () {
			const locationId = getSpotLocationId(currentX, currentY);
			hotspots = hotspots.filter((spot) => spot.locationId !== locationId);
			// console.log("HOTSPOTS", hotspots);

			// addSpotToPreviewer();
			removePointToHotspotEditor(locationId);
			closeEditHotspotModal();
			resetAddHotspotForm();
			// formatUI();
		});

		previewSpotCloseBtn.click(function () {
			previewSpotWrapper.css("display", "none");
		});

		saveAnnotatedImageBtn.click(function () {
			console.log("The page is: ", actionPageUrl);

			const name = annotatedImageNameInput.val();

			if (!name) {
				alert("The name is required");
				return;
			}

			if (hotspots.length === 0) {
				alert("There is no hotspot to save");
				return;
			}

			const payload = {
				name,
				// shortcode,
				annotated_image: JSON.stringify(annotableMediaImage),
				data: JSON.stringify(hotspots),
			};

			if (annotatedImageHotspot) {
				payload.ID = annotatedImageHotspot.ID;
			}

			console.log("Payload: ", payload);

			setLoading(true);

			$.ajax({
				method: "POST",
				url: actionPageUrl,
				data: JSON.stringify(payload),
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function (res) {
					//do what you want here...
					console.log(res);
					// window.location.href = "?page=wordpress-hotspot";
					setLoading(false);
					toast("Annotated Image saved");
				},
				error: function () {
					setLoading(false);
				},
			});
		});

		// bindPreviewSpotListeners();
	}

	// function getPreviewSpotLocationids() {
	// 	return previewHotSpots.map((spot) => {
	// 		const previewSpot = $(spot);
	// 		const locationId = previewSpot.find(".Hotspot_locationId");
	// 		console.log("locationId: ", locationId);
	// 	});
	// }

	function resetAddHotspotForm(resetCoordonates = true) {
		// console.log("reseting form.....");
		if (resetCoordonates) {
			currentX = null;
			currentY = null;
		}
		currentDescImage = null;
		newSpotTitle.val("");
		newSpotDesc.val("");
		newSpotDescImage.attr("src", null);
		formatUI();
	}

	function resetSpotPreviewer() {
		previewSpotWrapper.css("display", "none");
		previewSpotTitle.text("");
		previewSpotDesc.text("");
		previewHotspotImage.attr("src", null);
	}

	function getSpotLocationId(x, y) {
		return `${x}-${y}`;
	}

	function getAnnotatedImageShortCode(locationId) {
		return `${uuidv4()}-wordpress-hotspot`;
	}

	function prepareSpotEdition(spot) {
		newSpotTitle.val(spot.title);
		newSpotDesc.val(spot.description);
		currentDescImage = spot.image;
		currentX = spot.x;
		currentY = spot.y;
		formatUI();
	}

	function addSpotToHotspotEditor(x, y) {
		const point = $(
			`<div data-id="${getSpotLocationId(
				x,
				y
			)}" style="cursor: pointer; width: 20px; height: 20px; border-radius:50%; background: red; position: absolute; top: calc(${y}% - 10px); left: calc(${x}% - 10px)"></div>`
		);

		point.click(function () {
			const clickedSpot = getHotspotByCoordonatesId(x, y);
			// console.log("spot clicked....", clickedSpot);
			openEditHotspotModal(clickedSpot);
			prepareSpotEdition(clickedSpot);
		});

		console.log(point);

		editorWrapper.append(point);
	}

	function addSpotToPreviewer(x, y) {
		// // console.log("Adding spot...........s: ", hotspots);
		// $("#theElement-0").hotspot({
		// 	mode: "display",
		// 	data: hotspots, // [
		// 	// 	{
		// 	// 		x: 50,
		// 	// 		y: 50,
		// 	// 		// Title: "Roue",
		// 	// 		// Message: "Les roues",
		// 	// 	},
		// 	// ],
		// 	interactivity: "click",
		// });
		// bindPreviewSpotListeners();
		const point = $(
			`<div data-id="${getSpotLocationId(
				x,
				y
			)}" style="cursor: pointer; width: 20px; height: 20px; border-radius:50%; background: #1abc9c; position: absolute; top: calc(${y}% - 10px); left: calc(${x}% - 10px)"></div>`
		);

		point.click(function () {
			const clickedSpot = getHotspotByCoordonatesId(x, y);
			// console.log("spot clicked....", clickedSpot);
			// openEditHotspotModal(clickedSpot);
			// prepareSpotEdition(clickedSpot);
			if (!clickedSpot) {
				alert("Invalid spot");
				return;
			}
			previewHotspot(clickedSpot.locationId);
		});

		// console.log(point);

		previewerWrapper.append(point);
	}

	function removePointToHotspotEditor(locationId) {
		// const locationId = getSpotLocationId(x, y);
		const selector = `[data-id="${locationId}"]`;

		editorWrapper.find(selector).remove();
		previewerWrapper.find(selector).remove();
	}

	function fillEditionForm() {
		if (!annotatedImageHotspot) return;
		annotatedImageNameInput.val(annotatedImageHotspot.name);
		hotspots = annotatedImageHotspot.hotspots;
		annotableMediaImage = annotatedImageHotspot.annotatedImage;

		hotspots.map((spot) => {
			addSpotToPreviewer(spot.x, spot.y);
			addSpotToHotspotEditor(spot.x, spot.y);
		});
	}

	function init() {
		// mainPage.css("display", "none");
		currentDescImage = null;
		annotableMediaImage = null;
		if (annotatedImageHotspot) {
			fillEditionForm();
		}
		resetAddHotspotForm();
		resetSpotPreviewer();
		formatUI();
		bindListeners();
	}

	function main() {
		init();

		// annotableImage.hotspot({
		// 	showList: true,
		// 	items: hotspots,
		// 	onBeforeItemAdd: function (item) {
		// 		if (item.content == "") {
		// 			alert("Le contenu du hotspot ne peut pas être vide.");
		// 			return false;
		// 		}
		// 		return true;
		// 	},
		// });

		annotableImage.click(function (e) {
			var offset = $(this).offset();
			var width = $(this).width();
			var height = $(this).height();

			console.log(width, height);

			var x = e.pageX - offset.left;
			var y = e.pageY - offset.top;

			currentX = (x / width) * 100;
			currentY = (y / height) * 100;

			// var content = null; //prompt("Entrez le contenu de votre hotspot :");
			openEditHotspotModal();

			// if (content != null && content != "") {
			// 	var mediaUploader = wp.media({
			// 		frame: "post",
			// 		state: "insert",
			// 		multiple: false,
			// 	});
			// 	mediaUploader.on("insert", function () {
			// 		var imageData = mediaUploader
			// 			.state()
			// 			.get("selection")
			// 			.first()
			// 			.toJSON();
			// 		var newHotspot = {
			// 			content:
			// 				"<img src='" + imageData.url + "' alt='" + imageData.alt + "'>",
			// 			x: (x / width) * 100,
			// 			y: (y / height) * 100,
			// 		};
			// 		hotspots.push(newHotspot);
			// 		console.log(hotspots);

			// 		// console.log("Spots: ", spots);
			// 		$("#theElement-0").hotspot({
			// 			mode: "display",
			// 			data: hotspots, // [
			// 			// 	{
			// 			// 		x: 50,
			// 			// 		y: 50,
			// 			// 		// Title: "Roue",
			// 			// 		// Message: "Les roues",
			// 			// 	},
			// 			// ],
			// 			interactivity: "click",
			// 		});

			// 		addPointToHotspotEditor(newHotspot.x, newHotspot.y);

			// 		// $("#theElement-0")
			// 		// 	.hotspot("destroy")
			// 		// 	.hotspot({
			// 		// 		showList: true,
			// 		// 		items: hotspots,
			// 		// 		onBeforeItemAdd: function (item) {
			// 		// 			if (item.content == "") {
			// 		// 				alert("Le contenu du hotspot ne peut pas être vide.");
			// 		// 				return false;
			// 		// 			}
			// 		// 			return true;
			// 		// 		},
			// 		// 	});

			// 		// annotableImage
			// 		// 	.hotspot("destroy")
			// 		// 	.hotspot({
			// 		// 		showList: true,
			// 		// 		items: hotspots,
			// 		// 		onBeforeItemAdd: function (item) {
			// 		// 			if (item.content == "") {
			// 		// 				alert("Le contenu du hotspot ne peut pas être vide.");
			// 		// 				return false;
			// 		// 			}
			// 		// 			return true;
			// 		// 		},
			// 		// 	});
			// 	});
			// 	mediaUploader.open();
			// } else if (content != null) {
			// 	var newHotspot = {
			// 		content: content,
			// 		x: x,
			// 		y: y,
			// 	};
			// 	hotspots.push(newHotspot);
			// 	annotableImage.hotspot("destroy").hotspot({
			// 		showList: true,
			// 		items: hotspots,
			// 		onBeforeItemAdd: function (item) {
			// 			if (item.content == "") {
			// 				alert("Le contenu du hotspot ne peut pas être vide.");
			// 				return false;
			// 			}
			// 			return true;
			// 		},
			// 	});
			// }
		});
	}
});

// jQuery(document).ready(function ($) {
// 	$("#my-modal").hide();
// 	// Ouvrir la modale lorsque le bouton est cliqué
// 	$("#my-modal-button").click(function () {
// 		$("#my-modal").fadeIn();
// 	});

// 	// Fermer la modale lorsque le bouton close est cliqué
// 	$(".close").click(function () {
// 		$("#my-modal").fadeOut();
// 	});

// 	// Fermer la modale lorsque l'utilisateur clique en dehors de la boîte modale
// 	$(window).click(function (event) {
// 		if (event.target.id === "my-modal") {
// 			$("#my-modal").fadeOut();
// 		}
// 	});
// });
