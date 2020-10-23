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
			// $.ajax(Api.makeUrl(), {
			// 	data: {
			// 		locale: locale
			// 	},
			// 	complete: callback
			// });
		}
	}
}

document.addEventListener("DOMContentLoaded", main);
