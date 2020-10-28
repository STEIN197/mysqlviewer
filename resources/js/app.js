function main(e) {
	$("select[name='locale']").change(function($e) {
		Api.Locale.change(this.value, function() {
			location.reload();
		});
	});

	$(".js-split-pane").each(function() {
		Split($(this).children().toArray(), {
			gutterSize: 6,
			sizes: [].slice.call(this.children).map(e => +e.getAttribute("data-size"))
		});
	});

	Accordion.init();
	$("body").css("opacity", 1);
}

var Api = {
	PREFIX: "api",
	makeUrl: function(path) {
		var prefix = "/" + Api.PREFIX + "/";
		var result;
		if (path)
			result = prefix + path + "/";
		else
			result = prefix;
		return result.replace(/\/{2,}/g, "/");
	},
	Locale: {
		change: function(locale, callback) {
			axios.get(Api.makeUrl(), {
				params: {
					locale: locale
				}
			}).then(callback);
		}
	},
	Sidebar: {
		onToggle: function() {
			
		}
	}
}

document.addEventListener("DOMContentLoaded", main);
