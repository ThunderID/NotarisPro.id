;window.loadingAnimation = {
    changeColor : function (color) {
		window.appLoading.setColor(color);
	},
	loadingStart : function () {
		window.appLoading.start();
	},
	loadingStop : function () {
		window.appLoading.stop();
	},
	init : function () {
		window.loadingAnimation.changeColor('');
	}
}